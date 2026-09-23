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
class Trangchu extends CI_Controller {
	// Hàm khởi tạo
    function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mnoidung');
        $this->data['com']='trangchu';
    }
    
	public function index()
	{
        $this->data['title']='NDN Mobile - Điện thoại, Laptop, Link kiện chính hãng';
        $this->data['view']='index';
		$this->load->view('frontend/layout',$this->data);
	}
}
