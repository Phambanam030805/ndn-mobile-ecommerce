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
class Lienhe extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->data['com']='Lienhe';
		$this->load->model('frontend/Mdanhmuc');
		$this->load->model('frontend/Msanpham');
		$this->load->model('frontend/Mlienhe');

	}
	
	public function index()
	{	
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday'];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Họ và tên','required' );
		$this->form_validation->set_rules('email', 'email','required|valid_email' );
		$this->form_validation->set_rules('phone', 'Số điện thoại','required' );
		$this->form_validation->set_rules('title', 'tiêu đề','required' );
		$this->form_validation->set_rules('content', 'nội dụng','required' );
		if($this->form_validation->run()==TRUE){
			$mydata=array(
				'fullname'=>$_POST['fullname'],
				'email'=>$_POST['email'],
				'phone'=>$_POST['phone'],
				'title'=>$_POST['title'],
				'content'=>$_POST['content'],
				'fulltext'=>$_POST['content'],
				'type'=>'contact',
				'created_at'=> $today
			);
			$this->Mlienhe->contact_insert($mydata);
			echo '<script>alert("Tin nhắn của bạn đã gửi đi thành công !")</script>';
		}
		$this->data['title']="NDN Mobile - Liên hệ";
		$this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
	
	
}

