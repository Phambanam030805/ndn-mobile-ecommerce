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

    // Thêm mới bài viết
    public function content_insert($data){
        return $this->db->insert($this->table, $data);
    }

    // Kiểm tra trùng bài viết theo tiêu đề hoặc link gốc
    public function content_exists_by_title_or_alias($title, $alias){
        $this->db->where('type', 'news');
        $this->db->group_start();
        $this->db->where('title', $title);
        $this->db->or_where('alias', $alias);
        $this->db->group_end();
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
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

    /**
     * Thống kê chi tiết đánh giá từ 1 đến 5 sao và phần trăm tương ứng
     */
    public function review_breakdown($product_id)
    {
        $this->db->where('type', 'review');
        $this->db->where('link', $product_id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $reviews = $this->db->get($this->table)->result_array();

        $total = count($reviews);
        $stars = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        $sum = 0;

        foreach ($reviews as $rv) {
            $r = (int)$rv['title'];
            if ($r >= 1 && $r <= 5) {
                $stars[$r]++;
                $sum += $r;
            }
        }

        $avg = $total > 0 ? round($sum / $total, 1) : 5.0;

        $percentages = [];
        foreach ($stars as $star => $count) {
            $percentages[$star] = $total > 0 ? round(($count / $total) * 100) : 0;
        }

        return [
            'total' => $total,
            'avg' => $avg,
            'stars' => $stars,
            'percentages' => $percentages
        ];
    }
}