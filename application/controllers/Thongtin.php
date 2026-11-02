<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Thông tin cá nhân & Quản lý đơn hàng khách hàng
 * Hardened IDOR Protection & Bcrypt Password Reset Architecture
 *
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Form_validation $form_validation
 * @property Mlienhe $Mlienhe
 * @property Mnguoidung $Mnguoidung
 * @property Mdonhang $Mdonhang
 * @property Mchitietdonhang $Mchitietdonhang
 * @property Mthongtinkhach $Mthongtinkhach
 * @property Mkhachhang $Mkhachhang
 * @property Mcauhinh $Mcauhinh
 * @property Phantrang $phantrang
 * @property array $data
 */
class Thongtin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['com'] = 'thongtin';
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdonhang');
        $this->load->model('frontend/Mchitietdonhang');
        $this->load->model('frontend/Mthongtinkhach');
        $this->load->model('frontend/Mtinhthanh');
        $this->load->model('frontend/Mquanhuyen');
        $this->load->model('frontend/Mcauhinh');
        $this->load->library('session');
        $this->load->library('form_validation');

        if (!$this->session->userdata('sessionKhachHang')) {
            redirect('dang-nhap', 'refresh');
            return;
        }

        $this->data['info'] = $this->Mthongtinkhach->customer_detail_id($this->session->userdata('id'));
    }
    
    /**
     * Trang thông tin hồ sơ & lịch sử đơn hàng
     * URL: /thong-tin-khach-hang
     */
    public function index() {
        $customer_id = (int)$this->session->userdata('id');
        $this->data['order_stats'] = $this->Mthongtinkhach->customer_order_stats($customer_id);
        $this->data['title']       = 'NDN Mobile - Thông tin tài khoản';
        $this->data['view']        = 'index';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Xem chi tiết đơn hàng (Chặn IDOR tuyệt đối)
     * URL: /thongtin/order/{order_id}
     */
    public function order($id = null) {
        if (!$id || !is_numeric($id)) {
            $aurl = explode('/', uri_string());
            $id = isset($aurl[2]) && is_numeric($aurl[2]) ? (int)$aurl[2] : null;
        }

        if (!$id) {
            redirect('thong-tin-khach-hang', 'refresh');
            return;
        }

        $currentCustomerId = (int)$this->session->userdata('id');

        // BẢO MẬT IDOR: Buộc đơn hàng phải thuộc về chính khách hàng đang đăng nhập
        $info = $this->db->where('id', (int)$id)
                         ->where('customer_id', $currentCustomerId)
                         ->where('trash', 1)
                         ->get('orders')
                         ->row_array();

        if (!$info) {
            $this->session->set_flashdata('error', 'Đơn hàng không tồn tại hoặc bạn không có quyền xem thông tin đơn hàng này!');
            redirect('thong-tin-khach-hang', 'refresh');
            return;
        }

        // Truy vấn số tiền chiết khấu thực tế của coupon
        if (!empty($info['coupon'])) {
            $coupon_detail = $this->db->where('id', (int)$info['coupon'])->get('coupons')->row_array();
            $info['coupon_amount'] = $coupon_detail ? (float)$coupon_detail['discount'] : 0;
        } else {
            $info['coupon_amount'] = 0;
        }

        $this->data['orderid'] = $id;
        $this->data['row']     = $this->Mchitietdonhang->orderdetail_order_join_product($id);
        $this->data['info']    = $info;
        $this->data['title']   = 'NDN Mobile - Chi tiết đơn hàng #' . $info['orderCode'];  
        $this->data['view']    = 'detail';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Đổi mật khẩu tài khoản khách hàng (Hỗ trợ Bcrypt / Seamless Rehash)
     * URL: /thong-tin-khach-hang/reset_password
     */
    public function reset_password() {
        $customerId = (int)$this->session->userdata('id');
        $user = $this->db->where('id', $customerId)->get('users')->row_array();
        $this->data['row'] = $user;

        $this->form_validation->set_rules('password_old', 'Mật khẩu cũ', 'required|callback_check_password');
        $this->form_validation->set_rules('password', 'Mật khẩu mới', 'required|min_length[6]|max_length[64]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');

        if ($this->form_validation->run() === TRUE) {
            $newPassword = (string)$this->input->post('password');
            $bcryptHash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);

            $this->Mkhachhang->customer_update(['password' => $bcryptHash], $customerId);
            
            $this->session->set_flashdata('success', 'Đổi mật khẩu tài khoản thành công!');
            redirect('thong-tin-khach-hang', 'refresh');
            return;
        }

        $this->data['title'] = 'NDN Mobile - Đổi mật khẩu';
        $this->data['view']  = 'reset_password';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Hủy đơn hàng (Chặn IDOR & Giới hạn chỉ hủy khi đơn chưa được duyệt)
     * URL: /thongtin/update/{order_id}
     */
    public function update($id = null) {
        if (!$id || !is_numeric($id)) {
            redirect('thong-tin-khach-hang', 'refresh');
            return;
        }

        $currentCustomerId = (int)$this->session->userdata('id');

        // BẢO MẬT IDOR: Chỉ cho phép thao tác trên đơn hàng của chính mình
        $order = $this->db->where('id', (int)$id)
                          ->where('customer_id', $currentCustomerId)
                          ->where('trash', 1)
                          ->get('orders')
                          ->row_array();

        if (!$order) {
            $this->session->set_flashdata('error', 'Không tìm thấy đơn hàng cần thao tác!');
            redirect('thong-tin-khach-hang', 'refresh');
            return;
        }

        $status = (int)$order['status'];
        if ($status === 0) {
            // Hủy đơn (status = 3)
            $this->Mdonhang->order_update(['status' => 3], (int)$id);
            $this->session->set_flashdata('success', 'Đã hủy đơn hàng #' . $order['orderCode'] . ' thành công!');
        } else {
            $this->session->set_flashdata('error', 'Đơn hàng đã được xác nhận hoặc đang vận chuyển, không thể hủy!');
        }

        redirect('thong-tin-khach-hang', 'refresh');
    }

    /**
     * Callback xác minh mật khẩu cũ (tương thích đa thuật toán Bcrypt, MD5, SHA1)
     */
    public function check_password($password) {
        $customerId = (int)$this->session->userdata('id');
        $user = $this->db->where('id', $customerId)->get('users')->row_array();

        if (!$user) {
            $this->form_validation->set_message(__FUNCTION__, 'Tài khoản không tồn tại!');
            return FALSE;
        }

        $storedHash = (string)$user['password'];
        $isValid = false;

        if (password_verify($password, $storedHash)) {
            $isValid = true;
        } elseif (md5($password) === $storedHash) {
            $isValid = true;
        } elseif (sha1($password) === $storedHash) {
            $isValid = true;
        }

        if (!$isValid) {
            $this->form_validation->set_message(__FUNCTION__, 'Mật khẩu cũ không chính xác!');
            return FALSE;
        }

        return TRUE;
    }
}
