<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Controller - Lớp cơ sở cho toàn bộ ứng dụng
 */
class MY_Controller extends CI_Controller {
    
    public $data = array();

    public function __construct() {
        parent::__construct();
        
        // Nạp các Model/Library dùng chung cho toàn hệ thống
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Msanpham');
        $this->load->model('backend/Mnhacungcap'); // Nạp để lấy tên thương hiệu
        $this->load->library('session');
    }
}

/**
 * Controller dùng chung cho tất cả các trang Admin
 */
class Admin_Controller extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // 1. Kiểm tra đăng nhập Admin tập trung tại đây
        if(!$this->session->userdata('sessionadmin')) {
            redirect('admin/user/login', 'refresh');
        }

        // 2. Lấy thông tin Admin đang đăng nhập
        $this->data['user'] = $this->session->userdata('sessionadmin');
        
        // 3. Nạp các Model chuyên dùng cho Admin
        $this->load->model('backend/Mdonhang');
    }

    /**
     * Hàm kiểm tra quyền hạn (Chỉ SuperAdmin mới được vào)
     */
    protected function _check_super_admin() {
        if($this->data['user']['role'] != 1) {
            redirect('admin/E403/index', 'refresh');
        }
    }
}
