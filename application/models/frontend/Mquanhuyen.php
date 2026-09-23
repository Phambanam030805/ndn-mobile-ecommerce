<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mquanhuyen extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Lấy danh sách quận/huyện theo province_id từ bảng 'locations'
     * @param int $province_id ID của tỉnh/thành phố cha
     * @return array
     */
    public function district_provinceid($province_id) {
        $this->db->where('parent_id', $province_id);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('locations');
        return $query->result_array();
    }

    /**
     * Lấy tên quận/huyện theo ID từ bảng 'locations'
     * @param int $id ID của quận/huyện
     * @return string|bool Tên quận/huyện hoặc FALSE nếu không tìm thấy
     */
    public function district_name($id) {
        $this->db->where('id', $id);
        $this->db->where_in('type', ['Quận', 'Huyện', 'Thành phố']);
        $query = $this->db->get('locations');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['name'];
        }
        return false;
    }
}