<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model Cấu hình Website & Phí vận chuyển (Hỗ trợ In-Memory & File Cache Layer)
 * 
 * @property CI_DB_query_builder $db
 * @property CI_Driver_Library $load
 */
class Mcauhinh extends CI_Model {

    private static $_config_cache = null;

    public function __construct(){
        parent::__construct();
        $this->table = 'configs';
        $this->load->driver('cache', ['adapter' => 'file', 'backup' => 'dummy']);
    }

    /**
     * Lấy cấu hình chi tiết website (Hỗ trợ 2 tầng Caching)
     */
    public function configuration_detail()
    {
        if (self::$_config_cache !== null) {
            return self::$_config_cache;
        }

        $cache_key = 'ndn_site_configuration';
        $cached = $this->cache->get($cache_key);
        if ($cached !== FALSE) {
            self::$_config_cache = $cached;
            return $cached;
        }

        $query = $this->db->get($this->table);
        $row = $query->row_array();

        if ($row) {
            $this->cache->save($cache_key, $row, 86400); // Cache 24 giờ
            self::$_config_cache = $row;
        }

        return $row;
    }

    /**
     * Tính phí giao hàng dựa trên giá trị đơn hàng (Miễn phí từ 5.000.000đ)
     */
    public function config_price_ship($total_money = 0){
        if((float)$total_money >= 5000000) {
            return 0;
        }
        $config = $this->configuration_detail();
        return (isset($config['priceShip']) && (float)$config['priceShip'] > 0) ? (float)$config['priceShip'] : 30000;
    }

    public function get_amount_number_used($id)
    {
        $this->db->where('id', (int)$id);
        $this->db->limit(1);
        $query = $this->db->get('coupons');
        $row = $query->row_array();
        return $row ? (int)$row['number_used'] : 0; 
    }

    public function get_config_coupon_discount($code){
        $this->db->where('code', $code);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);
        $query = $this->db->get('coupons');
        return $query->result_array();
    }

    public function coupon_update($mydata, $id)
    {
        $this->db->where('id', (int)$id);
        $this->db->update('coupons', $mydata);
    }

    /**
     * Xóa cache cấu hình khi Admin cập nhật thông tin
     */
    public function clear_config_cache()
    {
        self::$_config_cache = null;
        $this->cache->delete('ndn_site_configuration');
    }
}
