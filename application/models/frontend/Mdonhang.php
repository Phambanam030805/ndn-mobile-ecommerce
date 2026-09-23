<?php
class Mdonhang extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Đã đổi từ 'order' sang 'orders'
        $this->table = 'orders';
    }

    // Lấy chi tiết đơn hàng mới nhất của một khách hàng
    public function order_detail_customerid($customer_id)
    {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Thêm đơn hàng mới khi khách đặt hàng thành công
    public function order_insert($mydata)
    {
        $this->db->insert($this->table,$mydata);
    } 

    // Lấy thông tin chi tiết một đơn hàng theo ID
    public function order_detail($id)
    {
        $this->db->where('id',$id);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Cập nhật trạng thái hoặc thông tin đơn hàng
    public function order_update($mydata, $id)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table, $mydata);
    }
}
