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
class Content extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('backend/Mnoidung');
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Mdonhang');
		if(!$this->session->userdata('sessionadmin'))
		{
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='content';
	}

	public function index()
	{
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mnoidung->content_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/content');
		$this->data['list']=$this->Mnoidung->content_all('news', $limit, $first);
		$this->data['view']='index';
		$this->data['title']='Danh sách bài viết';
		$this->load->view('backend/layout', $this->data);
	}

	public function sync_news()
	{
		$this->load->library('tech_news_crawler');
		$added = $this->tech_news_crawler->crawl_latest_news(6);
		if($added > 0) {
			$this->session->set_flashdata('success', "Đã quét và tự động cập nhật thêm {$added} bài viết công nghệ mới nhất!");
		} else {
			$this->session->set_flashdata('success', "Tin tức hiện tại đã là mới nhất từ các nguồn báo!");
		}
		redirect('admin/content', 'refresh');
	}

	public function insert()
	{
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('alias');
		$this->form_validation->set_rules('name', 'Tên bài viết', 'required|is_unique[posts.title]');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'title' =>$_POST['name'], 
				'type' => 'news',
				'alias' =>$string=$this->alias->str_alias($_POST['name']),
				'fulltext'=>$_POST['fulltext'], 
				'introtext'=>'',
				'created_at'=>$today,
				'created_by'=>$this->session->userdata('id'),
				'updated_at'=>$today,
				'modified_by'=>$this->session->userdata('id'),
				'trash'=>1,
				'status'=>$_POST['status']
			);
			$config['upload_path']= './public/images/posts/';
            $config['allowed_types']= 'gif|jpg|png';
            $config['max_size']= 2000;
            $this->load->library('upload', $config);
            if ( $this->upload->do_upload('img'))
            {
                $data = $this->upload->data();
                $mydata['img']=$data['file_name'];
            }
            else
            {
                $mydata['img']='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80';
            }

			$this->Mnoidung->content_insert($mydata);
			$this->session->set_flashdata('success', 'Thêm bài viết thành công');
			redirect('admin/content','refresh');
		} 
		else 
		{
			$this->data['view']='insert';
			$this->data['title']='Thêm bài viết mới';
        	$this->load->view('backend/layout', $this->data);
		}
	}

	public function update($id)
	{
		$this->data['row']=$this->Mnoidung->content_detail($id);
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('alias');
		$this->form_validation->set_rules('name', 'Tên bài viết', 'required');
		if ($this->form_validation->run() == TRUE) 
		{
			$mydata= array(
				'title' =>$_POST['name'], 
				'type' => 'news',
				'alias' =>$string=$this->alias->str_alias($_POST['name']),
				'fulltext'=>$_POST['fulltext'], 
				'introtext'=>$_POST['introtext'],
				'updated_at'=>$today,
				'modified_by'=>$this->session->userdata('id'),
				'trash'=>1,
				'status'=>$_POST['status']
			);
			$config['upload_path']= './public/images/posts/';
            $config['allowed_types']= 'gif|jpg|png';
            $config['max_size']= 2000;
            $this->load->library('upload', $config);
            if ( $this->upload->do_upload('img'))
            {
                $data = $this->upload->data();
                if(strlen($data['file_name'])!=0)
                {
                	$mydata['img']=$data['file_name'];
                }
            }

			$this->Mnoidung->content_update($mydata, $id);
			$this->session->set_flashdata('success', 'Cập nhật bài viết thành công');
			redirect('admin/content/','refresh');
		} 
		$this->data['view']='update';
		$this->data['title']='Cập nhật bài viết';
		$this->load->view('backend/layout', $this->data);
	}

	public function status($id)
	{
		$row=$this->Mnoidung->content_detail($id);
		$status=($row['status']==1)?0:1;
		$mydata= array('status' => $status);
		$this->Mnoidung->content_update($mydata, $id);
		$this->session->set_flashdata('success', 'Cập nhật viết thành công');
		redirect('admin/content/','refresh');
	}

	public function trash($id)
	{
		$mydata= array('trash' => 0);
		$this->Mnoidung->content_update($mydata, $id);
		$this->session->set_flashdata('success', 'Xóa bài viết vào thùng rác thành công');
		redirect('admin/content','refresh');
	}

	public function recyclebin()
	{
		$this->load->library('phantrang');
		$limit=10;
		$current=$this->phantrang->PageCurrent();
		$first=$this->phantrang->PageFirst($limit, $current);
		$total=$this->Mnoidung->content_trash_count();
		$this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/content/recyclebin');
		$this->data['list']=$this->Mnoidung->content_trash('news', $limit, $first);
		$this->data['view']='recyclebin';
		$this->data['title']='Thùng rác bài viết';
		$this->load->view('backend/layout', $this->data);
	}

	public function restore($id)
	{
		$this->Mnoidung->content_restore($id);
		$this->session->set_flashdata('success', 'Khôi phục bài viết thành công');
		redirect('admin/content/recyclebin','refresh');
	}
	public function delete($id)
	{
		$this->Mnoidung->content_delete($id);
		$this->session->set_flashdata('success', 'Xóa bài viết thành công');
		redirect('admin/content/recyclebin','refresh');
	}

}
