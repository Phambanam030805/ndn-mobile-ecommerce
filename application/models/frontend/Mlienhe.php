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
        $this->db->insert($this->table, $mydata);
    }
    
}
