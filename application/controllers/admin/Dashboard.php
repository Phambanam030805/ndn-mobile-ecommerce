<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('backend/Msanpham');
        $this->load->model('backend/Mdanhmuc');
        $this->load->model('backend/Mnoidung');
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Mdonhang');
        $this->load->model('backend/Mchitietdonhang');
        $this->load->model('backend/Mreview');

        if(!$this->session->userdata('sessionadmin'))
        {
            redirect('admin/user/login','refresh');
        }
        
        $this->data['user'] = $this->session->userdata('sessionadmin');
        $this->data['com'] = 'dashboard';
    }

    public function index()
    {
        // 1. Thống kê tổng quát
        $this->data['total_products'] = $this->Msanpham->product_sanpham_count();
        $this->data['total_news'] = $this->Mnoidung->content_count();
        $this->data['total_customers'] = $this->Mnguoidung->user_count([3]);
        $this->data['total_orders'] = $this->Mdonhang->orders_count();
        $this->data['total_revenue'] = $this->Mdonhang->sum_revenue(); 

        // 2. Thống kê doanh thu 12 tháng
        $year = date('Y');
        $revenue_months = array();
        for ($i=1; $i <= 12 ; $i++) {
            $list_orders = $this->Mdonhang->orders_follow_month($year, $i);
            $sum_money = 0;
            foreach ($list_orders as $row) { $sum_money += $row['money']; }
            $revenue_months[$i] = $sum_money;
        }
        $this->data['revenue_months'] = $revenue_months;

        // 3. Sản phẩm bán chạy (Top 10)
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('number_buy', 'desc');
        $this->db->limit(10);
        $this->data['best_selling_products'] = $this->db->get('products')->result_array();

        // 4. Sản phẩm sắp hết hàng (Số lượng < 10)
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('number <', 10);
        $this->db->order_by('number', 'asc');
        $this->data['low_stock_products'] = $this->db->get('products')->result_array();

        // 5. Thống kê trạng thái đơn hàng (Dùng cho Pie Chart)
        $this->data['order_status'] = array(
            'pending' => $this->db->where(['status' => 0, 'trash' => 1])->count_all_results('orders'),
            'shipping' => $this->db->where(['status' => 1, 'trash' => 1])->count_all_results('orders'),
            'success' => $this->db->where(['status' => 2, 'trash' => 1])->count_all_results('orders'),
            'cancelled' => $this->db->where(['trash' => 0])->or_where_in('status', [3,4])->count_all_results('orders')
        );

        // 6. Đơn hàng mới nhất
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        $this->db->limit(8);
        $this->data['latest_orders'] = $this->db->get('orders')->result_array();

        // 7. Đánh giá mới nhất
        $this->db->select('posts.*, products.name as product_name, products.avatar as product_img');
        $this->db->from('posts');
        $this->db->join('products', 'products.id = posts.link');
        $this->db->where('posts.type', 'review');
        $this->db->where('posts.trash', 1);
        $this->db->order_by('posts.created_at', 'desc');
        $this->db->limit(5);
        $this->data['latest_reviews'] = $this->db->get()->result_array();

        $this->data['view'] = 'index';
        $this->data['title'] = 'Bảng điều khiển hệ thống - NDN Mobile';
        $this->load->view('backend/layout', $this->data);
    }
}

