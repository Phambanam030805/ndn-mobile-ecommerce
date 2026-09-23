<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Mlienhe $Mlienhe
 * @property Mnguoidung $Mnguoidung
 * @property Mdonhang $Mdonhang
 * @property Mchitietdonhang $Mchitietdonhang
 * @property Phantrang $phantrang
 * @property array $data
 */
class Orders extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('backend/Mnguoidung');
    $this->load->model('backend/Msanpham');
    $this->load->model('backend/Mdonhang');
    $this->load->model('backend/Mchitietdonhang');
    $this->load->model('backend/Mcauhinh');
    $this->load->model('frontend/Mkhachhang');
    $this->load->model('frontend/Mtinhthanh');
    $this->load->model('frontend/Mquanhuyen');
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
    $limit=10;
    $current=$this->phantrang->PageCurrent();
    $first=$this->phantrang->PageFirst($limit, $current);
    $total=$this->Mdonhang->orders_count();
    $this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/orders');
    $this->data['list']=$this->Mdonhang->orders_listorders($limit,$first);
    $this->data['view']='index';
    $this->data['title']='Danh sách đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  public function detail($id)
  {
    $this->data['id'] = $id;
    $this->data['view']='detail';
    $this->data['title']='Chi tiết đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  public function view($id)
  {
    $this->data['id'] = $id;
    $this->data['view']='view';
    $this->data['title']='Chi tiết đơn hàng';
    $this->load->view('backend/layout', $this->data);
  }

  public function status($id)
  {
    $row=$this->Mdonhang->orders_detail($id);
    $status = $row['status'];
    if($status == 0) // Mới -> Đã xác nhận
    {
      $status = 1;
      $mydata= array('status' => $status);
      $this->Mdonhang->orders_update($mydata, $id);
      redirect('admin/orders','refresh');
    }
    else if ($status == 1) // Đang giao -> Đã giao
    {
        $status = 2;
        $mydata= array('status' => $status);
        $this->Mdonhang->orders_update($mydata, $id);

        // Cập nhật số lượng đã bán (number_buy) và trừ kho khi đơn hàng thành công
        $rowdetail = $this->Mchitietdonhang->orderdetail_orderid($id);
        foreach ($rowdetail as  $value) {
            $idproduct = $value['product_id'];
            $countproduct = $value['count'];
            
            // Lấy thông tin sản phẩm hiện tại
            $product = $this->Msanpham->product_detail_id($idproduct);
            $current_number_buy = $this->Mdonhang->product_number_buy($idproduct);
            
            $mydata_prod = array(
                'number_buy' => $current_number_buy + $countproduct, // Tăng số lượng đã bán
                'number' => $product['number'] - $countproduct // Trừ số lượng trong kho
            );
            $this->Mdonhang->orders_update_number_product($mydata_prod, $idproduct);
        }
        $this->session->set_flashdata('success', 'Đã giao thành công đơn hàng '.$row['orderCode']);
        redirect('admin/orders','refresh');
    }
    else
    {
      $this->session->set_flashdata('error', 'Đơn hàng không thể chuyển đổi trạng thái tiếp!');
      redirect('admin/orders','refresh');
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
    $status = $row['status'];
    if($status == 1){
      $this->session->set_flashdata('error', 'Đơn hàng '.$row['orderCode'].' đang được giao, không thể lưu !');
      redirect('admin/orders','refresh');
    }else{
      $mydata= array('trash' => 0);
      $this->Mdonhang->orders_update($mydata, $id);
      $this->session->set_flashdata('success', 'lưu đơn hàng '.$row['orderCode'].' vào thùng rác thành công');
      redirect('admin/orders','refresh');
    }
  }

  public function restore($id)
  {
    $this->Mdonhang->orders_restore($id);
    $this->session->set_flashdata('success', 'Khôi phục đơn hàng thành công');
    redirect('admin/orders/recyclebin','refresh');
  }

  public function cancelorder($id){
    $row=$this->Mdonhang->orders_detail($id);
    $status = $row['status'];
    if($status == 0 || $status == 1)
    {
      $status = 4;
      $mydata= array('status' => $status);
      $this->Mdonhang->orders_update($mydata, $id);
      redirect('admin/orders','refresh');
    }
  }
}