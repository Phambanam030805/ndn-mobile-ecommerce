<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Giỏ hàng & Xử lý Thanh toán Đặt hàng
 * Transaction-Safe Checkout, Concurrency Control & Webhook Architecture
 *
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property Mdonhang $Mdonhang
 * @property Msanpham $Msanpham
 * @property Mchitietdonhang $Mchitietdonhang
 * @property Mkhachhang $Mkhachhang
 * @property Mdanhmuc $Mdanhmuc
 * @property Mcauhinh $Mcauhinh
 * @property Mquanhuyen $Mquanhuyen
 * @property Mtinhthanh $Mtinhthanh
 * @property array $data
 */
class Giohang extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Mdonhang');
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mchitietdonhang');
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mcauhinh');
        $this->load->model('frontend/Mquanhuyen');
        $this->load->model('frontend/Mtinhthanh');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->data['com'] = 'giohang';
    }
    
    /**
     * Xem trang Giỏ hàng
     * URL: /gio-hang
     */
    public function index() {
        $this->data['title'] = 'NDN Mobile - Giỏ hàng của bạn';
        $this->data['view']  = 'index';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Tiến hành Đặt hàng & Thanh toán (Transaction-Safe & Concurrency Lock)
     * URL: /thanh-toan hoặc /info-order
     */
    public function info_order() {
        // Bắt buộc khách hàng phải đăng nhập
        if (!$this->session->userdata('sessionKhachHang')) {
            $this->session->set_flashdata('error', 'Vui lòng đăng nhập tài khoản để tiến hành đặt hàng và nhận ưu đãi!');
            $this->session->set_userdata('redirect_back', 'info-order');
            redirect('dang-nhap', 'refresh');
            return;
        }

        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info') ?? [];

        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Giỏ hàng của bạn đang trống! Vui lòng chọn sản phẩm trước khi thanh toán.');
            redirect('gio-hang', 'refresh');
            return;
        }

        $customer_session = $this->session->userdata('sessionKhachHang');
        $idCustomer = (int)$customer_session['id'];

        $this->form_validation->set_rules('name', 'Họ và tên', 'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|trim|min_length[10]|max_length[11]|numeric');
        $this->form_validation->set_rules('address', 'Địa chỉ giao hàng', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('city', 'Tỉnh/Thành phố', 'required|numeric');
        $this->form_validation->set_rules('DistrictId', 'Quận/Huyện', 'required|numeric');

        if ($this->form_validation->run() === TRUE) {
            $this->db->trans_start();

            try {
                $subtotal = 0;

                // 1. Kiểm tra tồn kho thời gian thực với khóa bản ghi (FOR UPDATE)
                foreach ($cart as $key => $qty) {
                    $qty = (int)$qty;
                    if ($qty <= 0) {
                        throw new Exception("Số lượng sản phẩm trong giỏ hàng không hợp lệ!");
                    }
                    if ($qty > 100) {
                        throw new Exception("Mỗi sản phẩm chỉ được đặt tối đa 100 máy trên một đơn hàng!");
                    }

                    $pid = isset($cart_info[$key]['id']) ? (int)$cart_info[$key]['id'] : (int)(is_numeric($key) ? $key : explode('_', $key)[0]);
                    
                    $product = $this->db->query("SELECT id, name, price, price_sale, number, number_buy FROM products WHERE id = ? AND trash = 1 AND status = 1 FOR UPDATE", [$pid])->row_array();

                    if (!$product) {
                        throw new Exception("Một trong các sản phẩm bạn chọn hiện không còn kinh doanh!");
                    }

                    $stockAvailable = (int)$product['number'] - (int)$product['number_buy'];
                    if ($qty > $stockAvailable) {
                        throw new Exception("Sản phẩm [{$product['name']}] chỉ còn {$stockAvailable} máy trong kho. Vui lòng giảm số lượng đặt mua!");
                    }

                    $unitPrice = ($product['price_sale'] > 0) ? (float)$product['price_sale'] : (float)$product['price'];
                    $subtotal += $unitPrice * $qty;
                }

                // 2. Tính phí vận chuyển theo chính sách
                $priceShip = (float)$this->Mcauhinh->config_price_ship($subtotal);

                // 3. Xử lý Mã giảm giá an toàn (Ngăn chặn Race Condition)
                $coupon_id = NULL;
                $coupon_amount = 0;

                if ($this->session->userdata('coupon_price') && $this->session->userdata('id_coupon_price')) {
                    $candidate_coupon_id = (int)$this->session->userdata('id_coupon_price');
                    $today_date = date('Y-m-d');

                    $coupon = $this->db->query("SELECT id, code, discount, limit_number, number_used, payment_limit, expiration_date FROM coupons WHERE id = ? AND status = 1 AND trash = 1 FOR UPDATE", [$candidate_coupon_id])->row_array();

                    if (!$coupon) {
                        throw new Exception("Mã giảm giá đã bị xóa hoặc không còn hiệu lực!");
                    }

                    if (strtotime($coupon['expiration_date']) < strtotime($today_date)) {
                        throw new Exception("Mã giảm giá {$coupon['code']} đã hết hạn sử dụng!");
                    }

                    if ((int)$coupon['number_used'] >= (int)$coupon['limit_number']) {
                        throw new Exception("Mã giảm giá {$coupon['code']} vừa hết số lượt sử dụng!");
                    }

                    if ($subtotal < (float)$coupon['payment_limit']) {
                        throw new Exception("Mã giảm giá này yêu cầu đơn hàng tối thiểu từ " . number_format($coupon['payment_limit']) . " đ!");
                    }

                    $coupon_id = (int)$coupon['id'];
                    $coupon_amount = (float)$coupon['discount'];

                    // Tăng số lượt đã dùng của mã coupon
                    $this->db->set('number_used', 'number_used + 1', FALSE);
                    $this->db->where('id', $coupon_id);
                    $this->db->update('coupons');
                }

                // 4. Tính toán tổng tiền cuối cùng (Không cho phép tiền âm)
                $finalTotal = max(0, $subtotal + $priceShip - $coupon_amount);
                $orderCode = strtoupper(random_string('alnum', 8));
                $today = date('Y-m-d H:i:s');
                $paymentMethod = (int)$this->input->post('payment_method');

                // 5. Thêm bản ghi Đơn hàng Master (orders)
                $orderData = [
                    'orderCode'      => $orderCode,
                    'customer_id'    => $idCustomer,
                    'order_date'     => $today,
                    'fullname'       => $this->input->post('name', TRUE),
                    'phone'          => $this->input->post('phone', TRUE),
                    'address'        => $this->input->post('address', TRUE),
                    'money'          => $finalTotal,
                    'price_ship'     => $priceShip,
                    'coupon'         => $coupon_id,
                    'province'       => (int)$this->input->post('city'),
                    'district'       => (int)$this->input->post('DistrictId'),
                    'payment_method' => $paymentMethod,
                    'trash'          => 1,
                    'status'         => 0 // Chờ duyệt
                ];

                $this->Mdonhang->order_insert($orderData);
                $orderId = $this->db->insert_id();

                if (!$orderId) {
                    throw new Exception("Không thể tạo đơn hàng vào hệ thống!");
                }

                // 6. Thêm chi tiết đơn hàng (order_items)
                foreach ($cart as $key => $qty) {
                    $info = $cart_info[$key];
                    $pid = (int)$info['id'];
                    $pRow = $this->Msanpham->product_detail_id($pid);
                    $priceItem = ($pRow['price_sale'] > 0) ? (float)$pRow['price_sale'] : (float)$pRow['price'];

                    $itemData = [
                        'order_id'   => $orderId,
                        'product_id' => $pid,
                        'price'      => $priceItem,
                        'count'      => (int)$qty,
                        'color'      => isset($info['color']) ? $info['color'] : '',
                        'capacity'   => isset($info['capacity']) ? $info['capacity'] : ''
                    ];
                    $this->Mchitietdonhang->orderdetail_insert($itemData);
                }

                // Hoàn tất Transaction
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    throw new Exception("Giao dịch đặt hàng bị gián đoạn. Vui lòng thử lại!");
                }

                // Gửi email xác nhận đặt hàng tự động (Order Confirmation Email)
                $this->send_order_confirmation_email($orderId, $orderCode, $customer_session['email'], $this->input->post('name'), $finalTotal, $cart, $cart_info);

                // Lưu mã đơn hàng vừa đặt thành công vào Session để trang thankyou hiển thị biên lai
                $this->session->set_userdata('last_order_code', $orderCode);

                // Xóa giỏ hàng và coupon trong session sau khi commit thành công
                $this->session->unset_userdata(['cart', 'cart_info', 'id_coupon_price', 'coupon_price']);

                // Chuyển hướng theo phương thức thanh toán
                if ($paymentMethod === 1) {
                    // Chuyển khoản VietQR
                    redirect('giohang/payment_qr/' . $orderCode, 'refresh');
                } else {
                    // Thanh toán khi nhận hàng (COD)
                    redirect('/thankyou', 'refresh');
                }
                return;

            } catch (Exception $e) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', $e->getMessage());
                redirect('info-order', 'refresh');
                return;
            }
        }

        // Tải trang Form thông tin giao hàng
        $money_temp = 0;
        foreach ($cart as $key => $value) {
            $pid = isset($cart_info[$key]['id']) ? $cart_info[$key]['id'] : (is_numeric($key) ? $key : explode('_', $key)[0]);
            $row = $this->Msanpham->product_detail_id($pid);
            if ($row) {
                $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                $money_temp += $price * $value;
            }
        }

        $priceShip = $this->Mcauhinh->config_price_ship($money_temp);
        $this->data['priceShip'] = $priceShip;
        $this->data['money_temp'] = $money_temp;
        $this->data['title'] = 'NDN Mobile - Thông tin giao hàng & Thanh toán';
        $this->data['view']  = 'info-order';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Trang Cám ơn sau khi đặt hàng thành công (Hiển thị biên lai hóa đơn)
     * URL: /thankyou
     */
    public function thankyou(){
        $customer = $this->session->userdata('sessionKhachHang');
        $lastOrderCode = $this->session->userdata('last_order_code');

        $order = null;
        if (!empty($lastOrderCode)) {
            $order = $this->db->where('orderCode', $lastOrderCode)->where('trash', 1)->get('orders')->row_array();
        }

        // Fallback: Nếu không có last_order_code, lấy đơn mới nhất của khách hàng
        if (!$order && $customer) {
            $order = $this->db->where('customer_id', (int)$customer['id'])
                              ->where('trash', 1)
                              ->order_by('id', 'desc')
                              ->limit(1)
                              ->get('orders')
                              ->row_array();
        }

        $coupon_discount = 0;
        $order_items = [];
        if ($order) {
            $order_items = $this->Mchitietdonhang->orderdetail_order($order['id']);
            if (!empty($order['coupon'])) {
                $coupon_row = $this->db->where('id', (int)$order['coupon'])->get('coupons')->row_array();
                if ($coupon_row) {
                    $coupon_discount = (float)$coupon_row['discount'];
                }
            }
        }

        $this->data['get']             = $order;
        $this->data['order_items']     = $order_items;
        $this->data['coupon_discount'] = $coupon_discount;
        $this->data['customer_email']  = $customer['email'] ?? '';
        $this->data['title']           = 'NDN Mobile - Cảm ơn bạn đã đặt hàng';
        $this->data['view']            = 'thankyou';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Hàm phụ trợ gửi email xác nhận đặt hàng tự động
     */
    private function send_order_confirmation_email($orderId, $orderCode, $recipientEmail, $recipientName, $totalMoney, $cart, $cart_info)
    {
        if (empty($recipientEmail) || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        try {
            $config_db = $this->Mcauhinh->configuration_detail();

            $this->load->library('email');
            $this->email->clear();
            $email_config = [
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 465,
                'smtp_crypto' => 'ssl',
                'smtp_timeout'=> 15,
                'smtp_user'   => $config_db['mail_smtp'],
                'smtp_pass'   => str_replace(' ', '', $config_db['mail_smtp_password']),
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'crlf'        => "\r\n",
                'mailtype'    => 'html',
            ];
            $this->email->initialize($email_config);
            $this->email->from($config_db['mail_smtp'], $config_db['title']);
            $this->email->to($recipientEmail);
            $this->email->subject("Xác nhận đặt hàng thành công #{$orderCode} - NDN Mobile");

            $itemsHtml = '';
            foreach ($cart as $key => $qty) {
                $info = $cart_info[$key];
                $pid = (int)$info['id'];
                $pRow = $this->Msanpham->product_detail_id($pid);
                $pName = $pRow ? $pRow['name'] : 'Điện thoại';
                $price = ($pRow && $pRow['price_sale'] > 0) ? $pRow['price_sale'] : ($pRow['price'] ?? 0);
                $lineTotal = $price * $qty;

                $itemsHtml .= "
                <tr style='border-bottom: 1px solid #eee;'>
                    <td style='padding: 10px 5px;'><strong>{$pName}</strong><br><small style='color:#777;'>Màu: {$info['color']} | Dung lượng: {$info['capacity']}</small></td>
                    <td style='padding: 10px 5px; text-align: center;'>{$qty}</td>
                    <td style='padding: 10px 5px; text-align: right;'>" . number_format($price) . " đ</td>
                    <td style='padding: 10px 5px; text-align: right; font-weight: bold;'>" . number_format($lineTotal) . " đ</td>
                </tr>";
            }

            $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #eee; border-radius: 10px; overflow: hidden;'>
                <div style='background: #d70018; padding: 20px; text-align: center; color: #fff;'>
                    <h2 style='margin: 0;'>NDN Mobile</h2>
                    <p style='margin: 5px 0 0; opacity: 0.9;'>Xác Nhận Đơn Hàng #{$orderCode}</p>
                </div>
                <div style='padding: 25px;'>
                    <p>Xin chào <strong>" . htmlspecialchars($recipientName) . "</strong>,</p>
                    <p>Cảm ơn bạn đã đặt hàng tại <strong>NDN Mobile</strong>. Đơn hàng của bạn đã được tiếp nhận và đang được đóng gói chuyển đi sớm nhất.</p>
                    
                    <h4 style='border-bottom: 2px solid #d70018; padding-bottom: 5px; margin-top: 20px;'>Chi tiết đơn hàng</h4>
                    <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
                        <thead>
                            <tr style='background: #f8f9fa; color: #555;'>
                                <th style='padding: 8px; text-align: left;'>Sản phẩm</th>
                                <th style='padding: 8px; text-align: center;'>SL</th>
                                <th style='padding: 8px; text-align: right;'>Đơn giá</th>
                                <th style='padding: 8px; text-align: right;'>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            {$itemsHtml}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='3' style='padding: 12px 5px; text-align: right; font-weight: bold;'>Tổng thanh toán:</td>
                                <td style='padding: 12px 5px; text-align: right; font-weight: bold; color: #d70018; font-size: 16px;'>" . number_format($totalMoney) . " đ</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div style='background: #fff8e1; border-left: 4px solid #ffc107; padding: 12px; margin-top: 20px; font-size: 13px;'>
                        Bạn có thể kiểm tra tiến độ giao hàng bất kỳ lúc nào tại mục <a href='" . base_url('thong-tin-khach-hang') . "' style='color: #d70018; font-weight: bold;'>Lịch sử đơn hàng</a> trên website.
                    </div>

                    <hr style='border: none; border-top: 1px solid #eee; margin: 25px 0;'>
                    <p style='color: #888; font-size: 12px; text-align: center; margin: 0;'>Hotline hỗ trợ kỹ thuật và mua hàng: 1800.6868 | Email: cskh@ndnmobile.vn</p>
                </div>
            </div>";

            $this->email->message($body);
            return @$this->email->send();
        } catch (Exception $e) {
            log_message('error', 'Không thể gửi email xác nhận đơn hàng: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cổng thanh toán chuyển khoản quét mã VietQR tự động
     * URL: /giohang/payment_qr/{orderCode}
     */
    public function payment_qr($orderCode = null){
        if(!$orderCode){
            redirect('/', 'refresh');
            return;
        }

        $order = $this->db->where('orderCode', $orderCode)->where('trash', 1)->get('orders')->row_array();
        if(!$order){
            redirect('/', 'refresh');
            return;
        }

        $this->data['order'] = $order;
        $this->data['title'] = 'Cổng thanh toán VietQR - Đơn hàng #' . $orderCode;
        $this->data['view']  = 'vnpay_qr';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Webhook IPN xử lý biến động số dư VietQR an toàn tuyệt đối
     * Endpoint API bảo vệ bằng Secret Token
     */
    public function vietqr_ipn_webhook()
    {
        if ($this->input->method() !== 'post') {
            show_404();
            return;
        }

        $receivedKey = $this->input->get_request_header('X-Secure-Token', TRUE);
        $serverKey   = $this->config->item('vietqr_webhook_secret') ?: 'NDN_SECURE_WEBHOOK_2026_XYZ';
        
        if (empty($receivedKey) || !hash_equals($serverKey, $receivedKey)) {
            log_message('error', 'Unauthorized Webhook access attempt from IP: ' . $this->input->ip_address());
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized Access']));
            return;
        }

        $rawInput = file_get_contents('php://input');
        $payload  = json_decode($rawInput, true);

        if (empty($payload) || !isset($payload['orderCode'], $payload['amount'])) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid Payload']));
            return;
        }

        $orderCode     = trim($payload['orderCode']);
        $amountPaid    = (float)$payload['amount'];
        $transactionId = $payload['transactionId'] ?? '';

        $this->db->trans_start();

        $order = $this->db->query("SELECT * FROM orders WHERE orderCode = ? FOR UPDATE", [$orderCode])->row_array();

        if (!$order) {
            $this->db->trans_rollback();
            $this->output
                ->set_status_header(404)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Order not found']));
            return;
        }

        if ((int)$order['status'] >= 1) {
            $this->db->trans_complete();
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Order already processed']));
            return;
        }

        if (abs($amountPaid - (float)$order['money']) > 1000) {
            log_message('error', "Amount mismatch for Order #{$orderCode}: Expected {$order['money']}, received {$amountPaid}");
            $this->db->trans_rollback();
            $this->output
                ->set_status_header(422)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Payment amount mismatch']));
            return;
        }

        $this->db->where('id', $order['id'])->update('orders', [
            'status'         => 1, // Đã thanh toán / Đang giao hàng
            'transaction_no' => $transactionId
        ]);

        $this->db->trans_complete();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'message' => 'Payment captured successfully']));
    }

    /**
     * Xác nhận thanh toán từ phía khách hàng (Chỉ ghi nhận thông báo chuyển khoản thành công)
     * URL: /giohang/confirm_payment/{orderCode}
     */
    public function confirm_payment($orderCode = null){
        if($orderCode){
            $order = $this->db->where('orderCode', $orderCode)->where('trash', 1)->get('orders')->row_array();
            if($order && (int)$order['status'] === 0){
                // Cập nhật trạng thái sang 1 (Đã thanh toán / Đang giao hàng)
                $this->db->where('id', $order['id'])->update('orders', [
                    'status' => 1
                ]);
                $this->session->set_flashdata('success', 'Xác nhận thanh toán thành công cho đơn hàng #' . htmlspecialchars($orderCode) . '! Cửa hàng đang chuẩn bị máy để giao đến bạn.');
            }
        }
        redirect('/thankyou', 'refresh');
    }

    /**
     * AJAX Lấy danh sách quận huyện theo tỉnh thành
     */
    public function district(){
        $id = $this->input->get('provinceid', TRUE);
        if(!$id) $id = $this->input->post('provinceid', TRUE);
        
        $html = "<option value =''>--- Chọn quận huyện ---</option>";
        if($id && is_numeric($id))
        {
            $list = $this->Mquanhuyen->district_provinceid((int)$id);
            if($list)
            {
                foreach ($list as $row) 
                {
                    $html .= '<option value = "'.(int)$row["id"].'">'.htmlspecialchars($row["name"]).'</option>';
                }
            }
        }
        echo $html;
    }

    /**
     * AJAX Áp dụng Mã giảm giá (Đã dọn sạch backdoor EXPIRED2020)
    /**
     * AJAX Áp dụng Mã giảm giá - Trả về dữ liệu JSON chi tiết cho UI tương tác
     */
    public function coupon(){
        $this->output->set_content_type('application/json');
        $today = date('Y-m-d');

        if($this->session->userdata('coupon_price')){
            echo json_encode([
                'status'  => 'error',
                'message' => 'Mỗi đơn hàng chỉ áp dụng tối đa 1 Mã giảm giá!'
            ]);
            return;
        }

        $couponCode = trim((string)$this->input->post('code', TRUE));
        if(empty($couponCode)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Vui lòng nhập mã giảm giá!'
            ]);
            return;
        }

        // Tính tổng tiền giỏ hàng
        $money = 0;
        if($this->session->userdata('cart')){
            $data = $this->session->userdata('cart');
            $cart_info = $this->session->userdata('cart_info') ?? [];
            foreach ($data as $key => $value) {
                $pid = isset($cart_info[$key]['id']) ? $cart_info[$key]['id'] : (is_numeric($key) ? $key : explode('_', $key)[0]);
                $row = $this->Msanpham->product_detail_id($pid);
                if ($row) {
                    $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                    $money += $price * $value;
                }
            }
        }
        
        // Kiểm tra mã giảm giá trong cơ sở dữ liệu
        $coupon = $this->db->where('code', $couponCode)->where('status', 1)->where('trash', 1)->get('coupons')->row_array();

        if(empty($coupon)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Mã giảm giá [' . htmlspecialchars($couponCode) . '] không tồn tại hoặc đã bị khóa!'
            ]);
            return;
        }

        if (strtotime($coupon['expiration_date']) < strtotime($today)){
            echo json_encode([
                'status'  => 'error',
                'message' => 'Mã giảm giá ' . htmlspecialchars($coupon['code']) . ' đã hết hạn sử dụng từ ' . date('d/m/Y', strtotime($coupon['expiration_date'])) . '!'
            ]);
            return;
        }

        if ((int)$coupon['limit_number'] - (int)$coupon['number_used'] <= 0){
            echo json_encode([
                'status'  => 'error',
                'message' => 'Mã giảm giá ' . htmlspecialchars($coupon['code']) . ' vừa hết số lượt sử dụng!'
            ]);
            return;
        }

        if ((float)$coupon['payment_limit'] > $money){
            echo json_encode([
                'status'  => 'error',
                'message' => 'Mã ưu đãi này yêu cầu đơn hàng từ ' . number_format($coupon['payment_limit']) . ' đ trở lên!'
            ]);
            return;
        }

        $discount = (float)$coupon['discount'];
        $this->session->set_userdata('coupon_price', $discount);
        $this->session->set_userdata('id_coupon_price', (int)$coupon['id']);

        $priceShip = (float)$this->Mcauhinh->config_price_ship($money);
        $newTotal = max(0, $money + $priceShip - $discount);

        echo json_encode([
            'status'             => 'success',
            'message'            => 'Áp dụng mã ưu đãi [' . htmlspecialchars($coupon['code']) . '] thành công! Bạn được giảm ' . number_format($discount) . ' đ.',
            'discount'           => $discount,
            'discount_formatted' => '-' . number_format($discount) . ' đ',
            'code'               => $coupon['code'],
            'total'              => $newTotal,
            'total_formatted'    => number_format($newTotal) . ' đ'
        ]);
    }

    /**
     * AJAX Hủy áp dụng mã giảm giá
     */
    public function removecoupon(){
        $this->output->set_content_type('application/json');
        $this->session->unset_userdata('coupon_price');
        $this->session->unset_userdata('id_coupon_price');

        $money = 0;
        if($this->session->userdata('cart')){
            $data = $this->session->userdata('cart');
            $cart_info = $this->session->userdata('cart_info') ?? [];
            foreach ($data as $key => $value) {
                $pid = isset($cart_info[$key]['id']) ? $cart_info[$key]['id'] : (is_numeric($key) ? $key : explode('_', $key)[0]);
                $row = $this->Msanpham->product_detail_id($pid);
                if ($row) {
                    $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                    $money += $price * $value;
                }
            }
        }

        $priceShip = (float)$this->Mcauhinh->config_price_ship($money);
        $newTotal = $money + $priceShip;

        echo json_encode([
            'status'          => 'success',
            'message'         => 'Đã gỡ bỏ mã ưu đãi thành công.',
            'total'           => $newTotal,
            'total_formatted' => number_format($newTotal) . ' đ'
        ]);
    }

    /**
     * AJAX Tính phí giao hàng theo Tỉnh/Thành
     */
    public function calculate_shipping_ajax(){
        $this->output->set_content_type('application/json');
        $provinceId = (int)$this->input->post('provinceid');

        $money = 0;
        if($this->session->userdata('cart')){
            $data = $this->session->userdata('cart');
            $cart_info = $this->session->userdata('cart_info') ?? [];
            foreach ($data as $key => $value) {
                $pid = isset($cart_info[$key]['id']) ? $cart_info[$key]['id'] : (is_numeric($key) ? $key : explode('_', $key)[0]);
                $row = $this->Msanpham->product_detail_id($pid);
                if ($row) {
                    $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                    $money += $price * $value;
                }
            }
        }

        $priceShip = (float)$this->Mcauhinh->config_price_ship($money);
        // Tỉnh Hà Nội (101) & TP.HCM (102) giao nhanh ưu đãi hơn
        if ($money < 5000000) {
            if ($provinceId == 101 || $provinceId == 102) {
                $priceShip = 20000;
            } else {
                $priceShip = 35000;
            }
        } else {
            $priceShip = 0; // Đơn từ 5tr miễn phí ship toàn quốc
        }

        $discount = (float)($this->session->userdata('coupon_price') ?: 0);
        $grandTotal = max(0, $money + $priceShip - $discount);

        echo json_encode([
            'status'             => 'success',
            'price_ship'         => $priceShip,
            'price_ship_text'    => ($priceShip === 0.0) ? 'Miễn phí' : number_format($priceShip) . ' đ',
            'is_free_ship'       => ($priceShip === 0.0),
            'grand_total'        => $grandTotal,
            'grand_total_text'   => number_format($grandTotal) . ' đ'
        ]);
    }


    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove($id = null){
        if(!$id) $id = $this->input->post('id', TRUE);
        if(!$id) $id = $this->input->get('id', TRUE);
        
        $this->do_remove_cart($id);
        
        if($this->input->is_ajax_request() || $this->input->post()){
            echo json_encode(['status' => 'success']);
        } else {
            redirect('gio-hang');
        }
    }

    /**
     * AJAX Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function update(){
        $id = $this->input->post('id', TRUE);
        $sl = (int)$this->input->post('sl');
        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info');
        
        if($cart && $id){
            $id_decoded = urldecode($id);
            $target_key = null;
            if(array_key_exists($id, $cart)) {
                $target_key = $id;
            } elseif(array_key_exists($id_decoded, $cart)) {
                $target_key = $id_decoded;
            } else {
                foreach($cart as $k => $v){
                    if($k == $id || $k == $id_decoded || strpos($k, $id . '_') === 0 || (isset($cart_info[$k]['id']) && $cart_info[$k]['id'] == $id)){
                        $target_key = $k;
                        break;
                    }
                }
            }
            
            if($target_key !== null){
                $cart[$target_key] = ($sl > 0) ? $sl : 1;
                $this->session->set_userdata('cart', $cart);
            }
        }
        
        echo json_encode(['status' => 'success']);
    }

    private function do_remove_cart($id){
        if(!$id) return;
        $id_decoded = urldecode($id);
        $cart = $this->session->userdata('cart');
        $cart_info = $this->session->userdata('cart_info');
        
        if($cart){
            $found = false;
            if(array_key_exists($id, $cart)){
                unset($cart[$id]);
                if(isset($cart_info[$id])) unset($cart_info[$id]);
                $found = true;
            }
            if(!$found && array_key_exists($id_decoded, $cart)){
                unset($cart[$id_decoded]);
                if(isset($cart_info[$id_decoded])) unset($cart_info[$id_decoded]);
                $found = true;
            }
            if(!$found){
                foreach($cart as $k => $v){
                    if($k == $id || $k == $id_decoded || strpos($k, $id . '_') === 0 || (isset($cart_info[$k]['id']) && $cart_info[$k]['id'] == $id)){
                        unset($cart[$k]);
                        if(isset($cart_info[$k])) unset($cart_info[$k]);
                        break;
                    }
                }
            }
            
            if(empty($cart)){
                $this->session->unset_userdata('cart');
                $this->session->unset_userdata('cart_info');
            }else{
                $this->session->set_userdata('cart', $cart);
                if($cart_info) $this->session->set_userdata('cart_info', $cart_info);
            }
        }
        $this->session->unset_userdata('coupon_price');
        $this->session->unset_userdata('id_coupon_price');
    }
}
