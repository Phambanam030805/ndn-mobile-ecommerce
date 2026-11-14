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
class Product extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('backend/Msanpham');
		$this->load->model('backend/Mdanhmuc');
		$this->load->model('backend/Mnguoidung');
		$this->load->model('backend/Mnhacungcap');
		$this->load->model('backend/Mchitietdonhang');
    $this->load->model('backend/Mdonhang');
		if(!$this->session->userdata('sessionadmin')){
			redirect('admin/user/login','refresh');
		}
		$this->data['user']=$this->session->userdata('sessionadmin');
		$this->data['com']='product';
	}

	public function index(){
		$this->load->library('phantrang');
		$this->load->library('session');

		$search = $this->input->get('search', TRUE);
		$catid = $this->input->get('catid', TRUE);
		$search = trim($search ? $search : '');
		$catid = trim($catid ? $catid : '');

		$limit = 10;
		$current = $this->phantrang->PageCurrent();
		$first = $this->phantrang->PageFirst($limit, $current);

		$total = $this->Msanpham->product_sanpham_count($search, $catid);

		$url = 'admin/product';
		$queryString = array();
		if (!empty($search)) $queryString['search'] = $search;
		if (!empty($catid)) $queryString['catid'] = $catid;
		if (!empty($queryString)) {
			$url .= '?' . http_build_query($queryString);
		}

		$this->data['strphantrang'] = $this->phantrang->PagePer($total, $current, $limit, $url);
		$this->data['list'] = $this->Msanpham->product_sanpham($limit, $first, $search, $catid);
		$this->data['categories'] = $this->Mdanhmuc->category_brand_list();
		$this->data['search'] = $search;
		$this->data['catid'] = $catid;
		$this->data['total'] = $total;
		$this->data['view'] = 'index';
		$this->data['title'] = 'Danh mục sản phẩm';
		$this->load->view('backend/layout', $this->data);
	}

	public function insert(){
    $user_role=$this->session->userdata('sessionadmin');
    if($user_role['role']==2){
      redirect('admin/E403/index','refresh');
    }
    $user_role=$this->session->userdata('sessionadmin');
    if($user_role['role']==2){
      redirect('admin/E403/index','refresh');
    }
		$d=getdate();
		$today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('alias');
		$this->form_validation->set_rules('name', 'Tên sản phẩm', 'required|is_unique[products.name]');
		$this->form_validation->set_rules('catid', 'Loại sản phẩm', 'required');
		$this->form_validation->set_rules('producer', 'Nhà cung cấp', 'required');
		$this->form_validation->set_rules('price_buy','Giá bán','required|callback_check');
		if ($this->form_validation->run() == TRUE){
			$mydata= array(
				'catid'=>$_POST['catid'],
				'producer'=>$_POST['producer'],
				'producer_id'=>$_POST['producer'],
				'name' =>$_POST['name'], 
				'alias' =>$string=$this->alias->str_alias($_POST['name']),
				'detail'=>$_POST['detail'], 
				'sortDesc'=>$_POST['sortDesc'], 
				'number'=>$_POST['number'],
				'sale'=>$_POST['sale_of'],
				'price'=>$_POST['price_root'],
				'price_sale'=>$_POST['price_buy'],
				'created_at'=>$today,
				'created_by'=>$this->session->userdata('id'),
				'updated_at'=>$today,
				'modified_by'=>$this->session->userdata('id'),
				'trash'=>1,
				'status'=>$_POST['status']
			);
			// Kiểm tra bắt buộc phải chọn ảnh đại diện cho sản phẩm mới
			if (empty($_FILES['img']['name'])) {
				$this->session->set_flashdata('error', 'Vui lòng chọn ảnh đại diện cho sản phẩm!');
				$this->data['listcat'] = $this->Mdanhmuc->category_brand_list();
				$this->data['listproducer'] = $this->Mnhacungcap->producer_list();
				$this->data['view'] = 'insert';
				$this->data['title'] = 'Thêm sản phẩm mới';
				$this->load->view('backend/layout', $this->data);
				return;
			}

			// Cấu hình tải ảnh lên hệ thống
			$config = array(
				'upload_path'   => './public/images/products/',
				'allowed_types' => 'jpg|jpeg|png|gif|webp',
				'max_size'      => '10240', // Cho phép tới 10MB
				'encrypt_name'  => TRUE
			);
			$this->load->library('upload', $config);

			// 1. Upload ảnh đại diện chính (img)
			$this->upload->initialize($config);
			if ($this->upload->do_upload('img')) {
				$data = $this->upload->data();
				$mydata['avatar'] = $data['file_name'];
			} else {
				$this->session->set_flashdata('error', 'Lỗi tải ảnh đại diện: ' . strip_tags($this->upload->display_errors()));
				$this->data['listcat'] = $this->Mdanhmuc->category_brand_list();
				$this->data['listproducer'] = $this->Mnhacungcap->producer_list();
				$this->data['view'] = 'insert';
				$this->data['title'] = 'Thêm sản phẩm mới';
				$this->load->view('backend/layout', $this->data);
				return;
			}

			// 2. Upload thư viện ảnh chi tiết (image_list)
			$img = '';
			if (isset($_FILES['image_list']) && !empty($_FILES['image_list']['name'][0])) {
				$file  = $_FILES['image_list'];
				$count = count($file['name']);
				for ($i = 0; $i < $count; $i++) {
					if (empty($file['name'][$i])) continue;
					$_FILES['userfile']['name']     = $file['name'][$i];
					$_FILES['userfile']['type']     = $file['type'][$i];
					$_FILES['userfile']['tmp_name'] = $file['tmp_name'][$i];
					$_FILES['userfile']['error']    = $file['error'][$i];
					$_FILES['userfile']['size']     = $file['size'][$i];

					$this->upload->initialize($config);
					if ($this->upload->do_upload('userfile')) {
						$data = $this->upload->data();
						$img .= $data['file_name'] . '#';
					}
				}
				$img = rtrim($img, '#');
			}
			$mydata['img'] = $img;

			$this->Msanpham->product_insert($mydata);
              $this->session->set_flashdata('success', 'Thêm sản phẩm thành công');
              redirect('admin/product','refresh');
            }else{
             $this->data['listcat'] = $this->Mdanhmuc->category_brand_list();
             $this->data['listproducer'] = $this->Mnhacungcap->producer_list();
             $this->data['view']='insert';
             $this->data['title']='Thêm sản phẩm mới';
             $this->load->view('backend/layout', $this->data);
           }
         }

         function check(){
           $giaban= $this->input->post('price_buy');
           $giagoc= $this->input->post('price_root');
           if($giaban>$giagoc){
            $this->form_validation->set_message(__FUNCTION__,'Bạn phải nhập giá bán nhỏ hơn hoặc bằng giá gốc');
            return FALSE;
          }else{
            return true;
          }
        }

        public function update($id){
          $user_role=$this->session->userdata('sessionadmin');
    if($user_role['role']==2){
      redirect('admin/E403/index','refresh');
    }
         $this->data['row']=$this->Msanpham->product_detail($id);
         $d=getdate();
         $today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
         $this->load->library('form_validation');
         $this->load->library('session');
         $this->load->library('alias');
         $this->form_validation->set_rules('name', 'Tên sản phẩm', 'required');
         $this->form_validation->set_rules('catid', 'Loại sản phẩm', 'required');
         $this->form_validation->set_rules('producer', 'Nhà cung cấp', 'required');
         $this->form_validation->set_rules('price_buy','Giá bán','required|callback_check');
         if ($this->form_validation->run() == TRUE){
          $mydata= array(
           'catid'=>$_POST['catid'],
           'producer'=>$_POST['producer'],
           'producer_id'=>$_POST['producer'],
           'name' =>$_POST['name'], 
           'alias' =>$string=$this->alias->str_alias($_POST['name']),
           'detail'=>$_POST['detail'], 
           'sortDesc'=>$_POST['sortDesc'],
           'sale'=>$_POST['sale_of'],
           'price'=>$_POST['price_root'],
           'price_sale'=>$_POST['price_buy'],
           'updated_at'=>$today,
           'modified_by'=>$this->session->userdata('id'),
           'status'=>$_POST['status']
         );
         
         // Thêm logic xử lý upload ảnh khi cập nhật
         $config = array(
             'upload_path'   => './public/images/products/',
             'allowed_types' => 'jpg|jpeg|png|gif|webp',
             'max_size'      => '10240', // 10MB
             'encrypt_name'  => TRUE
         );
         $this->load->library('upload', $config);
         $this->upload->initialize($config);

         // Upload ảnh đại diện mới nếu có
         if (!empty($_FILES['img']['name']) && $this->upload->do_upload('img')){
             $data = $this->upload->data();
             $mydata['avatar'] = $data['file_name'];
             // Xóa ảnh cũ để tiết kiệm bộ nhớ (tùy chọn)
             $row_old = $this->Msanpham->product_detail($id);
             if(!empty($row_old['avatar']) && $row_old['avatar'] != 'default.png' && file_exists('./public/images/products/'.$row_old['avatar'])){
                 @unlink('./public/images/products/'.$row_old['avatar']);
             }
         }

         // Upload danh sách ảnh chi tiết mới nếu có
         if (isset($_FILES['image_list']) && !empty($_FILES['image_list']['name'][0])) {
             $file = $_FILES['image_list'];
             $count = count($file['name']);
             $img_list = '';
             for($i=0; $i<$count; $i++){
                 $_FILES['userfile']['name']     = $file['name'][$i];
                 $_FILES['userfile']['type']     = $file['type'][$i];
                 $_FILES['userfile']['tmp_name'] = $file['tmp_name'][$i];
                 $_FILES['userfile']['error']    = $file['error'][$i];
                 $_FILES['userfile']['size']     = $file['size'][$i];
                 if($this->upload->do_upload('userfile')){
                     $data = $this->upload->data();
                     $img_list .= $data['file_name'].'#';
                 }
             }
             if($img_list != '') {
                 $mydata['img'] = rtrim($img_list, '#');
             }
         }

              $this->Msanpham->product_update($mydata, $id);
              $this->session->set_flashdata('success', 'Cập nhật sản phẩm thành công');
              redirect('admin/product','refresh');
            } 
            $this->data['listcat'] = $this->Mdanhmuc->category_brand_list();
            $this->data['listproducer'] = $this->Mnhacungcap->producer_list();
            $this->data['view']='update';
            $this->data['title']='Cập nhật sản phẩm';
            $this->load->view('backend/layout', $this->data);
          }

          public function status($id){
           $row=$this->Msanpham->product_detail($id);
           $status=($row['status']==1)?0:1;
           $mydata= array('status' => $status,'modified_by'=>$this->session->userdata('id'),);
           $this->Msanpham->product_update($mydata, $id);
           $this->session->set_flashdata('success', 'Cập nhật sản phẩm thành công');
           redirect('admin/product/','refresh');
         }

         public function recyclebin(){
           $this->load->library('phantrang');
           $limit=10;
           $current=$this->phantrang->PageCurrent();
           $first=$this->phantrang->PageFirst($limit, $current);
           $total=$this->Msanpham->product_trash_count();
           $this->data['strphantrang']=$this->phantrang->PagePer($total, $current, $limit, $url='admin/product/recyclebin');
           $this->data['list']=$this->Msanpham->product_trash($limit, $first);
           $this->data['view']='recyclebin';
           $this->data['title']='Thùng rác sản phẩm';
           $this->load->view('backend/layout', $this->data);
         }

         public function trash($id){
            // Kiểm tra xem sản phẩm đã có trong đơn hàng nào chưa (bảng order_items)
            $this->db->where('product_id', $id);
            $count = $this->db->count_all_results('order_items');

           if($count > 0){
            $this->session->set_flashdata('error', 'Đã có khách hàng đặt mua, không thể xóa !');
            redirect('admin/product','refresh');
          }else{
            $mydata= array('trash' => 0,'modified_by'=>$this->session->userdata('id'),);
            $this->Msanpham->product_update($mydata, $id);
            $this->session->set_flashdata('success', 'Xóa sản phẩm vào thùng rác thành công');
            redirect('admin/product','refresh');
          }
        }

        public function restore($id){
         $this->Msanpham->product_restore($id);
         $this->session->set_flashdata('success', 'Khôi phục sản phẩm thành công');
         redirect('admin/product/recyclebin','refresh');
       }

       public function delete($id){
         $this->load->helper('file');
         $row = $this->Msanpham->product_detail($id);
         // Xóa file ảnh đại diện nếu tồn tại
         if(!empty($row['avatar'])){
             @unlink("public/images/products/" . $row['avatar']);
         }
         $this->Msanpham->product_delete($id);
         $this->session->set_flashdata('success', 'Xóa sản phẩm thành công');
         redirect('admin/product/recyclebin','refresh');
       }

       public function import($id){
         $row=$this->Msanpham->product_detail($id);
         $d=getdate();
         $today=$d['year']."/".$d['mon']."/".$d['mday']." ".$d['hours'].":".$d['minutes'].":".$d['seconds'];
         $this->load->library('form_validation');
         $this->load->library('session');
         $this->load->library('alias');
         $this->form_validation->set_rules('number', 'Số lượng', 'required');
         if ($this->form_validation->run() == TRUE){
          $mydata= array(
           'number'=>$row['number']+$_POST['number'],
           'updated_at'=>$today,
           'modified_by'=>$this->session->userdata('id')
         );
          $this->Msanpham->product_update($mydata, $id);
          $this->session->set_flashdata('success', 'Cập nhật sản phẩm thành công');
          redirect('admin/product','refresh');
        }
        $this->data['row']=$row;
        $this->data['view']='import';
        $this->data['title']='Cập nhật sản phẩm';
        $this->load->view('backend/layout', $this->data);
      }
      // public function quicksearch(){
      // 	$query = '';
      // 	if($this->input->post('query'))
      // 	{
      // 		$query = $this->input->post('query');
      // 	}
      // 	$data = $this->Msanpham->get_data_search($query);
      // 	if($data->num_rows() > 0)
      // 	{
      // 		foreach($data->result() as $row)
      // 		{
      // 			$this->data['get'] = $row;
      // 			$this->data['view']='index';
      // 			$this->load->view('backend/layout', $this->data);

      // 		}
      // 	}


      // }
    }
