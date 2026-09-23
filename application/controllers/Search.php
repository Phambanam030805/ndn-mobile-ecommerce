<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Mlienhe $Mlienhe
 * @property Mnguoidung $Mnguoidung
 * @property Mdonhang $Mdonhang
 * @property Phantrang $phantrang
 * @property Alias $alias_lib
 * @property array $data
 */
class Search extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('frontend/Mnoidung');
		$this->load->model('frontend/Mdanhmuc');
		$this->load->model("frontend/Msanpham");
        $this->load->library('alias');
		$this->data['com']='search';
	}
    public function index(){
        $this->load->library('phantrang');
        
        // Lấy từ khóa từ GET (lần đầu) hoặc từ Segment (khi chuyển trang)
        $key = $this->input->get('search'); 
        if(!$key){
            $key = $this->uri->segment(2);
        }
        
        if(!$key) {
            redirect(base_url());
        }

        // Chuyển đổi từ khóa sang không dấu để tìm kiếm thông minh
        $this->load->library('alias');
        $alias_lib = new Alias();
        $key_alias = $alias_lib->str_alias($key);

        $limit = 12;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);
        
        $total = $this->Msanpham->product_search_count($key, $key_alias);
        $this->data['list'] = $this->Msanpham->product_search($key, $key_alias, $limit, $first);
        
        // URL phân trang dạng: search/tu-khoa
        $url = 'search/' . $key;
        
        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
        $this->data['title'] = 'NDN Mobile - Kết quả tìm kiếm cho: ' . $key;  
        $this->data['view'] = 'index';
        $this->data['count'] = $total;
        $this->data['key'] = $key;

        $this->load->view('frontend/layout', $this->data);
    }

    public function quick(){
        $key = $this->input->get('keyword');
        if(!$key || strlen($key) < 2) return;

        $this->load->library('alias');
        $alias_lib = new Alias();
        $key_alias = $alias_lib->str_alias($key);

        $list = $this->Msanpham->product_search($key, $key_alias, 5, 0);
        if(count($list) > 0){
            foreach($list as $row){
                echo '<li>';
                echo '    <a href="'.base_url($row['alias']).'">';
                echo '        <img src="'.base_url('public/images/products/'.$row['avatar']).'" alt="'.$row['name'].'">';
                echo '        <h3>'.$row['name'].'</h3>';
                echo '        <span class="price">'.number_format($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']).'₫</span>';
                if($row['price_sale'] > 0) {
                    echo '        <cite style="text-decoration: line-through; margin-left: 10px; color: #999;">'.number_format($row['price']).'₫</cite>';
                }
                echo '    </a>';
                echo '</li>';
            }
            echo '<li style="text-align: center; padding: 10px; background: #f8f9fa;">';
            echo '    <a href="'.base_url('search?search='.$key).'" style="color: #d70018; font-weight: bold;">Xem tất cả kết quả cho "'.$key.'"</a>';
            echo '</li>';
        } else {
            echo '<li style="padding: 10px; text-align: center;">Không tìm thấy sản phẩm nào</li>';
        }
    }
}