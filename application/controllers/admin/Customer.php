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
class Customer extends CI_Controller {

    protected $data = array(); 

    public function __construct()
    {
        parent::__construct();
        // Nạp các model cần thiết
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Mdonhang');
        $this->load->model('frontend/Mkhachhang');

        // Kiểm tra đăng nhập admin
        if(!$this->session->userdata('sessionadmin'))
        {
            redirect('admin/user/login', 'refresh');
        }

        // Gán thông tin cơ bản
        $this->data['user'] = $this->session->userdata('sessionadmin');
        $this->data['com']  = 'customer';
    }

    public function index()
    {
        $this->load->library('phantrang');

        $search = $this->input->get('search', TRUE);
        $search = trim($search ? $search : '');

        $limit   = 10;
        $current = $this->phantrang->PageCurrent();
        $first   = $this->phantrang->PageFirst($limit, $current);
        $total   = $this->Mnguoidung->user_count([3], $search);

        $url = 'admin/customer';
        if (!empty($search)) {
            $url .= '?search=' . urlencode($search);
        }

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
        $this->data['list']         = $this->Mnguoidung->user_all([3], $limit, $first, $search);
        $this->data['search']       = $search;
        $this->data['total']        = $total;
        $this->data['view']         = 'index';
        $this->data['title']        = 'Danh sách khách hàng';
        $this->load->view('backend/layout', $this->data);
    }

    public function update($id)
    {
        $this->data['row']  = $this->Mnguoidung->user_detail($id);
        if(!$this->data['row'])
        {
            $this->session->set_flashdata('error', 'Khách hàng không tồn tại!');
            redirect('admin/customer');
        }

        if($this->input->post())
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fullname', 'Họ và tên', 'required|trim');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if($this->form_validation->run() == TRUE)
            {
                $mydata = array(
                    'fullname' => $this->input->post('fullname', TRUE),
                    'phone'    => $this->input->post('phone', TRUE),
                    'email'    => $this->input->post('email', TRUE),
                    'status'   => (int)$this->input->post('status', TRUE),
                );
                $this->Mnguoidung->user_update($mydata, $id);
                $this->session->set_flashdata('success', 'Cập nhật thông tin khách hàng thành công!');
                redirect('admin/customer', 'refresh');
            }
        }

        $this->data['view'] = 'update';
        $this->data['title'] = 'Cập nhật khách hàng';
        $this->load->view('backend/layout', $this->data);
    }

    public function recyclebin()
    {
        $this->load->library('phantrang');
        $limit   = 10;
        $current = $this->phantrang->PageCurrent();
        $first   = $this->phantrang->PageFirst($limit, $current);
        $total   = $this->Mnguoidung->user_trash_count([3]);

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url='admin/customer/recyclebin');
        $this->data['list'] = $this->Mnguoidung->user_trash([3], $limit, $first);
        $this->data['view'] = 'recyclebin';
        $this->data['title'] = 'Thùng rác khách hàng';
        $this->load->view('backend/layout', $this->data);
    }

    public function trash($id)
    {
        $this->db->where('customer_id', $id);
        $count = $this->db->count_all_results('orders');

        if($count > 0)
        {
            $this->session->set_flashdata('error', 'Khách hàng đã đặt hàng, không thể xóa !');
            redirect('admin/customer', 'refresh');
        }
        else
        {
            $mydata = array('trash' => 0);
            $this->Mnguoidung->user_update($mydata, $id);
            $this->session->set_flashdata('success', 'Xóa khách hàng vào thùng rác thành công');
            redirect('admin/customer', 'refresh');
        }
    }

    public function restore($id)
    {
        $this->Mnguoidung->user_restore($id);
        $this->session->set_flashdata('success', 'Khôi phục khách hàng thành công');
        redirect('admin/customer/recyclebin', 'refresh');
    }

    public function delete($id)
    {
        $this->Mnguoidung->user_delete($id);
        $this->session->set_flashdata('success', 'Xóa khách hàng thành công');
        redirect('admin/customer/recyclebin', 'refresh');
    }
}
