<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Mlienhe $Mlienhe
 * @property Mnguoidung $Mnguoidung
 * @property Mdonhang $Mdonhang
 * @property Phantrang $phantrang
 * @property array $data
 */
class Customer extends CI_Controller {

    protected $data = array(); 

    public function __construct()
    {
        parent::__construct();
        // Nạp các model cần thiết
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Mdonhang');
        $this->load->model('frontend/Mkhachhang');

        // Kiểm tra đăng nhập admin
        if(!$this->session->userdata('sessionadmin'))
        {
            redirect('admin/user/login', 'refresh');
        }

        // Gán thông tin cơ bản
        $this->data['user'] = $this->session->userdata('sessionadmin');
        $this->data['com']  = 'customer';
    }

    public function index()
    {
        $this->load->library('phantrang');

        $search = $this->input->get('search', TRUE);
        $search = trim($search ? $search : '');

        $limit   = 10;
        $current = $this->phantrang->PageCurrent();
        $first   = $this->phantrang->PageFirst($limit, $current);
        $total   = $this->Mnguoidung->user_count([3], $search);

        $url = 'admin/customer';
        if (!empty($search)) {
            $url .= '?search=' . urlencode($search);
        }

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
        $this->data['list']         = $this->Mnguoidung->user_all([3], $limit, $first, $search);
        $this->data['search']       = $search;
        $this->data['total']        = $total;
        $this->data['view']         = 'index';
        $this->data['title']        = 'Danh sách khách hàng';
        $this->load->view('backend/layout', $this->data);
    }

    /**
     * Chi tiết hồ sơ khách hàng & lịch sử đơn hàng
     * Tuân thủ quyền riêng tư: Admin chỉ xem thông tin & quản lý trạng thái tài khoản
     */
    public function detail($id)
    {
        $this->data['row'] = $this->Mnguoidung->user_detail($id);
        if(!$this->data['row'] || (int)$this->data['row']['role'] !== 3)
        {
            $this->session->set_flashdata('error', 'Khách hàng không tồn tại hoặc không hợp lệ!');
            redirect('admin/customer');
            return;
        }

        // Xử lý cập nhật trạng thái tài khoản (Hoạt động / Tạm khóa)
        if($this->input->post())
        {
            $status = (int)$this->input->post('status', TRUE);
            $mydata = array('status' => $status);
            $this->Mnguoidung->user_update($mydata, $id);

            $status_msg = ($status === 1) 
                ? 'Đã mở khóa tài khoản khách hàng [' . $this->data['row']['fullname'] . '] thành công!'
                : 'Đã tạm khóa tài khoản khách hàng [' . $this->data['row']['fullname'] . ']!';
            $this->session->set_flashdata('success', $status_msg);
            redirect('admin/customer/detail/' . $id);
            return;
        }

        // Lấy toàn bộ đơn hàng của khách hàng này (kể cả đã lưu trữ, loại trừ thùng rác)
        $this->db->where('customer_id', $id);
        $this->db->where('trash', 1);
        $this->db->order_by('id', 'desc');
        $orders = $this->db->get('orders')->result_array();
        $this->data['orders'] = $orders;

        // Thống kê đơn hàng và chi tiêu
        $total_orders      = count($orders);
        $total_spent       = 0;
        $completed_orders  = 0;
        $delivering_orders = 0;
        $canceled_orders   = 0;
        $pending_orders    = 0;

        foreach ($orders as $ord) {
            $st = (int)$ord['status'];
            if ($st === 2) {
                $completed_orders++;
                $total_spent += (int)$ord['money'];
            } elseif ($st === 1) {
                $delivering_orders++;
            } elseif ($st === 3 || $st === 4) {
                $canceled_orders++;
            } elseif ($st === 0) {
                $pending_orders++;
            }
        }

        // Phân hạng khách hàng dựa trên chi tiêu thực tế
        if ($total_spent >= 25000000) {
            $rank_title = 'Khách hàng Kim Cương (VIP Diamond)';
            $rank_class = 'rank-diamond';
            $rank_badge = '💎 Kim Cương';
        } elseif ($total_spent >= 10000000) {
            $rank_title = 'Khách hàng Vàng (VIP Gold)';
            $rank_class = 'rank-gold';
            $rank_badge = '⭐ Hạng Vàng';
        } elseif ($total_spent >= 3000000) {
            $rank_title = 'Khách hàng Thân thiết (Silver)';
            $rank_class = 'rank-silver';
            $rank_badge = '🥈 Thân thiết';
        } else {
            $rank_title = 'Khách hàng Tiêu chuẩn (Standard)';
            $rank_class = 'rank-bronze';
            $rank_badge = '🥉 Tiêu chuẩn';
        }

        $this->data['stat'] = [
            'total_orders'      => $total_orders,
            'total_spent'       => $total_spent,
            'completed_orders'  => $completed_orders,
            'delivering_orders' => $delivering_orders,
            'canceled_orders'   => $canceled_orders,
            'pending_orders'    => $pending_orders,
            'rank_title'        => $rank_title,
            'rank_class'        => $rank_class,
            'rank_badge'        => $rank_badge
        ];

        $this->data['view']  = 'detail';
        $this->data['title'] = 'Hồ sơ khách hàng - ' . $this->data['row']['fullname'];
        $this->load->view('backend/layout', $this->data);
    }

