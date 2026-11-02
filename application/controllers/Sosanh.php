<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller So sánh sản phẩm
 * Không yêu cầu đăng nhập. Lưu tối đa 4 sản phẩm trong session.
 *
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property Msanpham $Msanpham
 * @property array $data
 */
class Sosanh extends CI_Controller {

    const MAX_COMPARE = 4; // Tối đa 4 sản phẩm so sánh

    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->data['com'] = 'sosanh';
    }

    /**
     * Trang so sánh sản phẩm
     * URL: /so-sanh
     */
    public function index()
    {
        $compare_ids = $this->session->userdata('compare_list') ?? [];
        $products = [];

        foreach ($compare_ids as $pid) {
            $row = $this->Msanpham->product_detail_id($pid);
            if ($row) {
                $products[] = $row;
            }
        }

        $this->data['products'] = $products;
        $this->data['count']    = count($products);
        $this->data['title']    = 'NDN Mobile - So sánh sản phẩm';
        $this->data['view']     = 'index';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Thêm sản phẩm vào danh sách so sánh (AJAX)
     * URL: /so-sanh/them/{product_id}
     */
    public function add($product_id = null)
    {
        $compare_list = $this->session->userdata('compare_list') ?? [];

        // Kiểm tra đã có trong danh sách chưa
        if (in_array($product_id, $compare_list)) {
            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'status'  => 'already',
                    'message' => 'Sản phẩm đã có trong danh sách so sánh!',
                    'count'   => count($compare_list)
                ]);
                return;
            } else {
                $this->session->set_flashdata('info', 'Sản phẩm này đã có trong danh sách so sánh!');
                redirect('so-sanh', 'refresh');
            }
        }

        // Kiểm tra giới hạn tối đa
        if (count($compare_list) >= self::MAX_COMPARE) {
            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'status'  => 'limit',
                    'message' => 'Chỉ được so sánh tối đa ' . self::MAX_COMPARE . ' sản phẩm! Vui lòng xóa bớt.',
                    'count'   => count($compare_list)
                ]);
                return;
            } else {
                $this->session->set_flashdata('error', 'Chỉ được so sánh tối đa ' . self::MAX_COMPARE . ' sản phẩm! Vui lòng xóa bớt sản phẩm cũ.');
                redirect('so-sanh', 'refresh');
            }
        }

        // Kiểm tra sản phẩm tồn tại
        $product = $this->Msanpham->product_detail_id($product_id);
        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại!']);
            return;
        }

        // Thêm vào session
        $compare_list[] = $product_id;
        $this->session->set_userdata('compare_list', $compare_list);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Đã thêm <strong>' . htmlspecialchars($product['name']) . '</strong> vào so sánh!',
                'count'   => count($compare_list),
                'name'    => $product['name']
            ]);
            return;
        } else {
            $this->session->set_flashdata('success', 'Đã thêm ' . $product['name'] . ' vào danh sách so sánh!');
            redirect('so-sanh', 'refresh');
        }
    }

    /**
     * Xóa một sản phẩm khỏi so sánh (AJAX)
     * URL: /so-sanh/xoa/{product_id}
     */
    public function remove($product_id = null)
    {
        $compare_list = $this->session->userdata('compare_list') ?? [];
        $compare_list = array_values(array_filter($compare_list, function($id) use ($product_id) {
            return $id != $product_id;
        }));

        $this->session->set_userdata('compare_list', $compare_list);

        if ($this->input->is_ajax_request()) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Đã xóa khỏi danh sách so sánh!',
                'count'   => count($compare_list)
            ]);
        } else {
            redirect('so-sanh', 'refresh');
        }
    }

    /**
     * Xóa toàn bộ danh sách so sánh
     * URL: /so-sanh/xoa-tat-ca
     */
    public function clear()
    {
        $this->session->unset_userdata('compare_list');
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'success', 'message' => 'Đã xóa toàn bộ danh sách so sánh!', 'count' => 0]);
        } else {
            redirect('so-sanh', 'refresh');
        }
    }
}
