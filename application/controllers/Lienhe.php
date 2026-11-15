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
		$today = date('Y-m-d H:i:s');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fullname', 'Họ và tên','required' );
		$this->form_validation->set_rules('email', 'email','required|valid_email' );
		$this->form_validation->set_rules('phone', 'Số điện thoại','required' );
		$this->form_validation->set_rules('title', 'tiêu đề','required' );
		$this->form_validation->set_rules('content', 'nội dụng','required' );
		if($this->form_validation->run()==TRUE){
			$mydata=array(
				'fullname'=>$this->input->post('fullname', TRUE),
				'email'=>$this->input->post('email', TRUE),
				'phone'=>$this->input->post('phone', TRUE),
				'title'=>$this->input->post('title', TRUE),
				'content'=>$this->input->post('content', TRUE),
				'fulltext'=>$this->input->post('content', TRUE),
				'type'=>'contact',
				'status'=> 0, // Bắt buộc: 0 = Chưa xem (Thư liên hệ mới gửi)
				'trash' => 1, // 1 = Hoạt động (không nằm trong thùng rác)
				'created_at'=> $today
			);
			$this->Mlienhe->contact_insert($mydata);
			echo '<script>alert("Tin nhắn của bạn đã gửi đi thành công !")</script>';
		}
		$this->data['title']="NDN Mobile - Liên hệ";
		$this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
	
	/**
	 * Gửi tin nhắn liên hệ nhanh qua AJAX từ popup modal tiện ích
	 */
	public function ajax_send()
	{
		$this->output->set_content_type('application/json');

		$fullname = trim($this->input->post('fullname', TRUE));
		$email    = trim($this->input->post('email', TRUE));
		$phone    = trim($this->input->post('phone', TRUE));
		$title    = trim($this->input->post('title', TRUE));
		$content  = trim($this->input->post('content', TRUE));

		if(empty($fullname) || empty($email) || empty($phone) || empty($content)) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Vui lòng điền đầy đủ họ tên, email, số điện thoại và nội dung tin nhắn!'
			]);
			return;
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Địa chỉ email không đúng định dạng hợp lệ!'
			]);
			return;
		}

		if(empty($title)) {
			$title = 'Yêu cầu tư vấn từ khách hàng: ' . $fullname;
		}

		$mydata = array(
			'fullname'   => $fullname,
			'email'      => $email,
			'phone'      => $phone,
			'title'      => $title,
			'content'    => $content,
			'fulltext'   => $content,
			'type'       => 'contact',
			'status'     => 0, // 0 = Chưa xem (Mới nhận)
			'trash'      => 1,
			'created_at' => date('Y-m-d H:i:s')
		);

		$this->Mlienhe->contact_insert($mydata);

		echo json_encode([
			'status'  => 'success',
			'message' => 'Tin nhắn liên hệ của bạn đã được gửi thành công! Ban Quản trị NDN Mobile sẽ phản hồi sớm nhất qua email hoặc điện thoại.'
		]);
	}
}

