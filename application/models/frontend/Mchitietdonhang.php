<?php
class Mchitietdonhang extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->table = 'order_items';
    }

    public function orderdetail_insert($data)
    {
        $this->db->insert($this->table,$data);
    }  

    // Lấy thông tin trang cám ơn khi thanh toán xong
    public function orderdetail_order($id)
    {
        $this->db->where('order_id', $id);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function orderdetail_order_join_product($id){
        $this->db->select('*, or.price as priceorder');
        $this->db->from($this->table . ' as or');
        $this->db->where('or.order_id', $id);
        
        $this->db->join('products as pr', 'pr.id = or.product_id');
        $query = $this->db->get();
        return $query->result_array();
    }
}
