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
class Useradmin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('backend/Mnguoidung');
		$this->load->model('backend/Mdonhang');
		if(!$this->session->userdata('sessionadmin'))
		{
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='useradmin';
	}

	public function index(){
		$user_role=$this->session->userdata('sessionadmin');
		if($user_role['role']==2){
			redirect('admin/E403/index','refresh');
		}
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mnguoidung->user_count([1, 2]);
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/useradmin');
		$this->data['list']=$this->Mnguoidung->user_all([1, 2], $limit, $first);
		$this->data['view']='index';
		$this->data['title']='Danh sách tài khoản';
		$this->load->view('backend/layout', $this->data);
	}

	public function insert(){
		$user_role=$this->session->userdata('sessionadmin');
		if($user_role['role']==2){
			redirect('admin/E403/index','refresh');
		}
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$this->load->library('form_validation');
		$this->load->library('alias');
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'required');
		$this->form_validation->set_rules('phone', 'Số điện thoại', 'required|is_unique[users.phone]');
		$this->form_validation->set_rules('email', 'Địa chỉ email', 'required|is_unique[users.email]');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|is_unique[users.username]');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[5]|max_length[32]');
		if ($this->form_validation->run() == TRUE){
			$mydata= array(
				'fullname' =>$_POST['fullname'], 
				'phone' =>$_POST['phone'], 
				'address' =>$_POST['address'], 
				'email' =>$_POST['email'], 
				'username' =>$_POST['username'], 
				'password' =>sha1($_POST['password']), 
				'role' =>$_POST['role'], 
				'status' =>$_POST['status'],
				'created_at' =>$today,
				'trash'=>1
			);
			$config['upload_path']          = './public/images/admin/';
			$config['encrypt_name'] = TRUE;
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2000;
            $this->load->library('upload', $config);
            if ( $this->upload->do_upload('img')){
                $data = $this->upload->data();
                $mydata['img']=$data['file_name'];
            }else{
                $mydata['img']='default.png';
            }
			$this->Mnguoidung->user_insert($mydata);
			$this->session->set_flashdata('success', 'Thêm tài khoản thành công');
			redirect('admin/useradmin','refresh');
		} 
		else{
			$this->data['view']='insert';
			$this->data['title']='Thêm mới tài khoản';
			$this->load->view('backend/layout', $this->data);
		}
	}

	public function update($id){
		$user_role=$this->session->userdata('sessionadmin');
		if($user_role['role']==2){
			redirect('admin/E403/index','refresh');
		}
		$row=$this->Mnguoidung->user_detail($id);
		$this->data['row']=$row;
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$this->load->library('form_validation');
		$this->load->library('alias');
		$this->form_validation->set_rules('fullname', 'Họ và tên', 'required');
		$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
		$this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[5]|max_length[32]');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'fullname' =>$_POST['fullname'], 
				'address' =>$_POST['address'], 
				'password' =>sha1($_POST['password']), 
				'gender'=>$_POST['gender']
			);
         	$config = array();
	         $config['upload_path']   = './public/images/admin/';
	         $config['allowed_types'] = 'jpg|png';
	         $config['encrypt_name'] = TRUE;
	         $config['max_size']      = '500';
	         $config['max_width']     = '1028';
	         $config['max_height']    = '1028';
	         $this->load->library('upload', $config);
	         if($this->upload->do_upload('image')){
	             $data = $this->upload->data();
	             $mydata['img']=$data['file_name'];
	         }
			$this->Mnguoidung->user_update($mydata, $id);
			$this->session->set_flashdata('success', 'Cập nhật tài khoản thành công');
			redirect('admin/useradmin/','refresh');
		} 
		$this->data['view']='update';
		$this->data['title']='Cập nhật tài khoản';
		$this->load->view('backend/layout', $this->data);
	}

	public function recyclebin()
	{
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mnguoidung->user_trash_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/useradmin/recyclebin');
		$this->data['list']=$this->Mnguoidung->user_trash($limit, $first);
		$this->data['view']='recyclebin';
		$this->data['title']='Thùng rác tài khoản';
		$this->load->view('backend/layout', $this->data);
	}

	public function trash($id)
	{
		$row=$this->data['user'];
		if($row['role']==2){
			$this->session->set_flashdata('error', 'Không có quyền thao tác');
			redirect('admin/useradmin','refresh');
		}else{
			$mydata= array('trash' => 0);
			$this->Mnguoidung->user_update($mydata, $id);
			$this->session->set_flashdata('success', 'Xóa tài khoản vào thùng rác thành công');
			redirect('admin/useradmin','refresh');
		}
	}

	public function status($id)
	{
		$row=$this->Mnguoidung->user_detail($id);
		$user=$this->data['user'];
		if($user['role']==2){
			$this->session->set_flashdata('error', 'Không có quyền thao tác');
			redirect('admin/useradmin','refresh');
		}else{
			if($id!=$user['id']){
				$status=($row['status']==1)?0:1;
				$mydata= array('status' => $status);
				$this->Mnguoidung->user_update($mydata, $id);
				$this->session->set_flashdata('success', 'Cập nhật tài khoản thành công');
				redirect('admin/useradmin','refresh');
			}else{
				$this->session->set_flashdata('error', 'Không thể thao tác với chính mình');
				redirect('admin/useradmin','refresh');
			}
		}
	}

	public function restore($id){
		$row=$this->data['user'];
		if($row['role']==2){
			$this->session->set_flashdata('error', 'Không có quyền thao tác');
			redirect('admin/useradmin','refresh');
		}else{
			$this->Mnguoidung->user_restore($id);
			$this->session->set_flashdata('success', 'Khôi phục tài khoản thành công');
			redirect('admin/useradmin/recyclebin','refresh');
		}
	}

	public function delete($id){
		$row=$this->data['user'];
		if($row['role']==2){
			$this->session->set_flashdata('error', 'Không có quyền thao tác');
			redirect('admin/useradmin','refresh');
		}else{
			$this->Mnguoidung->user_delete($id);
			$this->session->set_flashdata('success', 'Xóa tài khoản thành công');
			redirect('admin/useradmin/recyclebin','refresh');
		}
	}

	function check_password(){
        $password = $this->input->post('password');
        $row=$this->data['row'];
        if(sha1($password)!=$row['password']){
            $this->form_validation->set_message(__FUNCTION__, 'Mật khẩu không chính xác');
            return FALSE;
        }
        return TRUE;
    }

}
