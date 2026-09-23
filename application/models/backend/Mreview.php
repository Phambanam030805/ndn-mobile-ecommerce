<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mreview extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'posts';
    }

    public function review_all($limit, $first)
    {
        $this->db->where('type', 'review');
        $this->db->where('trash', 1);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function review_count()
    {
        $this->db->where('type', 'review');
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function review_detail($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function review_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    public function review_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
    
    // Trash handling
    public function review_trash($limit, $first)
    {
        $this->db->where('type', 'review');
        $this->db->where('trash', 0);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function review_trash_count()
    {
        $this->db->where('type', 'review');
        $this->db->where('trash', 0);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
}