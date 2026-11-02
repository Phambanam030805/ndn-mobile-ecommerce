<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgiamgia extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // Đã đổi từ 'discount' sang 'coupons'
        $this->table = 'coupons';
    }
    
    // Lấy lên list mã giảm giá tự động
    public function coupon_auto_all()
    {
        $this->db->where('trash', 1);
        $this->db->where('orders', 0);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    // index (hỗ trợ tìm kiếm)
    public function coupon_all($limit, $first, $search = '')
    {
        $this->db->where('trash', 1);
        if(!empty($search)) {
            $this->db->group_start();
            $this->db->like('code', $search);
            $this->db->or_like('description', $search);
            if(is_numeric($search)){
                $this->db->or_where('id', $search);
            }
            $this->db->group_end();
        }
        $this->db->order_by('orders', 'desc');
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }
    
    public function coupon_count($search = '')
    {
        $this->db->where('trash', 1);
        if(!empty($search)) {
            $this->db->group_start();
            $this->db->like('code', $search);
            $this->db->or_like('description', $search);
            if(is_numeric($search)){
                $this->db->or_where('id', $search);
            }
            $this->db->group_end();
        }
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }
    
    // detail
    public function coupon_detail($id)
    {
        $this->db->where('trash', 1);
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();   
    }

    // recyclebin
    public function coupon_trash($limit, $first)
    {
        $this->db->where('trash',0);
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }
    
    public function coupon_trash_count()
    {
        $this->db->where('trash', 0);
        $query = $this->db->get($this->table);
        return count($query->result_array());
    }

    public function coupon_restore($id)
    {
        $data=array('trash'=>1);
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
    }

    // Thêm
    public function coupon_insert($mydata)
    {
        $this->db->insert($this->table,$mydata);
    }

    // Cập nhật
    public function coupon_update($mydata,$id)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table, $mydata);
    }

    // Xóa vĩnh viễn
    public function coupon_delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete($this->table);
    }
}
