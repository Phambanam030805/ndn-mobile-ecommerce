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
class Contact extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('backend/Mlienhe');
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Mdonhang');
		if(!$this->session->userdata('sessionadmin')){
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='contact';
	}
	public function index(){
		$this->load->library('phantrang');

		$search = $this->input->get('search', TRUE);
		$search = trim($search ? $search : '');

		$limit = 10;
		$current = $this->phantrang->PageCurrent();
		$first = $this->phantrang->PageFirst($limit, $current);
		$total = $this->Mlienhe->contact_count($search);

		$url = 'admin/contact';
		if (!empty($search)) {
			$url .= '?search=' . urlencode($search);
		}

		$this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
		$this->data['list']         = $this->Mlienhe->contact_all($limit, $first, $search);
		$this->data['search']       = $search;
		$this->data['total']        = $total;
		$this->data['view']         = 'index';
		$this->data['title']        = 'Quản lý liên hệ';
		$this->load->view('backend/layout', $this->data);
	}
	public function status($id)
	{
		$row = $this->Mlienhe->contact_detail($id);
		if(!$row) {
			$this->session->set_flashdata('error', 'Thư liên hệ không tồn tại hoặc đã bị xóa!');
			redirect('admin/contact');
			return;
		}

		$status = ($row['status'] == 1) ? 0 : 1;
		$mydata = array('status' => $status);
		$this->Mlienhe->contact_update($mydata, $id);

		$status_label = ($status == 1) ? 'Đã xem' : 'Chưa xem';
		$this->session->set_flashdata('success', 'Đã chuyển trạng thái thư của [' . $row['fullname'] . '] sang "' . $status_label . '" thành công!');

		$referer = $this->input->server('HTTP_REFERER');
		if(!empty($referer) && strpos($referer, 'admin/contact/detail') !== false) {
			redirect('admin/contact/detail/' . $id);
		} else {
			redirect('admin/contact');
		}
	}

	public function detail($id)
    {
        $this->data['row'] = $this->Mlienhe->contact_detail($id);
        if(!$this->data['row']) {
            $this->session->set_flashdata('error', 'Thư liên hệ không tồn tại hoặc đã bị xóa!');
            redirect('admin/contact');
            return;
        }

        $this->data['view'] = 'detail';
		$this->data['title'] = 'Chi tiết liên hệ - ' . $this->data['row']['fullname'];
		$this->load->view('backend/layout', $this->data);
    }

	/**
	 * Gửi email phản hồi cho khách hàng từ tài khoản admin phambanam385@gmail.com
	 */
	public function send_reply($id)
	{
		$row = $this->Mlienhe->contact_detail($id);
		if(!$row) {
			$this->session->set_flashdata('error', 'Thư liên hệ không tồn tại hoặc đã bị xóa!');
			redirect('admin/contact');
			return;
		}

		$to_email = $this->input->post('to_email', TRUE);
		$subject  = $this->input->post('subject', TRUE);
		$content  = $this->input->post('content', TRUE);

		if(empty($to_email) || empty($subject) || empty($content)) {
			$this->session->set_flashdata('error', 'Vui lòng nhập đầy đủ tiêu đề và nội dung phản hồi!');
			redirect('admin/contact/detail/' . $id);
			return;
		}

		// Lấy cấu hình SMTP
		$this->load->model('backend/Mcauhinh');
		$config_db = $this->Mcauhinh->configuration_detail();

		$smtp_user  = !empty($config_db['mail_smtp']) ? $config_db['mail_smtp'] : 'phambanam385@gmail.com';
		$smtp_pass  = !empty($config_db['mail_smtp_password']) ? str_replace(' ', '', $config_db['mail_smtp_password']) : 'ykmwyaxeyfajxlyk';
		$site_title = !empty($config_db['title']) ? $config_db['title'] : 'NDN Mobile';

		$this->load->library('email');
		$this->email->clear();

		$email_config = [
			'protocol'    => 'smtp',
			'smtp_host'   => 'smtp.gmail.com',
			'smtp_port'   => 465,
			'smtp_crypto' => 'ssl',
			'smtp_timeout'=> 25,
			'smtp_user'   => $smtp_user,
			'smtp_pass'   => $smtp_pass,
			'charset'     => 'utf-8',
			'newline'     => "\r\n",
			'crlf'        => "\r\n",
			'mailtype'    => 'html',
		];
		$this->email->initialize($email_config);
		$this->email->from($smtp_user, $site_title);
		$this->email->to($to_email);
		$this->email->subject($subject);

		$email_html = '
		<div style="font-family: Arial, Helvetica, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #ffffff;">
			<div style="background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%); padding: 20px 28px; text-align: center;">
				<h2 style="color: #ffffff; margin: 0; font-size: 22px; font-weight: 700;">' . htmlspecialchars($site_title) . '</h2>
				<p style="color: rgba(255,255,255,0.88); margin: 4px 0 0; font-size: 13px;">Phản hồi hỗ trợ khách hàng</p>
			</div>
			<div style="padding: 26px 30px; color: #1e293b; font-size: 14.5px; line-height: 1.7;">
				<p style="margin-top: 0;">Xin chào <strong>' . htmlspecialchars($row['fullname']) . '</strong>,</p>
				<p style="color: #475569;">NDN Mobile đã nhận được yêu cầu liên hệ của bạn về chủ đề: <em>"' . htmlspecialchars($row['title']) . '"</em>.</p>
				<div style="background: #f8fafc; border-left: 4px solid #d70018; padding: 14px 18px; margin: 18px 0; border-radius: 6px; color: #0f172a; white-space: pre-wrap;">' . htmlspecialchars($content) . '</div>
				<p style="color: #64748b; font-size: 13.5px;">Nếu cần thêm thông tin hỗ trợ, bạn có thể trả lời trực tiếp email này hoặc liên hệ hotline chăm sóc khách hàng để được phục vụ nhanh nhất.</p>
				<hr style="border: none; border-top: 1px dashed #e2e8f0; margin: 22px 0;">
				<p style="margin-bottom: 0; font-size: 13px; color: #64748b;">
					<strong>Ban Quản trị & CSKH NDN Mobile</strong><br>
					Người gửi: ' . htmlspecialchars($smtp_user) . '<br>
					Website: <a href="' . base_url() . '" style="color: #d70018; text-decoration: none;">NDN Mobile</a>
				</p>
			</div>
		</div>';

		$this->email->message($email_html);

		if($this->email->send()) {
			// Lưu lịch sử phản hồi và đánh dấu đã xem / đã xử lý
			$reply_data = [
				'status'     => 1,
				'introtext'  => $content, // Lưu nội dung tin nhắn đã phản hồi
				'updated_at' => date('Y-m-d H:i:s'), // Thời gian gửi phản hồi
				'updated_by' => $smtp_user, // Người gửi phản hồi (phambanam385@gmail.com)
			];
			$this->Mlienhe->contact_update($reply_data, $id);
			$this->session->set_flashdata('success', 'Đã gửi email phản hồi thành công từ ' . $smtp_user . ' đến ' . $to_email . '!');
		} else {
			log_message('error', 'Lỗi gửi mail phản hồi: ' . $this->email->print_debugger(['headers']));
			$this->session->set_flashdata('error', 'Không thể gửi email: Vui lòng kiểm tra lại kết nối mạng hoặc thử lại sau!');
		}

		redirect('admin/contact/detail/' . $id);
	}
    public function delete($id)
	{
		$this->Mlienhe->contact_delete($id);
		$this->session->set_flashdata('success', 'Xóa thành công');
		redirect('admin/contact/recyclebin','refresh');
	}
	public function trash($id)
	{
		$mydata= array('trash' => 0);
		$this->Mlienhe->contact_update($mydata,$id);
		$this->session->set_flashdata('success', 'Xóa vào thùng rác thành công');
		redirect('admin/contact','refresh');
	}
	public function recyclebin()
	{
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mlienhe->contact_trash_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/contact/recyclebin');
		$this->data['list']=$this->Mlienhe->contact_trash($limit, $first);
		$this->data['view']='recyclebin';
		$this->data['title']='Thùng rác liên hệ';
		$this->load->view('backend/layout', $this->data);
	}
	public function restore($id)
	{
		$this->Mlienhe->contact_restore($id);
		$this->session->set_flashdata('success', 'Khôi phục thành công');
		redirect('admin/contact/recyclebin','refresh');
	}


}