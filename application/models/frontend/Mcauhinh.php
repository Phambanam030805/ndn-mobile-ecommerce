<?php
class Mcauhinh extends CI_Model {
    public function __construct(){
        parent::__construct();
        // Đổi từ 'config' sang 'configs'
        $this->table = 'configs';
    }

    public function config_price_ship($total_money = 0){
        if($total_money >= 5000000) {
            return 0;
        }
        $query = $this->db->get($this->table);
        $row=$query->row_array();
        return (isset($row['priceShip']) && $row['priceShip'] > 0) ? $row['priceShip'] : 30000;
    }

    public function get_amount_number_used($id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        // Đã đổi từ 'db_discount' sang 'coupons'
        $query = $this->db->get('coupons');
        $row=$query->row_array();
        return $row['number_used']; 
    }

    public function get_config_coupon_discount($code){
        $this->db->where('code', $code);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        // Đã đổi từ 'db_discount' sang 'coupons'
        $query = $this->db->get('coupons');
        return $query->result_array();
    }

    // Cập nhật mã giảm giá
    public function coupon_update($mydata,$id)
    {
        $this->db->where('id',$id);
        // Đã đổi từ 'db_discount' sang 'coupons'
        $this->db->update('coupons', $mydata);
    }

    public function configuration_detail()
    {
       $query = $this->db->get($this->table);
       return $query->row_array();   
    }
}
