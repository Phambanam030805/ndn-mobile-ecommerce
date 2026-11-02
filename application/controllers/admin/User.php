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
class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend/Mnguoidung');
		$this->load->model('backend/Mdonhang');
	}

	public function login()
	{
		// Nếu đã đăng nhập admin rồi thì vào thẳng trang quản trị
		if($this->session->userdata('sessionadmin')){
			redirect('admin','refresh');
		}
		// Dùng chung trang đăng nhập tại website (/dang-nhap)
		redirect('dang-nhap','refresh');
	}

	public function logout()
	{
		$array_items = array('sessionadmin', 'id', 'fullname', 'img');
		$this->session->unset_userdata($array_items);
		// Chuyển hướng về trang đăng nhập chung tại website
		redirect('dang-nhap','refresh');
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */