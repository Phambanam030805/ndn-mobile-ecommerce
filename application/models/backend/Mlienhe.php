<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mlienhe extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'posts';
    }

    // Lấy danh sách liên hệ
    public function contact_all($limit, $first)
    {
        $this->db->where('trash', 1);
        $this->db->where('type', 'contact');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function contact_count()
    {
        $this->db->where('trash', 1);
        $this->db->where('type', 'contact');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function contact_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    // Chi tiết liên hệ và đánh dấu đã xem
    public function contact_detail($id)
    {
        // Đánh dấu đã xem
        $this->db->where('id', $id);
        $this->db->update($this->table, array('status' => 1));

        // Lấy thông tin chi tiết
        $this->db->where('trash', 1);
        $this->db->where('id', $id);
        $this->db->where('type', 'contact');
        $query = $this->db->get($this->table);
        return $query->row_array();   
    }

    // RECYCLEBIN (Thùng rác)
    public function contact_trash($limit, $first)
    {
        $this->db->where('trash', 0);
        $this->db->where('type', 'contact');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function contact_trash_count()
    {
        $this->db->where('trash', 0);
        $this->db->where('type', 'contact');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function contact_restore($id)
    {
        $data = array('trash' => 1);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    // Xóa vĩnh viễn
    public function contact_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
