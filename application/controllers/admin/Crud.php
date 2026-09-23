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
 class Crud extends CI_Controller {
      //functions  
      function index(){
          $this->data['title']='Danh sách khách hàng';
          $this->load->view('backend/components/crud_view', $this->data);
      }  
      function fetch_user(){  
           $this->load->model('frontend/Mdulieu');
           $fetch_data = $this->Mdulieu->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $row->id;  
                $sub_array[] = $row->fullname; 
                $sub_array[] = $row->phone;
                $sub_array[] = $row->email;; 
                $sub_array[] = '<a class="btn btn-info btn-xs" href="customer/update/'.$row->id.'" role = "button">
                          <span class="glyphicon glyphicon-edit"></span>Xem
                        </a>
                ';  
                $sub_array[] = '
               <a class="btn btn-danger btn-xs" href="customer/trash/'.$row->id.'" onclick="return confirm("Xác nhận xóa thông tin khách hàng này ?"")" role = "button">
                          <span class="glyphicon glyphicon-trash"></span>Xóa
                        </a>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Mdulieu->get_all_data(),  
                "recordsFiltered"     =>     $this->Mdulieu->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  
 }  