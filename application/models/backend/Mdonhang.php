<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdonhang extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'orders';
    }

    public function orders_customerid($customerid) {
        $this->db->where('customer_id', $customerid);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // 1. Lấy danh sách đơn hàng cho trang quản lý (hỗ trợ tìm kiếm & lọc trạng thái)
    public function orders_listorders($limit, $first, $search = '', $status = '')
    {
        $this->db->where('trash', 1);
        if ($status !== '' && $status !== null) {
            $this->db->where('status', (int)$status);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('orderCode', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('phone', $search);
            if (is_numeric($search)) {
                $this->db->or_where('id', $search);
            }
            $this->db->group_end();
        }
        $this->db->order_by('order_date', 'desc'); 
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    // 2. Đếm tổng đơn hàng để phân trang
    public function orders_count($search = '', $status = '')
    {
        $this->db->where('trash', 1);
        if ($status !== '' && $status !== null) {
            $this->db->where('status', (int)$status);
        }
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('orderCode', $search);
            $this->db->or_like('fullname', $search);
            $this->db->or_like('phone', $search);
            if (is_numeric($search)) {
                $this->db->or_where('id', $search);
            }
            $this->db->group_end();
        }
        return $this->db->count_all_results($this->table);
    }

    // 3. Đếm số đơn trong thùng rác
    public function orders_trash_count()
    {
        $this->db->where('trash', 0);
        return $this->db->count_all_results($this->table);
    }

    // 4. Tính doanh thu cho Dashboard
    public function sum_revenue()
    {
        $this->db->select_sum('money'); 
        $this->db->where('trash', 1);
        $this->db->where('status', 2); // Trạng thái 2 là Đã giao thành công
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row['money'] > 0) ? $row['money'] : 0;
    }

    // 5. Thống kê theo tháng cho biểu đồ
    public function orders_follow_month($year, $month) {
        $this->db->where('trash', 1);
        $this->db->where('status', 2); // Chỉ tính đơn đã giao thành công
        $this->db->where('YEAR(order_date)', $year);
        $this->db->where('MONTH(order_date)', $month);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // 6. Đếm đơn hàng đang giao hàng (status = 1) cho Header
    public function orders_count_header() {
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        return $this->db->count_all_results($this->table);
    }

    // 7. Đếm đơn hàng đang chờ duyệt (status = 0) cho Header
    public function orders_count_header_not() {
        $this->db->where('status', 0);
        $this->db->where('trash', 1);
        return $this->db->count_all_results($this->table);
    }

    // 8. Lấy chi tiết một đơn hàng
    public function orders_detail($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // 9. Cập nhật thông tin đơn hàng
    public function orders_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    // 10. Lấy danh sách đơn hàng trong thùng rác
    public function orders_trash($limit, $first)
    {
        $this->db->where('trash', 0);
        $this->db->order_by('order_date', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    // 11. Khôi phục đơn hàng từ thùng rác
    public function orders_restore($id)
    {
        $mydata = array('trash' => 1);
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    // 12. Lấy số lượng đã bán của sản phẩm từ bảng products
    public function product_number_buy($id)
    {
        $this->db->where('id', $id);
        $this->db->select('number_buy');
        $query = $this->db->get('products'); 
        $row = $query->row_array();
        return (isset($row['number_buy'])) ? $row['number_buy'] : 0;
    }

    // 13. Cập nhật số lượng sản phẩm sau khi bán thành công vào bảng products
    public function orders_update_number_product($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('products', $mydata);
    }
}
