<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sanpham extends MY_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->data['com']='sanpham';
        $this->load->library('session');
        $this->load->library('phantrang');
    }
    
    public function index(){
        $f = 'created_at';
        $od = 'desc';

        if($this->input->post('sapxep')){
            $dksx = $this->input->post('sapxep');
            $char = explode('-', $dksx);
            $f = $char[0];
            $od = $char[1];
            if($f == 'created') $f = 'created_at'; // Tự động sửa nếu nhận giá trị cũ
            $this->session->set_userdata('sortby', array('0' => $f, '1' => $od));
        } else if($this->session->userdata('sortby')){
            $data = $this->session->userdata('sortby');
            $f = $data[0];
            $od = $data[1];
            if($f == 'created') $f = 'created_at'; // Tự động sửa nếu bộ nhớ cũ còn lưu 'created'
        }

        $limit = 12;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);

        // Xử lý Lọc theo giá
        $price_min = null; $price_max = null;
        if($this->input->get('price')){
            $price_range = explode('-', $this->input->get('price'));
            $price_min = $price_range[0];
            $price_max = isset($price_range[1]) ? $price_range[1] : null;
        }

        $total = $this->Msanpham->product_sanpham_count($price_min, $price_max);
        
        $config_url = base_url('san-pham');
        if($this->input->get('price')) $config_url .= '?price='.$this->input->get('price');

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $config_url);
        $this->data['list'] = $this->Msanpham->product_sanpham($limit, $first, $f, $od, $price_min, $price_max);
        $this->data['title'] = 'NDN Mobile - Tất cả sản phẩm';
        $this->data['view'] = 'index';

        if($this->input->is_ajax_request()){
            $result = $this->load->view('frontend/components/sanpham/index_order', $this->data, true);
            echo json_encode($result);
        } else {
            $this->load->view('frontend/layout', $this->data);
        }
    }

    public function category($link){
        $f = 'created_at';
        $od = 'desc';

        if($this->input->post('sapxep-category')){
            $dksx = $this->input->post('sapxep-category');
            $char = explode('-', $dksx);
            $f = $char[0];
            $od = $char[1];
            if($f == 'created') $f = 'created_at';
            $this->session->set_userdata('sortby-category', array('0' => $f, '1' => $od));
        } else if($this->session->userdata('sortby-category')){
            $data = $this->session->userdata('sortby-category');
            $f = $data[0];
            $od = $data[1];
            if($f == 'created') $f = 'created_at';
        }
        
        $catid = $this->Mdanhmuc->category_id($link);
        if(!$catid) redirect('trang-chu');
        
        $listcat = $this->Mdanhmuc->category_listcat($catid);
        $this->data['categoryname'] = $this->Mdanhmuc->category_name($catid);
        
        $limit = 12;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);

        // Xử lý Lọc theo giá cho Category
        $price_min = null; $price_max = null;
        if($this->input->get('price')){
            $price_range = explode('-', $this->input->get('price'));
            $price_min = $price_range[0];
            $price_max = isset($price_range[1]) ? $price_range[1] : null;
        }

        $total = $this->Msanpham->product_chude_count($listcat, $price_min, $price_max);
        
        $config_url = base_url('san-pham/'.$link);
        if($this->input->get('price')) $config_url .= '?price='.$this->input->get('price');

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $config_url);
        $this->data['list'] = $this->Msanpham->product_list_cat_limit($listcat, $limit, $first, $f, $od, $price_min, $price_max);
        $this->data['title'] = 'NDN Mobile - '.$this->data['categoryname'];  
        $this->data['view'] = 'category';
        
        $this->load->view('frontend/layout', $this->data);
    }

    public function detail($link){   
        $row = $this->Msanpham->product_detail($link);
        if(!$row) redirect('trang-chu');

        $this->load->model('frontend/Mnoidung');
        $this->data['reviews'] = $this->Mnoidung->review_list_product($row['id']);
        $this->data['review_stats'] = $this->Mnoidung->review_average($row['id']);

        $this->data['row'] = $row;
        $this->data['name'] = $this->Mdanhmuc->category_name($row['catid']); // Lấy tên danh mục
        $this->data['title'] = 'NDN Mobile - '.$row['name'];  
        $this->data['view'] = 'detail';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * AJAX Gửi đánh giá sản phẩm
     */
    public function add_review()
    {
        $this->load->model('frontend/Mnoidung');
        
        $product_id = $this->input->post('product_id');
        $fullname = $this->input->post('fullname');
        $email = $this->input->post('email');
        $rating = $this->input->post('rating');
        $content = $this->input->post('content');
        
        if(!$product_id || !$fullname || !$rating || !$content) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin và chọn số sao đánh giá']);
            return;
        }
        
        $data = [
            'type' => 'review',
            'link' => $product_id,
            'title' => $rating,
            'fullname' => $fullname,
            'email' => $email,
            'content' => $content,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 0, // Chờ duyệt
            'trash' => 1
        ];
        
        $this->Mnoidung->review_insert($data);
        
        echo json_encode(['status' => 'success', 'message' => 'Đánh giá của bạn đã được gửi thành công và đang chờ quản trị viên phê duyệt.']);
    }

    /**
     * AJAX Thêm vào giỏ hàng - Không reload trang
     */
    public function addcart(){
        $id = $this->input->post('id');
        $color = $this->input->post('color');
        $capacity = $this->input->post('capacity');
        
        // Tạo key duy nhất cho sản phẩm với thuộc tính
        $cart_key = $id;
        if($color) $cart_key .= '_'.url_title($color);
        if($capacity) $cart_key .= '_'.url_title($capacity);

        $cart = $this->session->userdata('cart');
        
        if($cart){
            if(array_key_exists($cart_key, $cart)){
                $cart[$cart_key]++;
            }else{
                $cart[$cart_key] = 1;
            }
        }else{
            $cart[$cart_key] = 1;
        }
        
        // Lưu kèm thông tin thuộc tính để hiển thị trong giỏ hàng
        $cart_info = $this->session->userdata('cart_info');
        if(!$cart_info) $cart_info = [];
        $cart_info[$cart_key] = [
            'id' => $id,
            'color' => $color,
            'capacity' => $capacity
        ];

        $this->session->set_userdata('cart', $cart);
        $this->session->set_userdata('cart_info', $cart_info);
        
        // Tính toán lại tổng số lượng và tổng tiền
        $total_items = 0;
        foreach($cart as $v) $total_items += $v;
        
        $total_money = 0;
        foreach ($cart as $key => $value) {
            $info = $cart_info[$key];
            $row = $this->Msanpham->product_detail_id($info['id']);
            if ($row) {
                $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                $total_money += $price * $value;
            }
        }
        
        echo json_encode([
            'status' => 'success',
            'count' => $total_items,
            'total' => number_format($total_money).' VNĐ'
        ]);
    }

    public function update(){
        $id = $this->input->post('id'); // Ở đây id thực chất là cart_key
        $sl = (int)$this->input->post('sl');
        $cart = $this->session->userdata('cart');
        
        if($cart && array_key_exists($id, $cart)){
            $cart[$id] = ($sl > 0) ? $sl : 1;
            $this->session->set_userdata('cart', $cart);
        }
        
        echo json_encode(['status' => 'success']);
    }

    public function remove(){
        $id = $this->input->post('id'); // Ở đây id thực chất là cart_key
        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info');
        
        if($cart && isset($cart[$id])){
            unset($cart[$id]);
            $this->session->set_userdata('cart', $cart);
        }
        if($cart_info && isset($cart_info[$id])){
            unset($cart_info[$id]);
            $this->session->set_userdata('cart_info', $cart_info);
        }
        $this->session->unset_userdata('coupon_price');
        
        echo json_encode(['status' => 'success']);
    }
}
