<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reviews extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('backend/Mreview');
        $this->load->model('backend/Msanpham');
        $this->load->model('backend/Mdonhang');
        if(!$this->session->userdata('sessionadmin'))
        {
            redirect('admin/user/login','refresh');
        }
        $this->data['user']=$this->session->userdata('sessionadmin');
        $this->data['com']='reviews';
    }

    public function index()
    {
        $this->load->library('phantrang');
        $limit=10;
        $current=$this->phantrang->PageCurrent();
        $first=$this->phantrang->PageFirst($limit, $current);
        $total=$this->Mreview->review_count();
        $this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/reviews');
        $this->data['list']=$this->Mreview->review_all($limit, $first);
        $this->data['view']='index';
        $this->data['title']='Quản lý Đánh giá & Bình luận';
        $this->load->view('backend/layout', $this->data);
    }

    public function status($id)
    {
        $row=$this->Mreview->review_detail($id);
        $status=($row['status']==1)?0:1;
        $mydata= array('status' => $status);
        $this->Mreview->review_update($mydata, $id);
        $this->session->set_flashdata('success', 'Cập nhật trạng thái đánh giá thành công');
        redirect('admin/reviews','refresh');
    }

    public function trash($id)
    {
        $mydata= array('trash' => 0);
        $this->Mreview->review_update($mydata, $id);
        $this->session->set_flashdata('success', 'Xóa đánh giá vào thùng rác thành công');
        redirect('admin/reviews','refresh');
    }

    public function recyclebin()
    {
        $this->load->library('phantrang');
        $limit=10;
        $current=$this->phantrang->PageCurrent();
        $first=$this->phantrang->PageFirst($limit, $current);
        $total=$this->Mreview->review_trash_count();
        $this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/reviews/recyclebin');
        $this->data['list']=$this->Mreview->review_trash($limit, $first);
        $this->data['view']='recyclebin';
        $this->data['title']='Thùng rác đánh giá';
        $this->load->view('backend/layout', $this->data);
    }

    public function restore($id)
    {
        $mydata= array('trash' => 1);
        $this->Mreview->review_update($mydata, $id);
        $this->session->set_flashdata('success', 'Khôi phục đánh giá thành công');
        redirect('admin/reviews/recyclebin','refresh');
    }

    public function delete($id)
    {
        $this->Mreview->review_delete($id);
        $this->session->set_flashdata('success', 'Xóa vĩnh viễn đánh giá thành công');
        redirect('admin/reviews/recyclebin','refresh');
    }
}