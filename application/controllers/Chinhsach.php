<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Trang chính sách và Hướng dẫn khách hàng
 * Hỗ trợ các trang: Hướng dẫn thanh toán, Hướng dẫn đặt hàng, Điều khoản dịch vụ, Chính sách bảo mật
 *
 * @property CI_Loader $load
 * @property array $data
 */
class Chinhsach extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Msanpham');
        $this->data['com'] = 'chinhsach';
    }

    /**
     * Hướng dẫn thanh toán
     * URL: /huong-dan-thanh-toan
     */
    public function huong_dan_thanh_toan() {
        $this->data['title'] = 'NDN Mobile - Hướng dẫn thanh toán';
        $this->data['page_slug'] = 'huong-dan-thanh-toan';
        $this->data['page_title'] = 'Hướng dẫn thanh toán an toàn tại NDN Mobile';
        $this->data['view'] = 'huong_dan_thanh_toan';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Hướng dẫn đặt hàng
     * URL: /huong-dan-dat-hang
     */
    public function huong_dan_dat_hang() {
        $this->data['title'] = 'NDN Mobile - Hướng dẫn đặt hàng';
        $this->data['page_slug'] = 'huong-dan-dat-hang';
        $this->data['page_title'] = 'Hướng dẫn mua hàng và đặt hàng Online';
        $this->data['view'] = 'huong_dan_dat_hang';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Điều khoản dịch vụ
     * URL: /dieu-khoan-dich-vu
     */
    public function dieu_khoan_dich_vu() {
        $this->data['title'] = 'NDN Mobile - Điều khoản dịch vụ';
        $this->data['page_slug'] = 'dieu-khoan-dich-vu';
        $this->data['page_title'] = 'Điều khoản & Quy định dịch vụ';
        $this->data['view'] = 'dieu_khoan_dich_vu';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Chính sách bảo mật
     * URL: /chinh-sach-bao-mat
     */
    public function chinh_sach_bao_mat() {
        $this->data['title'] = 'NDN Mobile - Chính sách bảo mật';
        $this->data['page_slug'] = 'chinh-sach-bao-mat';
        $this->data['page_title'] = 'Chính sách bảo mật thông tin khách hàng';
        $this->data['view'] = 'chinh_sach_bao_mat';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Hướng dẫn mua hàng trả góp 0%
     * URL: /tra-gop hoặc /huong-dan-tra-gop
     */
    public function huong_dan_tra_gop() {
        $this->data['title'] = 'NDN Mobile - Hướng dẫn mua trả góp 0%';
        $this->data['page_slug'] = 'huong-dan-tra-gop';
        $this->data['page_title'] = 'Chính sách & Hướng dẫn mua trả góp 0% tại NDN Mobile';
        $this->data['view'] = 'huong_dan_tra_gop';
        $this->load->view('frontend/layout', $this->data);
    }
}

