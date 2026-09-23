<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnguoidung extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users';
	}

    /**
     * Đăng nhập (Frontend & Backend)
     */
    public function user_login($username, $password, $roles = [1, 2])
    {
    	$this->db->where('username', $username);
    	$this->db->where('password', $password);
    	$this->db->where('status', 1);
        $this->db->where_in('role', $roles);
    	$query = $this->db->get($this->table);
        return $query->row_array();
    }

    /**
     * Lấy danh sách người dùng theo vai trò
     */
    public function user_all($roles = [1, 2], $limit = null, $first = null)
    {
        $this->db->where('trash', 1);
        $this->db->where_in('role', $roles);
        $this->db->order_by('id', 'desc');
        if ($limit !== null && $first !== null) {
            $query = $this->db->get($this->table, $limit, $first);
        } else {
            $query = $this->db->get($this->table);
        }
        return $query->result_array();
    }

    public function user_count($roles = [1, 2])
    {
        $this->db->where('trash', 1);
        $this->db->where_in('role', $roles);
        return $this->db->count_all_results($this->table);
    }

    public function user_insert($mydata)
    {
        $this->db->insert($this->table, $mydata);
    }

    public function user_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    public function user_detail($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    /**
     * Lấy tên đầy đủ của người dùng qua ID
     */
    public function user_name($id)
    {
        $this->db->where('id', $id);
        $this->db->select('fullname');
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return (isset($row['fullname'])) ? $row['fullname'] : 'Hệ thống';
    }

    public function user_trash($roles = [1, 2], $limit = null, $first = null)
    {
        $this->db->where('trash', 0);
        $this->db->where_in('role', $roles);
        if ($limit !== null && $first !== null) {
            $query = $this->db->get($this->table, $limit, $first);
        } else {
            $query = $this->db->get($this->table);
        }
        return $query->result_array();
    }

    public function user_trash_count($roles = [1, 2])
    {
        $this->db->where('trash', 0);
        $this->db->where_in('role', $roles);
        return $this->db->count_all_results($this->table);
    }

    public function user_restore($id)
    {
        $data = array('trash' => 1);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function user_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}