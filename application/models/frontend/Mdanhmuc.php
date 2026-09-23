<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdanhmuc extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'categories';
    }

    public function category_menu($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('type', 'category');
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders', 'asc');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function category_id($link)
    {
        $this->db->where('link', $link);
        $this->db->where('type', 'category');
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row) ? $row['id'] : null;
    }

    public function category_name($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row) ? $row['name'] : 'Sản phẩm';
    }

    public function category_listcat($id)
    {
        $this->db->where('parentid', $id);
        $this->db->where('type', 'category');
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        $list = array();
        $list[] = $id;
        foreach ($query->result_array() as $row) {
            $list[] = $row['id'];
        }
        return $list;
    }

    public function category_link($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row) ? $row['link'] : '';
    }
}
