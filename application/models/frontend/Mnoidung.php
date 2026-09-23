<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnoidung extends CI_Model {

    public function __construct(){
            parent::__construct();
            $this->table = 'posts';
    }

    // Danh sách bài viết hiển thị ở trang chủ
    public function content_list_home($limit, $first){
        $this->db->select('*, created_at as created');
        $this->db->where('trash', 1);
        $this->db->where('status', 1);
        $this->db->where('type', 'news');
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get($this->table, $limit, $first);
        return $query->result_array();
    }

    // Lấy danh sách Slide Banner
    public function slider_list(){
        $this->db->where('trash', 1);
        $this->db->where('status', 1);
        $this->db->where('type', 'slider');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // Chi tiết bài viết dựa trên link (alias)
    public function content_get_detail($link){
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('alias', $link);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Đếm tổng số bài viết để làm phân trang
    public function content_count()
    {
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('type', 'news');
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    // Lấy bài viết mới nhất cho sidebar hoặc tin vắn
    public function content_get_news($limit){
        $this->db->where('status',1);
        $this->db->where('trash',1);
        $this->db->where('type', 'news');
        $this->db->limit($limit);
        $this->db->order_by('created_at', 'desc');
        $query=$this->db->get($this->table);
        return $query->result_array();
    }

    // --- PHẦN ĐÁNH GIÁ SẢN PHẨM (Sử dụng bảng posts với type='review') ---
    
    public function review_insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function review_list_product($product_id)
    {
        $this->db->where('type', 'review');
        $this->db->where('link', $product_id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    public function review_average($product_id)
    {
        $this->db->select_avg('title', 'avg_rating');
        $this->db->select('count(*) as total_reviews');
        $this->db->where('type', 'review');
        $this->db->where('link', $product_id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
}