<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mkhachhang extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users';
	}

    public function customer_login($username, $password)
    {
    	$this->db->where('username', $username);
    	$this->db->where('password', $password);
    	$this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('role', 3);
    	$query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function customer_detail($id)
    {
        $this->db->where('id', $id);
        $this->db->where('role', 3);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function customer_detail_email($email)
    {
        $this->db->where('email', $email);
        $this->db->where('role', 3);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function customer_check_username($username)
    {
        $this->db->where('username', $username);
        $this->db->where('role', 3);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function customer_insert($mydata)
    {
        $this->db->insert($this->table, $mydata);
    }

    public function customer_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    public function customer_trash_count()
    {
        $this->db->where('trash', 0);
        $this->db->where('role', 3);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
}