<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Huongdan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data = [];
        $this->data['com'] = 'huongdan';
    }

    public function thanhtoan()
    {
        $this->data['title'] = 'Hướng dẫn thanh toán';
        $this->data['view']  = 'huongdan/thanhtoan';
        $this->load->view('frontend/layout', $this->data);
    }

    public function dathang()
    {
        $this->data['title'] = 'Hướng dẫn đặt hàng';
        $this->data['view']  = 'huongdan/dathang';
        $this->load->view('frontend/layout', $this->data);
    }

    public function dieukhoan()
    {
        $this->data['title'] = 'Điều khoản';
        $this->data['view']  = 'huongdan/dieukhoan';
        $this->load->view('frontend/layout', $this->data);
    }
}
