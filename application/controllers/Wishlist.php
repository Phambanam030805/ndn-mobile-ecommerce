<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Wishlist - Danh sách yêu thích sản phẩm
 * Yêu cầu đăng nhập. Lưu trong bảng wishlists.
 *
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Msanpham $Msanpham
 * @property array $data
 */
class Wishlist extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->data['com'] = 'wishlist';
    }

    /**
     * Trang danh sách sản phẩm yêu thích
     * URL: /yeu-thich
     */
    public function index()
    {
        if (!$this->session->userdata('sessionKhachHang')) {
            $this->session->set_flashdata('error', 'Vui lòng đăng nhập để xem danh sách yêu thích!');
            redirect('dang-nhap', 'refresh');
        }

        $user_id = $this->session->userdata('id');

        // Lấy danh sách sản phẩm yêu thích (JOIN với bảng products)
        $this->db->select('products.*, wishlists.id as wishlist_id, wishlists.created_at as added_at');
        $this->db->from('wishlists');
        $this->db->join('products', 'products.id = wishlists.product_id');
        $this->db->where('wishlists.user_id', $user_id);
        $this->db->where('products.status', 1);
        $this->db->where('products.trash', 1);
        $this->db->order_by('wishlists.created_at', 'DESC');
        $list = $this->db->get()->result_array();

        $this->data['list']  = $list;
        $this->data['count'] = count($list);
        $this->data['title'] = 'NDN Mobile - Sản phẩm yêu thích';
        $this->data['view']  = 'index';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Toggle thêm/xóa yêu thích (AJAX hoặc redirect)
     * URL: /yeu-thich/them/{product_id}
     */
    public function toggle($product_id = null)
    {
        if (!$this->session->userdata('sessionKhachHang')) {
            echo json_encode(['status' => 'login_required', 'message' => 'Vui lòng đăng nhập!', 'redirect' => base_url('dang-nhap')]);
            return;
        }

        $user_id = $this->session->userdata('id');

        // Kiểm tra sản phẩm đã trong wishlist chưa
        $exists = $this->db->where('user_id', $user_id)->where('product_id', $product_id)->get('wishlists')->row_array();

        if ($exists) {
            // Đã có → XÓA khỏi wishlist
            $this->db->where('id', $exists['id'])->delete('wishlists');
            $action = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích!';
        } else {
            // Chưa có → THÊM vào wishlist
            $this->db->insert('wishlists', [
                'user_id'    => $user_id,
                'product_id' => $product_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $action = 'added';
            $message = 'Đã thêm vào danh sách yêu thích! ❤️';
        }

        // Đếm tổng wishlist hiện tại
        $count = $this->db->where('user_id', $user_id)->count_all_results('wishlists');

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => 'success',
                'action'  => $action,
                'message' => $message,
                'count'   => $count
            ]);
        } else {
            $this->session->set_flashdata('success', $message);
            redirect('yeu-thich', 'refresh');
        }
    }

    /**
     * Xóa một sản phẩm khỏi wishlist (AJAX)
     */
    public function remove($product_id = null)
    {
        if (!$this->session->userdata('sessionKhachHang')) {
            echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập!']);
            return;
        }
        $user_id = $this->session->userdata('id');
        $this->db->where('user_id', $user_id)->where('product_id', $product_id)->delete('wishlists');
        echo json_encode(['status' => 'success', 'message' => 'Đã xóa khỏi yêu thích!']);
    }

    /**
     * Kiểm tra sản phẩm có trong wishlist không (AJAX)
     */
    public function check($product_id = null)
    {
        if (!$this->session->userdata('sessionKhachHang')) {
            echo json_encode(['in_wishlist' => false]);
            return;
        }
        $user_id  = $this->session->userdata('id');
        $exists   = $this->db->where('user_id', $user_id)->where('product_id', $product_id)->count_all_results('wishlists');
        $total    = $this->db->where('user_id', $user_id)->count_all_results('wishlists');
        echo json_encode(['in_wishlist' => ($exists > 0), 'total' => $total]);
    }
}
