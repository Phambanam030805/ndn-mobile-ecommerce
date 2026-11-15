<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mlienhe extends CI_Model {

    function __construct()
    {
        parent::__construct();
        // Đã đổi từ 'contact' sang 'posts'
        $this->table = 'posts';
    }

    // Lưu liên hệ của khách hàng từ trang Frontend
    function contact_insert($mydata)
    {
        if(!isset($mydata['status'])) {
            $mydata['status'] = 0; // Luôn mặc định là 0 (Chưa xem) cho liên hệ mới
        }
        if(!isset($mydata['trash'])) {
            $mydata['trash'] = 1;
        }
        if(!isset($mydata['created_at'])) {
            $mydata['created_at'] = date('Y-m-d H:i:s');
        }
        $this->db->insert($this->table, $mydata);
    }
    
}
