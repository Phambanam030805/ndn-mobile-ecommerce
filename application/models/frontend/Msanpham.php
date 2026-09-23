<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msanpham extends CI_Model {
    
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Hàm bổ trợ (Helper) áp dụng điều kiện lọc mặc định: Đang bán và Không trong thùng rác
     */
    private function _apply_default_filters()
    {
        $this->db->where($this->table . '.status', 1);
        $this->db->where($this->table . '.trash', 1);
    }

    /**
     * Hàm bổ trợ lọc theo giá
     */
    private function _apply_price_filter($min = null, $max = null)
    {
        if ($min !== null && $min !== '') {
            $this->db->where('price >=', $min);
        }
        if ($max !== null && $max !== '') {
            $this->db->where('price <=', $max);
        }
    }

    /**
     * Lấy sản phẩm cho trang chủ theo danh sách danh mục
     */
    public function product_home_limit($listcat, $limit)
    {
        if(empty($listcat)) return array();

        $this->_apply_default_filters();
        $this->db->where_in('catid', $listcat);
        $this->db->order_by('id', 'asc');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Danh sách tất cả sản phẩm (Có phân trang và sắp xếp)
     */
    public function product_sanpham($limit, $first, $f, $od, $price_min = null, $price_max = null)
    {       
        $this->_apply_default_filters();
        $this->_apply_price_filter($price_min, $price_max);
        $this->db->order_by($f, $od);
        return $this->db->get($this->table, $limit, $first)->result_array();
    }

    /**
     * Đếm tổng số sản phẩm đang bán (có lọc giá)
     */
    public function product_sanpham_count($price_min = null, $price_max = null)
    {
        $this->_apply_default_filters();
        $this->_apply_price_filter($price_min, $price_max);
        return $this->db->count_all_results($this->table);
    }

    /**
     * Danh sách sản phẩm theo danh mục (Có phân trang)
     */
    public function product_list_cat_limit($listcat, $limit, $first, $f, $od, $price_min = null, $price_max = null)
    {
        $this->_apply_default_filters();
        $this->_apply_price_filter($price_min, $price_max);
        if(!empty($listcat)){
            $this->db->where_in('catid', $listcat);
        }
        $this->db->order_by($f, $od);
        return $this->db->get($this->table, $limit, $first)->result_array();
    }

    /**
     * Đếm sản phẩm theo danh mục (có lọc giá)
     */
    public function product_chude_count($listcat, $price_min = null, $price_max = null)
    {
        $this->_apply_default_filters();
        $this->_apply_price_filter($price_min, $price_max);
        if(!empty($listcat)){
            $this->db->where_in('catid', $listcat);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Sản phẩm đang khuyến mãi
     */
    public function product_sale($limit)
    {
        $this->_apply_default_filters();
        $this->db->where('price_sale >', 0);
        $this->db->where('price_sale < price');
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Sản phẩm bán chạy
     */
    public function product_selling($limit)
    {
        $this->_apply_default_filters();
        $this->db->order_by('number_buy', 'desc');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Chi tiết sản phẩm qua Alias
     */
    public function product_detail($link)
    {     
        $this->_apply_default_filters();
        $this->db->where('alias', $link);
        return $this->db->get($this->table)->row_array();   
    }

    /**
     * Chi tiết sản phẩm qua ID
     */
    public function product_detail_id($id)
    { 
        $this->_apply_default_filters();
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();   
    }

    /**
     * Sản phẩm liên quan (Cùng danh mục, trừ chính nó)
     */
    public function product_cungloai($catid, $id, $limit)
    {
        $this->_apply_default_filters();
        $this->db->where('catid', $catid);
        $this->db->where('id !=', $id);
        $this->db->limit($limit);
        $this->db->order_by('id', 'random'); 
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Tìm kiếm sản phẩm (Tên, Alias hoặc Tên Danh Mục)
     * Cải tiến: JOIN với bảng categories để tìm kiếm thông minh theo nhóm
     */
    public function product_search($key, $key_alias, $limit, $first)
    {
        $this->db->select($this->table . '.*, categories.name as category_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = ' . $this->table . '.catid', 'left');
        
        // Áp dụng bộ lọc mặc định thủ công vì dùng từ bảng khác
        $this->db->where($this->table . '.status', 1);
        $this->db->where($this->table . '.trash', 1);
        
        $words = explode('-', $key_alias);
        
        $this->db->group_start();
        // 1. Tìm trong Tên sản phẩm
        $this->db->like($this->table . '.name', $key);
        
        // 2. Tìm trong Tên danh mục (Cho phép gõ "điện thoại" ra toàn bộ điện thoại)
        $this->db->or_like('categories.name', $key);
        
        // 3. Tìm từ khóa lẻ trong Alias của cả SP và Danh mục
        $this->db->or_group_start();
        foreach ($words as $word) {
            if (strlen($word) > 1) {
                $this->db->like($this->table . '.alias', $word);
                $this->db->or_like('categories.link', $word);
            }
        }
        $this->db->group_end();
        $this->db->group_end();
        
        $this->db->order_by($this->table . '.id', 'desc');
        $this->db->limit($limit, $first);
        return $this->db->get()->result_array();
    }

    /**
     * Đếm sản phẩm tìm kiếm
     */
    public function product_search_count($key, $key_alias)
    {
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = ' . $this->table . '.catid', 'left');
        
        $this->db->where($this->table . '.status', 1);
        $this->db->where($this->table . '.trash', 1);
        
        $words = explode('-', $key_alias);
        
        $this->db->group_start();
        $this->db->like($this->table . '.name', $key);
        $this->db->or_like('categories.name', $key);
        $this->db->or_group_start();
        foreach ($words as $word) {
            if (strlen($word) > 1) {
                $this->db->like($this->table . '.alias', $word);
                $this->db->or_like('categories.link', $word);
            }
        }
        $this->db->group_end();
        $this->db->group_end();
        
        return $this->db->count_all_results();
    }
}
