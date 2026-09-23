<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnhacungcap extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'suppliers';
    }

    public function producer_all($limit, $first)
    {
        $this->db->where('trash', 1);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function producer_count()
    {
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function producer_insert($mydata)
    {
        $this->db->insert($this->table, $mydata);
    }

    public function producer_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    public function producer_detail($id)
    {
        $this->db->where('trash', 1);
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function producer_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    public function producer_trash($limit, $first)
    {
        $this->db->where('trash', 0);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function producer_trash_count()
    {
        $this->db->where('trash', 0);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function producer_restore($id)
    {
        $data = array('trash' => 1);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function producer_list()
    {
        $this->db->where('trash', 1);
        $this->db->where('status', 1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}
