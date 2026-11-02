<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Mdanhmuc $Mdanhmuc
 * @property Mnguoidung $Mnguoidung
 * @property Msanpham $Msanpham
 * @property Mdonhang $Mdonhang
 * @property Phantrang $phantrang
 * @property CI_Form_validation $form_validation
 * @property Alias $alias
 * @property array $data
 */

class Category extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('backend/Mdanhmuc');
        $this->load->model('backend/Mnguoidung');
        $this->load->model('backend/Msanpham');
        $this->load->model('backend/Mdonhang');
        
        if (!$this->session->userdata('sessionadmin')) {
            redirect('admin/user/login', 'refresh');
        }

        $this->data = [];
        $this->data['user'] = $this->session->userdata('sessionadmin');
        $this->data['com']  = 'category';
    }

    /**
     * Hiển thị danh sách danh mục
     * @return void
     */
    public function index(): void
    {
        $this->load->library('phantrang');
        $this->load->library('alias');

        $search = $this->input->get('search', TRUE);
        $search = trim($search ? $search : '');

        $limit   = 10;
        $current = $this->phantrang->PageCurrent();
        $first   = $this->phantrang->PageFirst($limit, $current);
        $total   = $this->Mdanhmuc->category_count($search);

        $url = 'admin/category';
        if (!empty($search)) {
            $url .= '?search=' . urlencode($search);
        }

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
        $this->data['list']         = $this->Mdanhmuc->category_all($limit, $first, $search);
        $this->data['search']       = $search;
        $this->data['total']        = $total;
        $this->data['view']         = 'index';
        $this->data['title']        = 'Loại sản phẩm';
        $this->load->view('backend/layout', $this->data);
    }

    /**
     * Thêm danh mục mới
     * @return void
     */
    public function insert(): void
    {
        $user_role = $this->session->userdata('sessionadmin');
        if ($user_role['role'] == 2) {
            redirect('admin/E403/index', 'refresh');
        }

        $d = getdate();
        $this->load->library('alias');
        $this->load->library('form_validation');
        $today = $d['year'] . "/" . $d['mon'] . "/" . $d['mday'] . " " . $d['hours'] . ":" . $d['minutes'] . ":" . $d['seconds'];

        $this->form_validation->set_rules('name', 'Loại sản phẩm', 'required|is_unique[categories.name]|max_length[25]');

        if ($this->form_validation->run() == TRUE) {
            $mydata = [
                'name'       => $_POST['name'],
                'link'       => $this->alias->str_alias($_POST['name']),
                'orders'     => $_POST['orders'],
                'status'     => $_POST['status'],
                'created_at' => $today,
                'created_by' => $this->session->userdata('id'),
                'updated_at' => $today,
                'updated_by' => $this->session->userdata('id'),
                'trash'      => 1
            ];

            $id = $_POST['parentid'] ?? 0;
            if ($id == 0) {
                $mydata['level'] = 1;
                $mydata['parentid'] = $id;
            } else {
                $row = $this->Mdanhmuc->category_detail($id);
                $mydata['level'] = (isset($row['level'])) ? $row['level'] + 1 : 1;
                $mydata['parentid'] = $id;
            }
            $row_max = $this->db->select_max('orders')->get('categories')->row();
            $mydata['orders'] = (isset($row_max->orders)) ? $row_max->orders + 1 : 1;
            $this->Mdanhmuc->category_insert($mydata);

            $this->session->set_flashdata('success', 'Thêm danh mục thành công');
            redirect('admin/category', 'refresh');
        } else {
            $this->data['view']  = 'insert';
            $this->data['title'] = 'Thêm danh mục mới';
            $this->load->view('backend/layout', $this->data);
        }
    }

    /**
     * Cập nhật danh mục
     * @param int $id
     * @return void
     */
    public function update(int $id): void
    {
        $user_role = $this->session->userdata('sessionadmin');
        if ($user_role['role'] == 2) {
            redirect('admin/E403/index', 'refresh');
        }

        $this->data['row'] = $this->Mdanhmuc->category_detail($id);
        $d = getdate();
        $today = $d['year'] . "/" . $d['mon'] . "/" . $d['mday'] . " " . $d['hours'] . ":" . $d['minutes'] . ":" . $d['seconds'];
        $this->load->library('alias');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Tên danh mục', 'required|max_length[25]');

        if ($this->form_validation->run() == TRUE) {
            $mydata = [
                'name'       => $_POST['name'],
                'link'       => $this->alias->str_alias($_POST['name']),
                'status'     => $_POST['status'],
                'orders'     => $_POST['orders'],
                'updated_at' => $today,
                'updated_by' => $this->session->userdata('id'),
                'trash'      => 1
            ];

            $idtmp = $_POST['parentid'] ?? 0;
            if ($idtmp == 0) {
                $mydata['level'] = 1;
                $mydata['parentid'] = $idtmp;
            } else {
                $row = $this->Mdanhmuc->category_detail($idtmp);
                $mydata['level'] = (isset($row['level'])) ? $row['level'] + 1 : 1;
                $mydata['parentid'] = $idtmp;
            }

            $this->Mdanhmuc->category_update($mydata, $id);
            $this->session->set_flashdata('success', 'Cập nhật danh mục thành công');
            redirect('admin/category', 'refresh');
        }

        $this->data['view']  = 'update';
        $this->data['title'] = 'Cập nhật danh mục';
        $this->load->view('backend/layout', $this->data);
    }

    /**
     * Thay đổi trạng thái danh mục
     * @param int $id
     * @return void
     */
    public function status(int $id): void
    {
        $row = $this->Mdanhmuc->category_detail($id);
        $status = ($row['status'] == 1) ? 0 : 1;
        $mydata = ['status' => $status];
        $this->Mdanhmuc->category_update($mydata, $id);
        $this->session->set_flashdata('success', 'Cập nhật loại sản phẩm thành công');
        redirect('admin/category', 'refresh');
    }

    /**
     * Chuyển danh mục vào thùng rác
     * @param int $id
     * @return void
     */
    public function trash(int $id): void
    {
        $row = $this->Mdanhmuc->category_detail($id);
        $count_product = $this->Msanpham->product_count_parentid($row['id']);
        $count_category = $this->Mdanhmuc->category_count_parentid($row['id']);

        if ($count_product > 0) {
            $this->session->set_flashdata('error', 'Danh mục này còn sản phẩm bên trong! Hãy xóa sản phẩm trước!');
            redirect('admin/category', 'refresh');
        } elseif ($count_category > 0) {
            $this->session->set_flashdata('error', 'Danh mục này còn danh mục con bên trong! Không thể thực hiện!');
            redirect('admin/category', 'refresh');
        } else {
           $mydata = ['trash' => 0];
            $this->Mdanhmuc->category_update($mydata, $id);

           // 🔥 ĐÁNH LẠI THỨ TỰ
          $this->Mdanhmuc->reorder_sort_order();

          $this->session->set_flashdata('success', 'Xóa loại sản phẩm vào thùng rác thành công');
           redirect('admin/category', 'refresh');

        }
    }

    /**
     * Hiển thị danh mục trong thùng rác
     * @return void
     */
    public function recyclebin(): void
    {
        $this->load->library('phantrang');
        $limit = 10;
        $current = $this->phantrang->PageCurrent();
        $first = $this->phantrang->PageFirst($limit, $current);
        $total = $this->Mdanhmuc->category_trash_count();

        $this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url = 'admin/category/recyclebin');
        $this->data['list'] = $this->Mdanhmuc->category_trash($limit, $first);
        $this->data['view'] = 'recyclebin';
        $this->data['title'] = 'Thùng rác loại sản phẩm';
        $this->load->view('backend/layout', $this->data);
    }

    /**
     * Khôi phục danh mục
     * @param int $id
     * @return void
     */
    public function restore(int $id): void
    {
        $this->Mdanhmuc->category_restore($id);
        $this->session->set_flashdata('success', 'Khôi phục loại sản phẩm thành công');
        redirect('admin/category/recyclebin', 'refresh');
    }

    /**
     * Xóa danh mục vĩnh viễn
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->Mdanhmuc->category_delete($id);
        $this->session->set_flashdata('success', 'Xóa loại sản phẩm thành công');
        redirect('admin/category/recyclebin', 'refresh');
    }
}
