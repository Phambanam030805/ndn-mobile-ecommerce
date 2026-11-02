<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Quản lý Đơn hàng - Phân hệ Admin
 * Transaction-Safe & Accurate Inventory Management Architecture
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Mdonhang $Mdonhang
 * @property Msanpham $Msanpham
 * @property Mchitietdonhang $Mchitietdonhang
 * @property Phantrang $phantrang
 * @property array $data
 */
class Orders extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('backend/Mdonhang');
    $this->load->model('backend/Msanpham');
    $this->load->model('backend/Mchitietdonhang');
    $this->load->model('backend/Mcustomer');
    $this->load->library('session');
    
    // Kiểm tra quyền Admin/Staff
    if(!$this->session->userdata('sessionadmin'))
    {
      redirect('admin/user/login','refresh');
    }
    $this->data['user']=$this->session->userdata('sessionadmin');
    $this->data['com']='orders';
  }

  public function index()
  {
    $this->load->library('phantrang');
    $limit = 10;
    $current = $this->phantrang->PageCurrent();
    $first = $this->phantrang->PageFirst($limit, $current);

    // Lấy tham số tìm kiếm và lọc trạng thái từ GET
    $search = $this->input->get('search', TRUE);
    $status = $this->input->get('status', TRUE);

    // Đếm tổng số đơn hàng theo bộ lọc
    $total = $this->Mdonhang->orders_count($search, $status);

    // Tạo link phân trang giữ nguyên các tham số tìm kiếm
    $queryString = [];
    if (!empty($search)) $queryString['search'] = $search;
    if ($status !== '' && $status !== null) $queryString['status'] = $status;
    $url = 'admin/orders';
    if (!empty($queryString)) {
      $url .= '?' . http_build_query($queryString);
    }

    $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
    $this->data['list'] = $this->Mdonhang->orders_listorders($limit, $first, $search, $status);
    $this->data['search'] = $search;
    $this->data['status'] = $status;
    $this->data['total'] = $total;
    $this->data['view'] = 'index';
    $this->data['title'] = 'Danh sách đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  public function detail($id)
  {
    $row = $this->Mdonhang->orders_detail($id);
    if(!$row) {
      $this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
      redirect('admin/orders');
    }
    
    // Truy vấn thông tin khách hàng an toàn qua bảng users
    $cid = !empty($row['customer_id']) ? $row['customer_id'] : (!empty($row['customerid']) ? $row['customerid'] : 0);
    $customer = null;
    if ($cid > 0) {
      $customer = $this->Mcustomer->customer_detail($cid);
    }

    $this->data['id'] = $id;
    $this->data['row'] = $row;
    $this->data['customer'] = $customer;
    $this->data['orderdetail'] = $this->Mchitietdonhang->orderdetail_orderid($id);
    $this->data['view'] = 'detail';
    $this->data['title'] = 'Chi tiết đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  /**
   * Cập nhật tiến độ đơn hàng & Xử lý tồn kho chính xác tuyệt đối
   * Luồng:
   * 0 (Chờ duyệt) -> 1 (Đang giao hàng)
   * 1 (Đang giao hàng) -> 2 (Đã giao thành công -> TĂNG number_buy, GIỮ NGUYÊN number)
   */
  public function status($id)
  {
    $row = $this->Mdonhang->orders_detail($id);
    if(!$row)
    {
      $this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
      redirect('admin/orders');
      return;
    }

    $status = (int)$row['status'];

    if($status === 0) 
    {
      // Chờ duyệt -> Đang giao hàng
      $this->Mdonhang->orders_update(['status' => 1], (int)$id);
      $this->session->set_flashdata('success', 'Đã duyệt đơn hàng #' . $row['orderCode'] . ' thành công! Trạng thái: Đang giao hàng.');
      redirect('admin/orders');
      return;
    }
    elseif ($status === 1) 
    {
      // Đang giao -> Đã giao thành công: Sử dụng Transaction an toàn
      $this->db->trans_start();

      $this->Mdonhang->orders_update(['status' => 2], (int)$id);

      // Cập nhật số lượng đã bán (number_buy). Tổng số máy đã nhập (number) được giữ nguyên vẹn
      $rowdetail = $this->Mchitietdonhang->orderdetail_orderid((int)$id);
      if(!empty($rowdetail)) {
        foreach ($rowdetail as $value) {
          $idproduct = (int)$value['product_id'];
          $countproduct = (int)$value['count'];
          
          // Tăng an toàn number_buy bằng atomic increment
          $this->db->set('number_buy', 'number_buy + ' . $countproduct, FALSE);
          $this->db->where('id', $idproduct);
          $this->db->update('products');
        }
      }

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('error', 'Có lỗi xảy ra khi xác nhận giao hàng và cập nhật kho!');
      } else {
        $this->session->set_flashdata('success', 'Đã xác nhận thanh toán & giao thành công đơn hàng #' . $row['orderCode'] . '!');
      }
      redirect('admin/orders');
      return;
    }
    else
    {
      $this->session->set_flashdata('error', 'Đơn hàng đã hoàn tất hoặc đã hủy, không thể chuyển đổi trạng thái!');
      redirect('admin/orders');
      return;
    }
  }

  public function recyclebin()
  {
    $this->load->library('phantrang');
    $limit=10;
    $current=$this->phantrang->PageCurrent();
    $first=$this->phantrang->PageFirst($limit, $current);
    $total=$this->Mdonhang->orders_trash_count();
    $this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/orders/recyclebin');
    $this->data['list']=$this->Mdonhang->orders_trash($limit, $first);
    $this->data['view']='recyclebin';
    $this->data['title']='Thùng rác đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  public function trash($id)
  {
    $row=$this->Mdonhang->orders_detail($id);
    if(!$row) {
      $this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
      redirect('admin/orders');
      return;
    }
    $status = (int)$row['status'];
    if($status === 1){
      $this->session->set_flashdata('error', 'Đơn hàng #' . $row['orderCode'] . ' đang được giao, không thể lưu vào thùng rác!');
      redirect('admin/orders');
      return;
    }else{
      $this->Mdonhang->orders_update(['trash' => 0], (int)$id);
      $this->session->set_flashdata('success', 'Đã lưu đơn hàng #' . $row['orderCode'] . ' vào thùng rác thành công!');
      redirect('admin/orders');
      return;
    }
  }

  public function restore($id)
  {
    $this->Mdonhang->orders_restore((int)$id);
    $this->session->set_flashdata('success', 'Khôi phục đơn hàng thành công!');
    redirect('admin/orders/recyclebin');
  }

  /**
   * Hủy đơn hàng từ phía quản trị viên (Nhân viên hủy đơn -> status = 4)
   * Nếu đơn hàng đã hoàn tất giao thành công (status = 2), hoàn trả lại số lượng number_buy cho kho
   */
  public function cancelorder($id)
  {
    $row = $this->Mdonhang->orders_detail($id);
    if(!$row) {
      $this->session->set_flashdata('error', 'Đơn hàng không tồn tại!');
      redirect('admin/orders');
      return;
    }

    $status = (int)$row['status'];
    if($status === 0 || $status === 1)
    {
      $this->Mdonhang->orders_update(['status' => 4], (int)$id);
      $this->session->set_flashdata('success', 'Đã hủy đơn hàng #' . $row['orderCode'] . ' thành công!');
      redirect('admin/orders');
      return;
    }
    elseif ($status === 2)
    {
      // Nếu hủy đơn đã giao thành công (ví dụ hàng bị trả lại): Hoàn lại số lượng đã bán (number_buy)
      $this->db->trans_start();

      $this->Mdonhang->orders_update(['status' => 4], (int)$id);

      $rowdetail = $this->Mchitietdonhang->orderdetail_orderid((int)$id);
      if(!empty($rowdetail)) {
        foreach ($rowdetail as $value) {
          $idproduct = (int)$value['product_id'];
          $countproduct = (int)$value['count'];
          
          // Trừ lại số lượng đã bán, đảm bảo không âm
          $this->db->set('number_buy', 'GREATEST(0, number_buy - ' . $countproduct . ')', FALSE);
          $this->db->where('id', $idproduct);
          $this->db->update('products');
        }
      }

      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE) {
        $this->session->set_flashdata('error', 'Có lỗi khi hủy đơn và hoàn trả kho hàng!');
      } else {
        $this->session->set_flashdata('success', 'Đã hủy đơn hàng #' . $row['orderCode'] . ' và hoàn kho thành công!');
      }
      redirect('admin/orders');
      return;
    }
    else
    {
      $this->session->set_flashdata('error', 'Đơn hàng đã ở trạng thái hủy, không thể thao tác thêm!');
      redirect('admin/orders');
      return;
    }
  }
}