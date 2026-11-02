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
        // 1. Thống kê tổng quát (KPIs)
        $this->data['total_products'] = $this->Msanpham->product_sanpham_count();
        $this->data['total_news'] = $this->Mnoidung->content_count();
        $this->data['total_customers'] = $this->Mnguoidung->user_count([3]);
        $this->data['total_orders'] = $this->Mdonhang->orders_count();
        $this->data['total_revenue'] = $this->Mdonhang->sum_revenue(); 

        // 2. Thống kê doanh thu theo năm (Mặc định năm hiện tại hoặc năm do Admin chọn)
        $selected_year = (int)$this->input->get('year');
        if (!$selected_year || $selected_year < 2020 || $selected_year > 2030) {
            $selected_year = (int)date('Y');
        }
        $this->data['selected_year'] = $selected_year;

        // Lấy danh sách các năm có phát sinh đơn hàng để hiển thị bộ lọc
        $this->db->select('DISTINCT YEAR(order_date) as yr');
        $this->db->where('trash', 1);
        $this->db->order_by('yr', 'desc');
        $years_db = $this->db->get('orders')->result_array();
        $available_years = !empty($years_db) ? array_column($years_db, 'yr') : [$selected_year];
        if (!in_array($selected_year, $available_years)) {
            $available_years[] = $selected_year;
        }
        rsort($available_years);
        $this->data['available_years'] = $available_years;

        // Mảng doanh thu 12 tháng của năm đã chọn
        $revenue_months = array();
        $orders_count_months = array();
        for ($i = 1; $i <= 12; $i++) {
            $list_orders = $this->Mdonhang->orders_follow_month($selected_year, $i);
            $sum_money = 0;
            foreach ($list_orders as $row) {
                $sum_money += $row['money'];
            }
            $revenue_months[$i] = $sum_money;
            $orders_count_months[$i] = count($list_orders);
        }
        $this->data['revenue_months'] = $revenue_months;
        $this->data['orders_count_months'] = $orders_count_months;

        // 3. Sản phẩm bán chạy thật (Top Sản phẩm đã bán)
        // Ưu tiên các sản phẩm thực tế có doanh số > 0 từ order_items hoặc number_buy
        $query_best_sellers = "
            SELECT p.id, p.name, p.avatar, p.price, p.price_sale,
                   COALESCE(SUM(oi.count), p.number_buy, 0) as real_sold,
                   COALESCE(SUM(oi.count * oi.price), (p.number_buy * IF(p.price_sale > 0, p.price_sale, p.price)), 0) as real_revenue
            FROM products p
            LEFT JOIN order_items oi ON oi.product_id = p.id
            LEFT JOIN orders o ON oi.order_id = o.id AND o.trash = 1 AND o.status = 2
            WHERE p.status = 1 AND p.trash = 1
            GROUP BY p.id
            ORDER BY real_sold DESC, p.number_buy DESC
            LIMIT 5
        ";
        $this->data['best_selling_products'] = $this->db->query($query_best_sellers)->result_array();

        // 4. Sản phẩm tồn kho thấp (Cảnh báo tồn kho dưới 40 sản phẩm)
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->where('number <=', 40);
        $this->db->order_by('number', 'asc');
        $this->db->limit(6);
        $this->data['low_stock_products'] = $this->db->get('products')->result_array();

        // 5. Thống kê trạng thái đơn hàng (Đầy đủ và chuẩn xác theo quy trình)
        // 0: Đang chờ duyệt, 1: Đang giao hàng, 2: Đã giao thành công, 3 & 4: Đã hủy
        $this->data['order_status'] = array(
            'pending' => $this->db->where(['status' => 0, 'trash' => 1])->from('orders')->count_all_results(),
            'shipping' => $this->db->where(['status' => 1, 'trash' => 1])->from('orders')->count_all_results(),
            'success' => $this->db->where(['status' => 2, 'trash' => 1])->from('orders')->count_all_results(),
            'cancelled' => $this->db->where('trash', 1)->where_in('status', [3, 4])->from('orders')->count_all_results()
        );

        // 6. Đơn hàng mới nhất (Kèm ngày giờ đầy đủ)
        $this->db->where('trash', 1);
        $this->db->order_by('order_date', 'desc');
        $this->db->limit(5);
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

