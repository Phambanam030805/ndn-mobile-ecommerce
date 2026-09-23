<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mtinhthanh extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Lấy tất cả các tỉnh/thành phố từ bảng 'locations' (parent_id = 0)
     * @return array
     */
    public function province_all() {
        $this->db->where('parent_id', NULL);
        $this->db->where_in('type', ['Tỉnh', 'Thành phố Trung ương']);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('locations');
        return $query->result_array();
    }

    /**
     * Lấy tên tỉnh/thành phố theo ID từ bảng 'locations'
     * @param int $id ID của tỉnh/thành phố
     * @return string|bool Tên tỉnh/thành phố hoặc FALSE nếu không tìm thấy
     */
    public function province_name($id) {
        $this->db->where('id', $id);
        $this->db->where('parent_id', NULL); // Đảm bảo là tỉnh/thành phố cấp cao nhất
        $this->db->where_in('type', ['Tỉnh', 'Thành phố Trung ương']);
        $query = $this->db->get('locations');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['name'];
        }
        return false;
    }
}