    /**
     * Chuyển hướng update sang trang detail (Bảo vệ dữ liệu cá nhân)
     */
    public function update($id)
    {
        redirect('admin/customer/detail/' . $id);
    }

    /**
     * Bật/tắt trạng thái hoạt động của khách hàng nhanh từ bảng danh sách
     */
    public function status($id)
    {
        $row = $this->Mnguoidung->user_detail($id);
        if(!$row || (int)$row['role'] !== 3)
        {
            $this->session->set_flashdata('error', 'Khách hàng không tồn tại!');
            redirect('admin/customer');
            return;
        }

        $new_status = ($row['status'] == 1) ? 0 : 1;
        $this->Mnguoidung->user_update(['status' => $new_status], $id);

        $msg = ($new_status === 1) 
            ? 'Đã kích hoạt lại tài khoản khách hàng [' . $row['fullname'] . ']!' 
            : 'Đã tạm khóa tài khoản khách hàng [' . $row['fullname'] . ']!';
        $this->session->set_flashdata('success', $msg);
        redirect('admin/customer');
    }

    public function recyclebin()
    {
        $this->load->library('phantrang');
        $limit   = 10;
        $current = $this->phantrang->PageCurrent();
        $first   = $this->phantrang->PageFirst($limit, $current);
        $total   = $this->Mnguoidung->user_trash_count([3]);

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url='admin/customer/recyclebin');
        $this->data['list'] = $this->Mnguoidung->user_trash([3], $limit, $first);
        $this->data['view'] = 'recyclebin';
        $this->data['title'] = 'Thùng rác khách hàng';
        $this->load->view('backend/layout', $this->data);
    }

    public function trash($id)
    {
        $this->db->where('customer_id', $id);
        $count = $this->db->count_all_results('orders');

        if($count > 0)
        {
            $this->session->set_flashdata('error', 'Khách hàng đã đặt hàng, không thể xóa !');
            redirect('admin/customer', 'refresh');
        }
        else
        {
            $mydata = array('trash' => 0);
            $this->Mnguoidung->user_update($mydata, $id);
            $this->session->set_flashdata('success', 'Xóa khách hàng vào thùng rác thành công');
            redirect('admin/customer', 'refresh');
        }
    }

    public function restore($id)
    {
        $this->Mnguoidung->user_restore($id);
        $this->session->set_flashdata('success', 'Khôi phục khách hàng thành công');
        redirect('admin/customer/recyclebin', 'refresh');
    }

    public function delete($id)
    {
        $this->Mnguoidung->user_delete($id);
        $this->session->set_flashdata('success', 'Xóa khách hàng thành công');
        redirect('admin/customer/recyclebin', 'refresh');
    }
}
