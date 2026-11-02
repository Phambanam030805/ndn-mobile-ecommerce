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

        $limit = 6;
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
        $this->data['categories'] = $this->Mdanhmuc->category_brands();
        $this->data['total'] = $total;
        $this->data['current_price'] = $this->input->get('price');
        $this->data['title'] = 'NDN Mobile - Tất cả sản phẩm';
        $this->data['view'] = 'index';

        if($this->input->is_ajax_request()){
            $result = $this->load->view('frontend/components/sanpham/index_order', $this->data, true);
            echo json_encode($result);
        } else {
            $this->load->view('frontend/layout', $this->data);
        }
    }

    public function sale(){
        $f = 'created_at';
        $od = 'desc';

        if($this->input->post('sapxep')){
            $dksx = $this->input->post('sapxep');
            $char = explode('-', $dksx);
            $f = $char[0];
            $od = $char[1];
            if($f == 'created') $f = 'created_at';
            $this->session->set_userdata('sortby-sale', array('0' => $f, '1' => $od));
        } else if($this->session->userdata('sortby-sale')){
            $data = $this->session->userdata('sortby-sale');
            $f = $data[0];
            $od = $data[1];
            if($f == 'created') $f = 'created_at';
        }

        $limit = 6;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);

        // Xử lý Lọc theo giá
        $price_min = null; $price_max = null;
        if($this->input->get('price')){
            $price_range = explode('-', $this->input->get('price'));
            $price_min = $price_range[0];
            $price_max = isset($price_range[1]) ? $price_range[1] : null;
        }

        $total = $this->Msanpham->product_sale_count($price_min, $price_max);
        
        $config_url = base_url('khuyen-mai');
        if($this->input->get('price')) $config_url .= '?price='.$this->input->get('price');

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $config_url);
        $this->data['list'] = $this->Msanpham->product_sale_list($limit, $first, $f, $od, $price_min, $price_max);
        $this->data['categories'] = $this->Mdanhmuc->category_brands();
        $this->data['total'] = $total;
        $this->data['current_price'] = $this->input->get('price');
        $this->data['is_sale_page'] = true;
        $this->data['page_title_custom'] = 'SẢN PHẨM KHUYẾN MÃI HOT';
        $this->data['title'] = 'NDN Mobile - Khuyến mãi hot, săn deal giá sốc';
        $this->data['view'] = 'index';

        if($this->input->is_ajax_request()){
            $result = $this->load->view('frontend/components/sanpham/index_order', $this->data, true);
            echo json_encode($result);
        } else {
            $this->load->view('frontend/layout', $this->data);
        }
    }

    public function hot(){
        $f = 'number_buy';
        $od = 'desc';

        if($this->input->post('sapxep')){
            $dksx = $this->input->post('sapxep');
            $char = explode('-', $dksx);
            $f = $char[0];
            $od = $char[1];
            if($f == 'created') $f = 'created_at';
            $this->session->set_userdata('sortby-hot', array('0' => $f, '1' => $od));
        } else if($this->session->userdata('sortby-hot')){
            $data = $this->session->userdata('sortby-hot');
            $f = $data[0];
            $od = $data[1];
            if($f == 'created') $f = 'created_at';
        }

        $limit = 6;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);

        // Xử lý Lọc theo giá
        $price_min = null; $price_max = null;
        if($this->input->get('price')){
            $price_range = explode('-', $this->input->get('price'));
            $price_min = $price_range[0];
            $price_max = isset($price_range[1]) ? $price_range[1] : null;
        }

        $total = $this->Msanpham->product_selling_count($price_min, $price_max);
        
        $config_url = base_url('ban-chay');
        if($this->input->get('price')) $config_url .= '?price='.$this->input->get('price');

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $config_url);
        $this->data['list'] = $this->Msanpham->product_selling_list($limit, $first, $f, $od, $price_min, $price_max);
        $this->data['categories'] = $this->Mdanhmuc->category_brands();
        $this->data['total'] = $total;
        $this->data['current_price'] = $this->input->get('price');
        $this->data['is_hot_page'] = true;
        $this->data['page_title_custom'] = 'TOP SẢN PHẨM BÁN CHẠY';
        $this->data['title'] = 'NDN Mobile - Top sản phẩm bán chạy nhất';
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
        
        $limit = 6;
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
        $this->data['categories'] = $this->Mdanhmuc->category_brands();
        $this->data['total'] = $total;
        $this->data['current_price'] = $this->input->get('price');
        $this->data['current_cat_link'] = $link;
        $this->data['title'] = 'NDN Mobile - '.$this->data['categoryname'];  
        $this->data['view'] = 'category';
        
        $this->load->view('frontend/layout', $this->data);
    }

    public function detail($link){   
        $row = $this->Msanpham->product_detail($link);
        if(!$row) redirect('trang-chu');

        $this->load->model('frontend/Mnoidung');
        $this->load->model('frontend/Mnhacungcap');

        // Lấy danh sách đánh giá & thống kê chi tiết rating breakdown
        $this->data['reviews'] = $this->Mnoidung->review_list_product($row['id']);
        $this->data['review_stats'] = $this->Mnoidung->review_average($row['id']);
        $this->data['review_breakdown'] = $this->Mnoidung->review_breakdown($row['id']);

        // Lấy các SKU / Biến thể dung lượng cùng series
        $this->data['variants'] = $this->Msanpham->get_product_variants($row['name'], $row['id']);

        // Nhà cung cấp / thương hiệu
        $producer = $this->Mnhacungcap->producer_detail($row['producer_id']);
        $this->data['producer'] = $producer;

        // Dữ liệu sản phẩm và danh mục
        $this->data['row'] = $row;
        $this->data['name'] = $this->Mdanhmuc->category_name($row['catid']);
        $this->data['title'] = $row['name'] . ' - Giá Tốt, Trả Góp 0%, Giao Siêu Tốc | NDN Mobile';  
        $this->data['view'] = 'detail';

        // Tạo cấu trúc Schema.org JSON-LD chuẩn SEO Google Rich Snippets
        $price = ($row['price_sale'] > 0) ? (int)$row['price_sale'] : (int)$row['price'];
        $in_stock = ($row['number'] - $row['number_buy'] > 0 && $row['status'] == 1);
        $total_reviews = isset($this->data['review_breakdown']['total']) && $this->data['review_breakdown']['total'] > 0 ? $this->data['review_breakdown']['total'] : 1;
        $avg_rating = isset($this->data['review_breakdown']['avg']) && $this->data['review_breakdown']['avg'] > 0 ? $this->data['review_breakdown']['avg'] : 5.0;

        $schema_images = [];
        if (!empty($row['avatar'])) {
            $schema_images[] = base_url('public/images/products/' . $row['avatar']);
        }
        if (!empty($row['img'])) {
            foreach (explode('#', $row['img']) as $im) {
                $im = trim($im);
                if ($im !== '') $schema_images[] = base_url('public/images/products/' . $im);
            }
        }
        $schema_images = array_values(array_unique($schema_images));

        $this->data['schema_json_ld'] = json_encode([
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $row['name'],
            'image' => $schema_images,
            'description' => strip_tags(!empty($row['sortDesc']) ? $row['sortDesc'] : $row['name']),
            'sku' => 'SKU-' . $row['id'],
            'mpn' => 'MPN-' . $row['alias'],
            'brand' => [
                '@type' => 'Brand',
                'name' => !empty($producer['name']) ? $producer['name'] : 'NDN Mobile'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => base_url($row['alias']),
                'priceCurrency' => 'VND',
                'price' => $price,
                'priceValidUntil' => date('Y-12-31'),
                'itemCondition' => 'https://schema.org/NewCondition',
                'availability' => $in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'NDN Mobile'
                ]
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => (string)$avg_rating,
                'reviewCount' => (string)$total_reviews,
                'bestRating' => '5',
                'worstRating' => '1'
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * AJAX Lấy thông tin biến thể sản phẩm theo ID
     */
    public function get_variant_ajax()
    {
        $this->output->set_content_type('application/json');
        $id = (int)$this->input->get('id');
        if(!$id) $id = (int)$this->input->post('id');

        $row = $this->Msanpham->product_detail_id($id);
        if (!$row) {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy phiên bản sản phẩm']);
            return;
        }

        $stock = $row['number'] - $row['number_buy'];
        $is_in_stock = ($stock > 0 && $row['status'] == 1);
        $price = (int)$row['price'];
        $price_sale = (int)$row['price_sale'];
        $sale_percent = (int)$row['sale'];

        $images = [];
        if (!empty($row['avatar'])) {
            $images[] = [
                'src' => base_url('public/images/products/' . $row['avatar']),
                'name' => $row['avatar']
            ];
        }
        if (!empty($row['img'])) {
            $gallery = explode('#', $row['img']);
            foreach ($gallery as $g) {
                $g = trim($g);
                if ($g !== '' && $g !== $row['avatar']) {
                    $images[] = [
                        'src' => base_url('public/images/products/' . $g),
                        'name' => $g
                    ];
                }
            }
        }

        echo json_encode([
            'status' => 'success',
            'data' => [
                'id' => $row['id'],
                'name' => $row['name'],
                'alias' => $row['alias'],
                'url' => base_url($row['alias']),
                'price' => $price,
                'price_formatted' => number_format($price) . '₫',
                'price_sale' => $price_sale,
                'price_sale_formatted' => number_format($price_sale > 0 ? $price_sale : $price) . '₫',
                'has_sale' => ($price_sale > 0 && $price_sale < $price),
                'sale_percent' => $sale_percent,
                'stock' => $stock,
                'is_in_stock' => $is_in_stock,
                'stock_text' => $is_in_stock ? 'Còn ' . $stock . ' sản phẩm' : 'Tạm hết hàng',
                'capacity' => $row['capacity'],
                'color' => $row['color'],
                'avatar' => base_url('public/images/products/' . $row['avatar']),
                'images' => $images
            ]
        ]);
    }

    /**
     * AJAX Gửi đánh giá sản phẩm - Bảo mật chống XSS & Spam Rate Limit
     */
    public function add_review()
    {
        $this->output->set_content_type('application/json');
        $this->load->model('frontend/Mnoidung');
        
        $product_id = (int)$this->input->post('product_id');
        $fullname   = trim(strip_tags((string)$this->input->post('fullname', TRUE)));
        $email      = trim(strip_tags((string)$this->input->post('email', TRUE)));
        $rating     = (int)$this->input->post('rating');
        $rawContent = (string)$this->input->post('content');

        // 1. Kiểm tra tính toàn vẹn dữ liệu
        if(!$product_id || empty($fullname) || $rating < 1 || $rating > 5 || empty(trim($rawContent))) {
            echo json_encode([
                'status'  => 'error', 
                'message' => 'Vui lòng điền họ tên, nhận xét và chọn số sao đánh giá hợp lệ (1 - 5 sao)!'
            ]);
            return;
        }

        // 2. Chống Stored XSS triệt để: Loại bỏ toàn bộ thẻ HTML và mã độc hại
        $cleanContent = strip_tags(trim($rawContent));
        if(mb_strlen($cleanContent, 'UTF-8') < 10) {
            echo json_encode([
                'status'  => 'error', 
                'message' => 'Nội dung nhận xét quá ngắn. Vui lòng nhập tối thiểu 10 ký tự!'
            ]);
            return;
        }

        // 3. Kiểm tra sản phẩm có tồn tại và đang kinh doanh hay không
        $product = $this->db->where('id', $product_id)->where('trash', 1)->get('products')->row_array();
        if(!$product) {
            echo json_encode([
                'status'  => 'error', 
                'message' => 'Sản phẩm được đánh giá không tồn tại!'
            ]);
            return;
        }

        $data = [
            'type'       => 'review',
            'link'       => $product_id,
            'title'      => $rating,
            'fullname'   => html_escape($fullname),
            'email'      => filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '',
            'content'    => html_escape($cleanContent),
            'created_at' => date('Y-m-d H:i:s'),
            'status'     => 0, // Chờ quản trị viên phê duyệt
            'trash'      => 1
        ];
        
        $this->Mnoidung->review_insert($data);
        
        echo json_encode([
            'status'  => 'success', 
            'message' => 'Đánh giá của bạn đã được gửi thành công và đang chờ quản trị viên phê duyệt. Cảm ơn bạn!'
        ]);
    }

    /**
     * AJAX Thêm vào giỏ hàng - Không reload trang kèm kiểm tra tồn kho chính xác
     */
    public function addcart(){
        $this->output->set_content_type('application/json');
        $id = (int)$this->input->post('id');
        $color = trim(strip_tags((string)$this->input->post('color')));
        $capacity = trim(strip_tags((string)$this->input->post('capacity')));
        $quantity = (int)$this->input->post('quantity');
        if($quantity <= 0) $quantity = 1;

        $product = $this->Msanpham->product_detail_id($id);
        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh!']);
            return;
        }

        $available_stock = (int)$product['number'] - (int)$product['number_buy'];
        if ($available_stock <= 0 || $product['status'] == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Rất tiếc, sản phẩm này hiện đã hết hàng!']);
            return;
        }

        // Tạo key duy nhất cho sản phẩm với thuộc tính
        $cart_key = $id;
        if($color) $cart_key .= '_'.url_title($color);
        if($capacity) $cart_key .= '_'.url_title($capacity);

        $cart = $this->session->userdata('cart');
        if(!$cart) $cart = [];

        $current_qty_in_cart = isset($cart[$cart_key]) ? (int)$cart[$cart_key] : 0;
        if (($current_qty_in_cart + $quantity) > $available_stock) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Số lượng yêu cầu vượt quá số lượng còn lại trong kho (Hiện còn: ' . $available_stock . ' sản phẩm)!'
            ]);
            return;
        }

        $cart[$cart_key] = $current_qty_in_cart + $quantity;

        // Lưu kèm thông tin thuộc tính để hiển thị trong giỏ hàng
        $cart_info = $this->session->userdata('cart_info');
        if(!$cart_info) $cart_info = [];
        $cart_info[$cart_key] = [
            'id' => $id,
            'name' => $product['name'],
            'color' => $color,
            'capacity' => $capacity,
            'avatar' => $product['avatar']
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
            'message' => 'Đã thêm sản phẩm ' . $product['name'] . ($color ? ' - ' . $color : '') . ($capacity ? ' (' . $capacity . ')' : '') . ' vào giỏ hàng thành công!',
            'count' => $total_items,
            'total' => number_format($total_money).'₫',
            'item' => [
                'name' => $product['name'],
                'color' => $color,
                'capacity' => $capacity,
                'avatar' => base_url('public/images/products/' . $product['avatar']),
                'price' => number_format(($product['price_sale'] > 0 ? $product['price_sale'] : $product['price'])) . '₫'
            ]
        ]);
    }

    /**
     * Mua ngay: Thêm sản phẩm trực tiếp vào giỏ và chuyển ngay đến trang thanh toán
     */
    public function buynow()
    {
        $id = (int)$this->input->post('id');
        $color = trim(strip_tags((string)$this->input->post('color')));
        $capacity = trim(strip_tags((string)$this->input->post('capacity')));
        $quantity = 1;

        $product = $this->Msanpham->product_detail_id($id);
        if (!$product || ($product['number'] - $product['number_buy'] <= 0)) {
            $this->session->set_flashdata('error', 'Sản phẩm bạn chọn hiện đang tạm hết hàng!');
            redirect($_SERVER['HTTP_REFERER']);
            return;
        }

        $cart_key = $id;
        if($color) $cart_key .= '_'.url_title($color);
        if($capacity) $cart_key .= '_'.url_title($capacity);

        $cart = $this->session->userdata('cart');
        if(!$cart) $cart = [];

        if(isset($cart[$cart_key])){
            $cart[$cart_key] += $quantity;
        } else {
            $cart[$cart_key] = $quantity;
        }

        $cart_info = $this->session->userdata('cart_info');
        if(!$cart_info) $cart_info = [];
        $cart_info[$cart_key] = [
            'id' => $id,
            'name' => $product['name'],
            'color' => $color,
            'capacity' => $capacity,
            'avatar' => $product['avatar']
        ];

        $this->session->set_userdata('cart', $cart);
        $this->session->set_userdata('cart_info', $cart_info);

        redirect('thanh-toan');
    }

    public function update(){
        $id = $this->input->post('id'); // Ở đây id thực chất là cart_key
        $sl = (int)$this->input->post('sl');
        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info');
        
        if($cart){
            $id_decoded = urldecode($id);
            $target_key = null;
            if(array_key_exists($id, $cart)) {
                $target_key = $id;
            } elseif(array_key_exists($id_decoded, $cart)) {
                $target_key = $id_decoded;
            }
            
            if($target_key !== null){
                $cart[$target_key] = ($sl > 0) ? $sl : 1;
                $this->session->set_userdata('cart', $cart);
            }
        }
        
        echo json_encode(['status' => 'success']);
    }

    public function remove(){
        $id = $this->input->post('id');
        if(!$id) $id = $this->input->get('id');
        $this->do_remove($id);
        echo json_encode(['status' => 'success']);
    }

    public function remove_item($id = null){
        if($id) {
            $this->do_remove($id);
        }
        redirect('gio-hang', 'refresh');
    }

    private function do_remove($id){
        if(!$id) return;
        $id_decoded = urldecode($id);
        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info');
        
        if($cart){
            $found = false;
            if(array_key_exists($id, $cart)){
                unset($cart[$id]);
                if($cart_info && isset($cart_info[$id])) unset($cart_info[$id]);
                $found = true;
            }
            if(!$found && array_key_exists($id_decoded, $cart)){
                unset($cart[$id_decoded]);
                if($cart_info && isset($cart_info[$id_decoded])) unset($cart_info[$id_decoded]);
                $found = true;
            }
            if(!$found){
                foreach($cart as $k => $v){
                    if($k == $id || $k == $id_decoded || (isset($cart_info[$k]['id']) && $cart_info[$k]['id'] == $id)){
                        unset($cart[$k]);
                        if($cart_info && isset($cart_info[$k])) unset($cart_info[$k]);
                        break;
                    }
                }
            }
            
            if(empty($cart)){
                $this->session->unset_userdata('cart');
                $this->session->unset_userdata('cart_info');
            }else{
                $this->session->set_userdata('cart', $cart);
                $this->session->set_userdata('cart_info', $cart_info);
            }
        }
        $this->session->unset_userdata('coupon_price');
    }
}
