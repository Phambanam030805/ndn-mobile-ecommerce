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
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|min_length[5]|max_length[32]');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[5]|max_length[32]');
        if ($this->form_validation->run() ==TRUE)
        {
        	$username = $this->input->post('username');
        	$password = sha1($this->input->post('password'));
        	if($this->Mnguoidung->user_login($username, $password)!=FALSE)
        	{
        		$row = $this->Mnguoidung->user_login($username, $password);
        		$this->session->set_userdata('sessionadmin',$row);
        		$this->session->set_userdata('id',$row['id']);
        		$this->session->set_userdata('fullname',$row['fullname']);
        		$this->session->set_userdata('img',$row['img']);
        		redirect('admin','refresh');
        	}
        	else
	        {
	        	$data['error']='Thông tin đăng nhập không chính xác';
	        	$this->load->view('backend/components/user/login', $data);
	        }
        }
        else
        {
        	$this->load->view('backend/components/user/login');
        }
	}

	public function logout()
	{
		$array_items = array('sessionadmin', 'id', 'fullname', 'img');
        $this->session->unset_userdata($array_items);
		redirect('admin','refresh');
	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */