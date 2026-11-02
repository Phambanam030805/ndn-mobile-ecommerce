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
class Tintuc extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mnoidung');
        $this->load->library('tech_news_crawler');
        $this->data['com']='tintuc';
    }
    
	public function index(){
        // Tự động kiểm tra cào tin tức điện thoại mới trong ngày (nếu hôm nay chưa chạy)
        $this->tech_news_crawler->auto_crawl_daily(4);

		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mnoidung->content_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='tin-tuc');
        $this->data['list']=$this->Mnoidung->content_list_home($limit,$first);
        $this->data['title']='NDN Mobile - Tin tức';  
		$this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}

	public function detail($link){
		$row = $this->Mnoidung->content_get_detail($link);
        if(!$row) {
            redirect('tin-tuc');
        }
		$this->data['row']=$row;
		$this->data['title']='NDN Mobile - '.$row['title'];
		$this->data['view']='detail';
		$this->load->view('frontend/layout',$this->data);
	}

    /**
     * Endpoint API hoặc Cronjob để chủ động kích hoạt quét tin tức mới: /tin-tuc/sync
     */
    public function sync_news(){
        $added = $this->tech_news_crawler->crawl_latest_news(6);
        echo json_encode([
            'status' => 'success',
            'added_articles' => $added,
            'message' => 'Đã quét và bổ sung thành công ' . $added . ' bài viết công nghệ mới.'
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}