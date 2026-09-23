<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgiamgia extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Đã đổi từ 'discount' sang 'coupons'
        $this->table = 'coupons';
    }
    
    // Thêm mã giảm giá mới
    public function coupon_insert($mydata)
    {
        $this->db->insert($this->table, $mydata);
    }
}
