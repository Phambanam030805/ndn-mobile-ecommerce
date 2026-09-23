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
class Gioithieu extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->data['com']='gioithieu';
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Msanpham');
    }
    
	public function index(){
        $this->data['title']='NDN Mobile - Giới thiệu';
        $this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
}
