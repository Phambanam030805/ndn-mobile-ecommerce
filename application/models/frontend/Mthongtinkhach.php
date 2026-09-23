<?php
class Mthongtinkhach extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Đổi từ 'customer' sang 'users'
        $this->table = 'users';
    }

    // Thông tin khách hàng
    public function customer_detail_id($id){
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    public function order_orderid($id) {
        $this->db->where('id', $id);
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        $this->db->limit(1);
        // Đổi từ 'db_order' sang 'orders'
        $query = $this->db->get('orders');
        return $query->row_array(); 
    } 

    public function orderdetail_order_join_product($id){
        $this->db->select('*');
        // Đổi từ 'db_orderdetail' sang 'order_items'
        $this->db->from('order_items or');
        $this->db->where('or.order_id', $id);
       
        $this->db->join('products pr', 'pr.id = or.product_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Danh sách đơn hàng chưa xử lý
    public function order_listorder_customerid_not($customer_id){
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 0);
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        // Đổi từ 'db_order' sang 'orders'
        $query = $this->db->get('orders');
        return $query->result_array();
    }  

    // Danh sách đơn hàng đã xử lý hoặc đang giao
    public function order_listorder_customerid($customer_id){
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status!=', 0);
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        // Đổi từ 'db_order' sang 'orders'
        $query = $this->db->get('orders');
        return $query->result_array();
    }  
}
