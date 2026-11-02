<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Mlienhe $Mlienhe
 * @property Mnguoidung $Mnguoidung
 * @property Mdonhang $Mdonhang
 * @property Phantrang $phantrang
 * @property array $data
 */
class Trangchu extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mnoidung');
        $this->load->library('tech_news_crawler');
        $this->load->library('phantrang');
        $this->data['com']='trangchu';
    }
    
	public function index($page = 1)
	{
        // Tự động cập nhật tin tức công nghệ mới nhất hôm nay từ RSS
        $this->tech_news_crawler->auto_crawl_daily(6);

        $limit = 10;
        $current = is_numeric($page) && $page > 0 ? (int)$page : $this->phantrang->PageCurrent();
        if ($current < 1) $current = 1;
        $first = $this->phantrang->PageFirst($limit, $current);

        // Lấy danh sách sản phẩm phân trang (mặc định theo ID tăng dần để các hãng lần lượt hiển thị đẹp mắt)
        $total = $this->Msanpham->product_sanpham_count();
        $config_url = base_url('trang-chu');

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $config_url);
        $this->data['list_home_products'] = $this->Msanpham->product_sanpham($limit, $first, 'id', 'asc');
        $this->data['current_page'] = $current;
        $this->data['total_products'] = $total;

        $this->data['title']='NDN Mobile - Điện thoại chính hãng giá tốt';
        $this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
}
