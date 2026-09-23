<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdanhmuc extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'categories'; 
    }

    // Lấy lên danh sách danh mục sản phẩm
    public function category_all($limit, $first)
    {
        $this->db->where('trash', 1);
        $this->db->where('type', 'product');
        $this->db->order_by('orders', 'ASC');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    // Đếm phân trang
    public function category_count()
    {
        $this->db->where('trash', 1);
        $this->db->where('type', 'product');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    // Thêm
    public function category_insert($mydata)
    {
        if(!isset($mydata['type'])) $mydata['type'] = 'product';
        $this->db->insert($this->table, $mydata);
    }

    // Cập nhật
    public function category_update($mydata, $id)
    {
        $this->db->where('id',$id);
        $this->db->update($this->table, $mydata);
    }

    // Kiểm tra tồn tại danh mục con
    public function category_count_parentid($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('type', 'product');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    // Lấy lên id danh mục
    public function category_parentid($id)
    {
        $this->db->where('trash',1);
        $this->db->where('status',1);
        $this->db->where('id',$id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row=$query->row_array();
        return ($row) ? $row['parentid'] : 0;
    }

    // Lấy lên tên danh mục
    public function category_name_parent($id)
    {
        $this->db->where('trash',1);
        $this->db->where('status',1);
        $this->db->where('id',$id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row) ? $row['name'] : 'Danh mục gốc';
    }

    // Lấy lên danh sách danh mục
    public function category_list()
    {
        $this->db->where('trash',1);
        $this->db->where('type', 'product');
        $this->db->order_by('orders', 'asc');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // Lấy lên thông tin danh mục đó lv
    public function category_detail($id)
    {
        $this->db->where('trash',1);
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Xóa vĩnh viễn
    public function category_delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete($this->table);
    }

    // Danh sách danh mục đã xóa
    public function category_trash($limit, $first)
    {
        $this->db->where('trash', 0);
        $this->db->where('type', 'product');
        $this->db->order_by('orders', 'ASC');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    public function category_trash_count()
    {
        $this->db->where('trash', 0);
        $this->db->where('type', 'product');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    // Khôi phục
    public function category_restore($id)
    {
        $data=array('trash'=>1);
        $this->db->where('id',$id);
        $this->db->update($this->table, $data);
    }

    public function category_name($id)
    {
        $this->db->where('id', $id);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        return ($row) ? $row['name'] : 'Không xác định';
    }

    /**
     * Đánh lại thứ tự sắp xếp sau khi xóa/thay đổi
     */
    public function reorder_sort_order()
    {
        $this->db->where('trash', 1);
        $this->db->order_by('orders', 'ASC');
        $query = $this->db->get($this->table);
        $results = $query->result_array();
        $i = 1;
        foreach ($results as $row) {
            $this->db->where('id', $row['id'])->update($this->table, ['orders' => $i++]);
        }
    }
}
