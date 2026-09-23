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
class E403 extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('backend/Mnguoidung');
		$this->load->model('backend/Mdonhang');
		if(!$this->session->userdata('sessionadmin'))
		{
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='e403';
	}

	public function index(){
		$this->data['view']='index';
		$this->data['title']='Lỗi 403 - Không có quyền truy cập';
		$this->load->view('backend/layout', $this->data);
	}

}