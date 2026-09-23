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
class Thongtin extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->data['com']='thongtin';
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdonhang');
        $this->load->model('frontend/Mchitietdonhang');
        $this->load->model('frontend/Mthongtinkhach');
        $this->load->model('frontend/Mtinhthanh');
        $this->load->model('frontend/Mquanhuyen');
        $this->load->model('frontend/Mcauhinh');
        if(!$this->session->userdata('sessionKhachHang')){
            redirect('dang-nhap','refresh');
        }
        $this->data['info']=$this->Mthongtinkhach->customer_detail_id($this->session->userdata('id'));
    }
    
    public function index(){
        $this->data['title']='NDN Mobile - Thông tin tài khoản';
        $this->data['view']='index';
        $this->load->view('frontend/layout',$this->data);
    }

    public function order(){
        $aurl= explode('/',uri_string());
        $id = $aurl[2];
        $this->data['orderid'] = $id;
        $priceShip=$this->Mcauhinh->config_price_ship();
        $this->data['row'] = $this->Mchitietdonhang->orderdetail_order_join_product($id);
        $info = $this->Mthongtinkhach->order_orderid($id);
        
        // Lấy số tiền giảm giá thực tế thay vì lấy ID coupon
        if ($info && $info['coupon'] != NULL) {
            $coupon_detail = $this->db->where('id', $info['coupon'])->get('coupons')->row_array();
            if ($coupon_detail) {
                $info['coupon_amount'] = $coupon_detail['discount'];
            } else {
                $info['coupon_amount'] = 0;
            }
        } else {
            $info['coupon_amount'] = 0;
        }

        $this->data['info'] = $info;
        $this->data['title'] = 'NDN Mobile - Chi tiết đơn hàng';  
        $this->data['view']='detail';
        $this->load->view('frontend/layout',$this->data);
    }

    public function reset_password(){
        $row=$this->Mkhachhang->customer_check_username($this->session->userdata('username'));
        $this->data['row']=$row;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_old', 'Mật khẩu', 'required|callback_check_password');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[32]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');
        if($this->form_validation->run() ==TRUE){ 
            $password_old = $_POST['password_old'];
            $password_new = md5($_POST['password']);
            if($this->session->userdata('sessionKhachHang')){
                $mydata= array(
                    'password' => $password_new,
                );
            }else{
               redirect('/dang-nhap','refresh');
           }
           $this->Mkhachhang->customer_update($mydata, $this->session->userdata('id'));
           $this->data['successpassword']='Đổi mật khẩu thành công';
           echo '<script>alert("Mật khẩu đã được thay đổi thành công !")</script>';
           redirect('thong-tin-khach-hang','refresh');
       }
       $this->data['title']='NDN Mobile - Đổi mật khẩu';
       $this->data['view']='reset_password';
       $this->load->view('frontend/layout',$this->data);
   }

    public function update($id){
        $row=$this->Mdonhang->order_detail($id);
        $status = $row['status'];
        if($status == 0)
        {
            $status = 3;
            $mydata= array('status' => $status);
            $this->Mdonhang->order_update($mydata, $id);
            redirect('thong-tin-khach-hang','refresh');
        }
    }

   function check_password(){
        $row=$this->Mkhachhang->customer_detail_email($this->session->userdata('email'));
        $password = $this->input->post('password_old');
        if(md5($password)!= $row['password']){
            $this->form_validation->set_message(__FUNCTION__, 'Mật khẩu cũ không chính xác');
            return FALSE;
        }
        return TRUE;
    }

}
