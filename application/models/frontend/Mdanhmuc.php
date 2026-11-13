<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Danh Mục Sản Phẩm (Hỗ trợ Multi-tier Caching Layer)
 * 
 * @property CI_DB_query_builder $db
 * @property CI_Driver_Library $load
 */
class Mdanhmuc extends CI_Model {

    // Bộ nhớ đệm Static In-Memory Cache (Per-Request)
    private static $_memory_cache = [];

    public function __construct()
    {
        parent::__construct();
        $this->table = 'categories';
        $this->load->driver('cache', ['adapter' => 'file', 'backup' => 'dummy']);
    }

    /**
     * Lấy danh sách menu danh mục theo phân cấp parentid (Có Cache)
     */
    public function category_menu($parentid)
    {
        $cache_key = 'ndn_cat_menu_' . (int)$parentid;

        if (isset(self::$_memory_cache[$cache_key])) {
            return self::$_memory_cache[$cache_key];
        }

        $cached_data = $this->cache->get($cache_key);
        if ($cached_data !== FALSE) {
            self::$_memory_cache[$cache_key] = $cached_data;
            return $cached_data;
        }

        if ($parentid == 0 || $parentid === null) {
            $this->db->group_start();
            $this->db->where('parentid', 0);
            $this->db->or_where('parentid IS NULL', null, false);
            $this->db->group_end();
        } else {
            $this->db->where('parentid', (int)$parentid);
        }

        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders', 'asc');
        $query = $this->db->get($this->table);
        $result = $query->result_array();

        // Lưu cache 3600 giây (1 giờ)
        $this->cache->save($cache_key, $result, 3600);
        self::$_memory_cache[$cache_key] = $result;

        return $result;
    }

    /**
     * Lấy ID danh mục qua Slug/Link (Có Cache)
     */
    public function category_id($link)
    {
        $cache_key = 'ndn_cat_id_' . md5($link);

        if (isset(self::$_memory_cache[$cache_key])) {
            return self::$_memory_cache[$cache_key];
        }

        $cached_data = $this->cache->get($cache_key);
        if ($cached_data !== FALSE) {
            self::$_memory_cache[$cache_key] = $cached_data;
            return $cached_data;
        }

        $this->db->where('link', $link);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        $id = $row ? (int)$row['id'] : null;

        $this->cache->save($cache_key, $id, 3600);
        self::$_memory_cache[$cache_key] = $id;

        return $id;
    }

    /**
     * Lấy tên danh mục qua ID (Có In-Memory Cache)
     */
    public function category_name($id)
    {
        $cache_key = 'ndn_cat_name_' . (int)$id;

        if (isset(self::$_memory_cache[$cache_key])) {
            return self::$_memory_cache[$cache_key];
        }

        $this->db->where('id', (int)$id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        $name = ($row) ? $row['name'] : 'Điện thoại';

        self::$_memory_cache[$cache_key] = $name;
        return $name;
    }

    /**
     * Lấy đường dẫn (Slug / Link) danh mục qua ID (Có In-Memory Cache)
     */
    public function category_link($id)
    {
        $cache_key = 'ndn_cat_link_' . (int)$id;

        if (isset(self::$_memory_cache[$cache_key])) {
            return self::$_memory_cache[$cache_key];
        }

        $this->db->where('id', (int)$id);
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        $row = $query->row_array();
        $link = ($row && !empty($row['link'])) ? $row['link'] : 'dien-thoai';

        self::$_memory_cache[$cache_key] = $link;
        return $link;
    }

    /**
     * Lấy danh sách toàn bộ danh mục hoạt động
     */
    public function category_list()
    {
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders', 'asc');
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    /**
     * Lấy toàn bộ ID danh mục con trực thuộc
     */
    public function category_listcat($id)
    {
        $this->db->where('parentid', (int)$id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $query = $this->db->get($this->table);
        $list = [(int)$id];
        foreach ($query->result_array() as $row) {
            $list[] = (int)$row['id'];
        }
        return $list;
    }

    /**
     * Lấy danh sách thương hiệu điện thoại (Brand List) có Cache
     */
    public function category_brands()
    {
        $cache_key = 'ndn_cat_brands';

        if (isset(self::$_memory_cache[$cache_key])) {
            return self::$_memory_cache[$cache_key];
        }

        $cached_data = $this->cache->get($cache_key);
        if ($cached_data !== FALSE) {
            self::$_memory_cache[$cache_key] = $cached_data;
            return $cached_data;
        }

        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders', 'asc');
        $query = $this->db->get($this->table);
        $result = $query->result_array();

        $this->cache->save($cache_key, $result, 3600);
        self::$_memory_cache[$cache_key] = $result;

        return $result;
    }

    /**
     * Xóa sạch Cache danh mục khi Admin thêm/sửa/xóa danh mục
     * Chỉ xóa các file cache danh mục có tiền tố ndn_cat_*, tuyệt đối không xóa toàn bộ cache làm mất file ci_session
     */
    public function clear_category_cache()
    {
        self::$_memory_cache = [];
        $cache_path = APPPATH . 'cache/';
        if (is_dir($cache_path)) {
            $files = glob($cache_path . 'ndn_cat_*');
            if (!empty($files)) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }
}
