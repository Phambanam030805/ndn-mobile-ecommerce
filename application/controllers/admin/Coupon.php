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
 * @property array $data
 */
class Coupon extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend/Mgiamgia');
		$this->load->model('backend/Mdonhang');
        //$this->load->model('backend/Mnguoidung');
		if(!$this->session->userdata('sessionadmin'))
		{
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='coupon';
	}

	public function index()
	{
		$today = date('Y-m-d');
		// Tự động lấy lên danh sách mã giảm giá đã tạo tự động, kt ngày hết hạn mã đó, xóa đi những mã hết hạn
		$list_coupon_aotu_check = $this->Mgiamgia->coupon_auto_all();
		foreach ($list_coupon_aotu_check as $row) {
			if(strtotime($row['expiration_date']) <= strtotime($today) || $row['number_used'] ==1){
				$this->Mgiamgia->coupon_delete($row['id']);
			}
		}
		//
		$this->load->library('phantrang');

		$search = $this->input->get('search', TRUE);
		$search = trim($search ? $search : '');

		$limit = 10;
		$current = $this->phantrang->PageCurrent();
		$first = $this->phantrang->PageFirst($limit, $current);
		$total = $this->Mgiamgia->coupon_count($search);

		$url = 'admin/coupon';
		if (!empty($search)) {
			$url .= '?search=' . urlencode($search);
		}

		$this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
		$this->data['list']         = $this->Mgiamgia->coupon_all($limit, $first, $search);
		$this->data['search']       = $search;
		$this->data['total']        = $total;
		$this->data['view']         = 'index';
		$this->data['title']        = 'Danh sách mã giảm giá';
		$this->load->view('backend/layout', $this->data);
	}

	public function insert()
	{
		$user_role=$this->session->userdata('sessionadmin');
		if($user_role['role']==2){
			redirect('admin/E403/index','refresh');
		}
		$today = date('Y-m-d H:i:s');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->form_validation->set_rules('discount', 'Số tiền giảm giá', 'required');
		$this->form_validation->set_rules('limit_number', 'Số lần giới hạn nhập', 'required');
		$this->form_validation->set_rules('payment_limit', 'Số tiền đơn hàng tối thiểu', 'required|numeric');
		$this->form_validation->set_rules('expiration_date', 'Ngày hết hạn', 'required');
		$this->form_validation->set_rules('code', 'Tên mã giảm giá', 'required|is_unique[coupons.code]|min_length[5]|max_length[10]');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'code' =>$_POST['code'],
				'discount' =>$_POST['discount'],
				'limit_number'=>$_POST['limit_number'], 
				'payment_limit'=>$_POST['payment_limit'], 
				'expiration_date'=>$_POST['expiration_date'],
				'description'=>$_POST['description'],
				'number_used' => 0,
				'created_at'=>$today,
				'orders'=>1,
				'trash'=>1,
				'status'=>$_POST['status']
			);
			$this->Mgiamgia->coupon_insert($mydata);
			$this->session->set_flashdata('success', 'Thêm mã giảm giá thành công');
			redirect('admin/coupon','refresh');
		} 
		else 
		{
			$this->data['view']='insert';
			$this->data['title']='Thêm Mã giảm giá mới';
        	$this->load->view('backend/layout', $this->data);
		}
	}

	public function update($id)
	{
		$user_role=$this->session->userdata('sessionadmin');
		if($user_role['role']==2){
			redirect('admin/E403/index','refresh');
		}
		$this->data['row']=$this->Mgiamgia->coupon_detail($id);
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->form_validation->set_rules('discount', 'Số tiền giảm giá', 'required');
		$this->form_validation->set_rules('payment_limit', 'Số tiền đơn hàng tối thiểu', 'required|numeric');
		$this->form_validation->set_rules('expiration_date', 'Ngày hết hạn', 'required');
		$this->form_validation->set_rules('code', 'Tên mã giảm giá', 'required|min_length[5]|max_length[10]');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'code' =>$_POST['code'],
				'discount' =>$_POST['discount'],
				'limit_number'=>$_POST['limit_number'], 
				'payment_limit'=>$_POST['payment_limit'], 
				'expiration_date'=>$_POST['expiration_date'],
				'description'=>$_POST['description'],
				'trash'=>1,
				'status'=>$_POST['status']
			);
			$this->Mgiamgia->coupon_update($mydata, $id);
			$this->session->set_flashdata('success', 'Cập nhật mã giảm giá thành công');
			redirect('admin/coupon','refresh');
		}
		else
		{
			$this->data['view']='update';
			$this->data['title']='Cập nhật mã giảm giá';
			$this->load->view('backend/layout', $this->data);
		}
	}

	public function status($id)
	{
		$row=$this->Mgiamgia->coupon_detail($id);
		$status=($row['status']==1)?0:1;
		$mydata= array('status' => $status);
		$this->Mgiamgia->coupon_update($mydata, $id);
		$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		redirect('admin/coupon','refresh');
	}

	public function trash($id)
	{
		$mydata= array('trash' => 0);
		$this->Mgiamgia->coupon_update($mydata, $id);
		$this->session->set_flashdata('success', 'Xóa mã giảm giá vào thùng rác thành công');
		redirect('admin/coupon','refresh');
	}

	public function recyclebin()
	{
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mgiamgia->coupon_trash_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/coupon/recyclebin');
		$this->data['list']=$this->Mgiamgia->coupon_trash($limit, $first);
		$this->data['view']='recyclebin';
		$this->data['title']='Thùng rác mã giảm giá';
		$this->load->view('backend/layout', $this->data);
	}

	public function restore($id)
	{
		$this->Mgiamgia->coupon_restore($id);
		$this->session->set_flashdata('success', 'Khôi phục mã giảm giá thành công');
		redirect('admin/coupon/recyclebin','refresh');
	}
	public function delete($id)
	{
		$this->Mgiamgia->coupon_delete($id);
		$this->session->set_flashdata('success', 'Xóa mã giảm giá thành công');
		redirect('admin/coupon/recyclebin','refresh');
	}

}
