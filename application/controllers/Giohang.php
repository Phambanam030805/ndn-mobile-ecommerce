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
class Giohang extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Mdonhang');
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mchitietdonhang');
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mcauhinh');
        $this->load->model('frontend/Mquanhuyen');
        $this->load->model('frontend/Mtinhthanh');
        $this->data['com']='giohang';
    }
    
    public function index(){
        $this->data['title']='NDN Mobile - Giỏ hàng của bạn';
        $this->data['view']='index';
        $this->load->view('frontend/layout',$this->data);
    }
    function check_mail(){
        $email = $this->input->post('email');
        if($this->Mkhachhang->customer_detail_email($email))
        {
            $this->form_validation->set_message(__FUNCTION__, 'Email đã đã là thành viên, Vui lòng đăng nhập hoặc nhập Email khác !');
            return FALSE;
        }
        return TRUE;
    }
    public function info_order(){
        $this->load->library('session');
        $this->load->helper('string');
        $this->load->library('email');
        $this->load->library('form_validation');
        $today=date('Y-m-d H:i:s');
        if(!$this->session->userdata('sessionKhachHang'))
        {
            $this->form_validation->set_rules('email', 'Địa chỉ email', 'required|is_unique[users.email]');
        }
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
        $this->form_validation->set_rules('name', 'Họ và tên', 'required|min_length[3]');
        $this->form_validation->set_rules('address', 'Địa chỉ', 'required');
        $this->form_validation->set_rules('city', 'Tỉnh thành', 'required');
        $this->form_validation->set_rules('DistrictId', 'Quận huyện', 'required');
        if($this->form_validation->run() == TRUE){
            //Tinh tien don hang
            $money=0;
            if($this->session->userdata('cart')){
                $data=$this->session->userdata('cart');
                foreach ($data as $key => $value) {
                    $row = $this->Msanpham->product_detail_id($key);
                    
                    // KIỂM TRA SỐ LƯỢNG TỒN KHO (Khớp với báo cáo TC03)
                    if($value > ($row['number'] - $row['number_buy'])){
                        $this->session->set_flashdata('error', 'Sản phẩm ['.$row['name'].'] chỉ còn '.($row['number'] - $row['number_buy']).' sản phẩm trong kho. Vui lòng cập nhật lại số lượng!');
                        redirect('gio-hang','refresh');
                    }

                    $total=0;
                    if($row['price_sale'] > 0){
                        $total=$row['price_sale']*$value;
                    }else{
                        $total=$row['price'] * $value;
                    }
                    $money+=$total;
                }
            }
            // Tính lại phí ship dựa trên tổng tiền
            $priceShip = $this->Mcauhinh->config_price_ship($money);
            $idCustomer=null;
            if($this->session->userdata('sessionKhachHang')){
                $info=$this->session->userdata('sessionKhachHang');
                $idCustomer=$info['id'];
                $emailtemp = $info['email'];
            }else{
                $emailtemp = $this->input->post('email');
            }
            if(!$this->session->userdata('sessionKhachHang')){
                $datacustomer= array(
                    'fullname'=>$this->input->post('name'),
                    'phone'=> $this->input->post('phone'),
                    'email'=> $emailtemp,
                    'created_at' =>$today,
                    'role' => 3,
                    'username' => '', 
                    'password' => '', 
                    'address' => $this->input->post('address'), 
                    'status'=>1,
                    'trash'=>1
                );
                $this->Mkhachhang->customer_insert($datacustomer);
                $idCustomer = $this->db->insert_id();
                $row=$this->Mkhachhang->customer_detail($idCustomer);
                $this->session->set_userdata('info-customer',$row);
                $info=$this->session->userdata('info-customer');
                if(isset($info['id'])){
                    $idCustomer=$info['id'];
                    $this->session->set_userdata('id-info-customer',$idCustomer);
                }
            }
            //kt ma giam gia
            $coupon_id = NULL;
            $coupon_amount = 0;
            if($this->session->userdata('coupon_price'))
            {
                $coupon_amount = $this->session->userdata('coupon_price');
                $coupon_id = $this->session->userdata('id_coupon_price');
                $amount_number_used = $this->Mcauhinh->get_amount_number_used($coupon_id);
                $mycoupon=array(
                    'number_used' => $amount_number_used+1,
                );
                $this->Mcauhinh->coupon_update($mycoupon, $coupon_id);
            }

            $provinceId = $this->input->post('city');
            $districtId = $this->input->post('DistrictId');
            $mydata=array(
                'orderCode' => random_string('alnum', 8),
                'customer_id' => $idCustomer,
                'order_date' => $today,
                'fullname' => $this->input->post('name'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'money' => $money + $priceShip - $coupon_amount,
                'price_ship' => $priceShip,
                'coupon' => $coupon_id,
                'province' => $provinceId,
                'district' => $districtId,
                'payment_method' => $this->input->post('payment_method'),
                'trash' => 1,
                'status' => 0
            );

            //Insert to db_order
            $this->Mdonhang->order_insert($mydata);
            $orderid = $this->db->insert_id();


            // lưu tt đơn hàng và xóa session coupon
            $this->session->unset_userdata('id_coupon_price');
            $this->session->unset_userdata('coupon_price');

            //Insert to db_orderdetail
            if($this->session->userdata('cart')){
                $val = $this->session->userdata('cart');
                $cart_info = $this->session->userdata('cart_info');
                foreach ($val as $key => $value){
                    $info = $cart_info[$key];
                    $row = $this->Msanpham->product_detail_id($info['id']);
                    if($row['price_sale'] > 0){
                        $price = $row['price_sale'];
                    }else{
                        $price = $row['price'];
                    }
                    $data = array(
                        'order_id' => $orderid,
                        'product_id' => $info['id'],
                        'price' => $price,
                        'count' => $value,
                        'color' => $info['color'],
                        'capacity' => $info['capacity']
                    );
                    $this->Mchitietdonhang->orderdetail_insert($data);
                }
            }
            $array_items = array('cart', 'cart_info');
            $this->session->unset_userdata($array_items);
            
            if ($this->input->post('payment_method') == 1) {
                // Giả lập chuyển hướng đến cổng thanh toán VNPay
                // Trong thực tế, bạn sẽ build URL VNPay tại đây và redirect()
                $this->session->set_flashdata('success', 'Đang chuyển hướng đến cổng thanh toán Online...');
                // Giả định thanh toán thành công và về trang cám ơn
                redirect('/thankyou','refresh');
            } else {
                redirect('/thankyou','refresh');
            }

        } else {
            // Trường hợp load view info_order (chưa submit hoặc lỗi form)
            $money_temp = 0;
            if($this->session->userdata('cart')){
                $cart_data = $this->session->userdata('cart');
                foreach ($cart_data as $key => $value) {
                    $row = $this->Msanpham->product_detail_id($key);
                    $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                    $money_temp += $price * $value;
                }
            }
            $priceShip = $this->Mcauhinh->config_price_ship($money_temp);
            $this->data['cart'] = $this->session->userdata('cart');
            $this->data['priceShip'] = $priceShip;
            $this->data['province'] = $this->Mtinhthanh->province_all();
            $this->data['title']='NDN Mobile - Thông tin đơn hàng';
            $this->data['view']='info-order';
            $this->load->view('frontend/layout',$this->data);
        }
    }

    public function thankyou(){
        if($this->session->userdata('info-customer')||$this->session->userdata('sessionKhachHang')){
            if($this->session->userdata('sessionKhachHang')){
                $val = $this->session->userdata('sessionKhachHang');
            }else{
                $val = $this->session->userdata('info-customer');
            }
            $list = $this->Mdonhang->order_detail_customerid($val['id']);

            if (!$list) {
                // Nếu không tìm thấy đơn hàng, quay về trang chủ thay vì hiện màn hình trắng
                redirect('/', 'refresh');
            }

            // Lấy chi tiết đơn hàng (đã được join với bảng products để lấy tên sản phẩm)
            $order_detail = $this->Mchitietdonhang->orderdetail_order_join_product($list['id']);

            $data = array(
                'order' => $list,
                'customer' => $val,
                'orderDetail' => $order_detail,
                'province' => $this->Mtinhthanh->province_name($list['province']),
                'district' => $this->Mquanhuyen->district_name($list['district']),
                'priceShip' => $list['price_ship'],
                'coupon' => 0,
            );

            // Nếu có mã giảm giá (lưu theo ID), lấy số tiền giảm giá thực tế để hiển thị
            if($list['coupon'] != NULL) {
                $coupon_detail = $this->db->where('id', $list['coupon'])->get('coupons')->row_array();
                if($coupon_detail) {
                    $data['coupon'] = $coupon_detail['discount'];
                    $list['coupon'] = $coupon_detail['discount']; // Cập nhật luôn cho biến $list
                }
            }
            $this->data['customer']=$val;
            $this->data['get']=$list;
            // LẤY CẤU HÌNH SMTP TỪ DATABASE
            $config_db = $this->Mcauhinh->configuration_detail();
            
            $this->load->library('email');
            $this->load->library('parser');
            $this->email->clear();
            
            // Cấu hình email linh hoạt từ Admin
            $config['protocol']     = 'smtp';
            $config['smtp_host']    = 'smtp.gmail.com';
            $config['smtp_port']    = '465';
            $config['smtp_crypto']  = 'ssl'; // Sử dụng SSL để bảo mật
            $config['smtp_timeout'] = '30';
            $config['smtp_user']    = $config_db['mail_smtp']; 
            $config['smtp_pass']    = $config_db['mail_smtp_password']; 
            $config['charset']      = 'utf-8';
            $config['newline']      = "\r\n";
            $config['wordwrap']     = TRUE;
            $config['mailtype']     = 'html';
            
            $this->email->initialize($config);
            $this->email->from($config_db['mail_smtp'], $config_db['title']);
            $this->email->to($val['email']);
            $this->email->subject('Xác nhận đơn hàng #' . $list['orderCode'] . ' - NDN Mobile');
            
            // Sử dụng template email chuyên nghiệp
            $body = $this->load->view('frontend/modules/email', $data, TRUE);
            $this->email->message($body); 
            
            // Gửi email và xử lý lỗi
            if (!$this->email->send()) {
                // Nếu lỗi, ghi vào log để kiểm tra (hoặc tạm thời echo để debug)
                log_message('error', $this->email->print_debugger());
                // echo $this->email->print_debugger(); // Bỏ comment dòng này để xem lỗi trực tiếp trên web
            }

            $this->session->unset_userdata('id-info-customer','money_check_coupon');
        }   
        $this->data['title']='NDN Mobile.vn - Kết quả đơn hàng';
        $this->data['view']='thankyou';
        $this->load->view('frontend/layout',$this->data);
    }

    public function district(){
        $id = $this->input->get('provinceid');
        if(!$id) $id = $this->input->post('provinceid');
        log_message('error', 'District AJAX called with provinceid: ' . $id);
        $html="<option value =''>--- Chọn quận huyện ---</option>";
        if($id)
        {
            $list = $this->Mquanhuyen->district_provinceid($id);
            if($list)
            {
                foreach ($list as $row) 
                {
                    $html.='<option value = "'.$row["id"].'">'.$row["name"].'</option>';
                }
            }
        }
        echo $html;
    }
    public function coupon(){
        $today = date('Y-m-d');
        $html='';
        if($this->session->userdata('coupon_price')){
            $html.='<p style="color:red">Mỗi đơn hàng chỉ áp dụng 1 Mã giảm giá !!</p>';
        }else{
            $coupon = $this->input->post('code');
            if(empty($coupon))
            {
                $html.='<p style="color:red">Vui lòng nhập Mã giảm giá nếu có !!</p>';
            }
            else
            {
                // KIỂM TRA SỐ TIỀN TRONG GIỎ HÀNG
                $money=0;
                if($this->session->userdata('cart')){
                    $data=$this->session->userdata('cart');
                    foreach ($data as $key => $value) {
                        $row = $this->Msanpham->product_detail_id($key);
                        $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                        $money += $price * $value;
                    }
                }
                
                // KIỂM TRA MÃ GIẢM GIÁ
                $getcoupon = $this->Mcauhinh->get_config_coupon_discount($coupon);
                if(empty($getcoupon)) {
                    $html.='<p style="color:red">Mã giảm giá không tồn tại hoặc đã hết hạn!</p>';
                } else {
                    foreach ($getcoupon as $value) {
                        if($value['code'] == $coupon)
                        {
                            if (strtotime($value['expiration_date']) < strtotime($today)){
                                $html.='<p style="color:red">Mã giảm giá '.$value['code'].' đã hết hạn sử dụng từ ngày '.$value['expiration_date'].' !</p>';
                            }else if($value['limit_number'] - $value['number_used'] <= 0){
                                $html.='<p style="color:red">Mã giảm giá '.$value['code'].' đã hết số lần sử dụng !</p>';
                            }else if($value['payment_limit'] > $money ){
                                $html.='<p style="color:red"> Mã giảm giá này chỉ áp dụng cho đơn hàng từ '.number_format($value['payment_limit']).' đ trở lên !</p>';
                            }else{
                                $html.='<p style="color:green">Áp dụng mã giảm giá thành công ! Hệ thống đang cập nhật...</p>';
                                $html.='<script>setTimeout(function(){ location.reload(); }, 1500);</script>';
                                $this->session->set_userdata('coupon_price',$value['discount']);
                                $this->session->set_userdata('id_coupon_price',$value['id']);
                            }
                        }
                    }
                }
            }
        }
        echo $html;
    }
public function removecoupon(){
    $html='<script>document.location.reload(true);</script>';
    $this->session->unset_userdata('coupon_price');
    $this->session->unset_userdata('id_coupon_price');
    echo $html;
}
}
// email trang thankyou bị sai
