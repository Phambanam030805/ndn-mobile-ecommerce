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
class Configuration extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend/Mcauhinh');
		$this->load->model('backend/Mnguoidung');
		$this->load->model('backend/Mdonhang');

		if(!$this->session->userdata('sessionadmin'))
		{
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='configuration';
	}
	
	public function update($id=1)
	{
		$this->data['row']=$this->Mcauhinh->configuration_detail($id);

		$this->load->library('form_validation');
		$this->load->library('session');	
		$this->form_validation->set_rules('mail_smtp', 'Địa chỉ email ', 'required');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'mail_smtp' => $this->input->post('mail_smtp', TRUE), 
				'mail_smtp_password'=> $this->input->post('mail_smtp_password', TRUE),
				'mail_noreply'=> $this->input->post('mail_noreply', TRUE),
				'priceShip'=> (int)$this->input->post('priceShip'),
				'title'=> $this->input->post('title', TRUE), 
				'description'=> $this->input->post('description', TRUE),
				'phone_hotline'=> $this->input->post('phone_hotline', TRUE),
			);
			
			$this->Mcauhinh->configuration_update($mydata,$id);

			// Tự động xóa sạch Cache website để phản ánh cấu hình mới ngay lập tức
			$this->load->driver('cache', ['adapter' => 'file', 'backup' => 'dummy']);
			$this->cache->delete('ndn_site_configuration');

			$this->session->set_flashdata('success', 'Cập nhật Cấu hình thành công');
			redirect('admin/configuration/update','refresh');
		} 
		$this->data['view']='update';
		$this->data['title']='Cấu hình';
		$this->load->view('backend/layout', $this->data);
	}
	

}
