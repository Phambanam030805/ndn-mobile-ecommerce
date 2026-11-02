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
		$row=$this->Mlienhe->contact_detail($id);

		$status=($row['status']==0)?1:0;
		$mydata= array('status' => $status);
		$this->Mlienhe->contact_update($mydata, $id);
		$this->session->set_flashdata('success', 'Cập nhật trạng thái thành công');
		redirect('admin/contact/','refresh');
	}
	public function detail($id)
    {
        $this->data['row'] = $this->Mlienhe->contact_detail($id);
        $this->data['view'] = 'detail';
		$this->data['title'] = 'Chi tiết liên hệ';
		$this->load->view('backend/layout', $this->data);
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