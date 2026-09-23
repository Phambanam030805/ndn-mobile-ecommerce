<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mchitietdonhang extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'order_items';
    }

    public function orderdetail_orderid($id) {
        $this->db->where('order_id', $id);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
}