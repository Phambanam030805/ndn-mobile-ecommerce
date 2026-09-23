<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Đăng nhập / Đăng ký / Quên mật khẩu cho người dùng
 * CodeIgniter 3
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Mkhachhang $Mkhachhang
 * @property Mdanhmuc $Mdanhmuc
 * @property array $data
 */
class Dangnhap extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mcauhinh');
        $this->load->model('frontend/Msanpham');
        $this->data['com']='dangnhap';
    }

    public function dangky()
    {
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|is_unique[users.username]|min_length[5]|max_length[32]');
        $this->form_validation->set_rules('name', 'Họ và tên', 'required');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[32]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|valid_email');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|min_length[10]|max_length[11]|numeric');

        if($this->form_validation->run() == TRUE) {
            $data = array(
                'username' => $this->input->post('username'),
                'fullname' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'password' => md5($this->input->post('password')),
                'role' => 3, // Vai trò là khách hàng
                'status' => 1,
                'trash' => 1,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->Mkhachhang->customer_insert($data);
            
            $customer_id = $this->db->insert_id();
            
            // Tự động tạo mã giảm giá cho thành viên mới 50k
            $coupon_code = 'WELCOME-' . strtoupper(random_string('alnum', 8));
            $coupon = array(
                'code' => $coupon_code,
                'discount' => '50000',
                'limit_number' => '1',
                'number_used' => '0',
                'expiration_date' => date('Y-m-d', strtotime('+1 month')),
                'description' => 'Mã giảm giá 50.000đ dành cho thành viên mới đăng ký',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 1,
                'trash' => 1,
                'customer_id' => $customer_id
            );
            $this->db->insert('coupons', $coupon);
            
            $this->session->set_flashdata('success', 'Đăng ký tài khoản thành công! Bạn nhận được 1 mã giảm giá 50.000đ: <strong>' . $coupon_code . '</strong>');
            redirect('dang-nhap', 'refresh');
        }
        $this->data['title']='NDN Mobile - Đăng ký tài khoản';
        $this->data['view']='dangky';
        $this->load->view('frontend/layout', $this->data);
    }

    public function dangnhap()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|min_length[5]|max_length[32]');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[32]');
        if($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $user = $this->Mkhachhang->customer_login($username, $password);
            if($user) {
                $this->session->set_userdata('sessionKhachHang', $user);
                $this->session->set_userdata('id', $user['id']);
                $this->session->set_userdata('email', $user['email']);
                $this->session->set_userdata('fullname', $user['fullname']);
                if($this->session->userdata('cart')) {
                    redirect('gio-hang', 'refresh');
                } else {
                    redirect('trang-chu', 'refresh');
                }
            } else {
                $this->data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
            }
        }
        $this->data['title']='NDN Mobile - Đăng nhập';
        $this->data['view']='dangnhap';
        $this->load->view('frontend/layout', $this->data);
    }

    public function dangxuat()
    {
        $this->session->unset_userdata('sessionKhachHang');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('fullname');
        redirect('trang-chu', 'refresh');
    }
}

