<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcauhinh extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->table = 'configs';
    }

    public function configuration_detail($id = 1)
    {
       $this->db->where('id', 1);
       $query = $this->db->get($this->table);
       return $query->row_array();   
    }

    // Cập nhật
    public function configuration_update($mydata, $id = 1)
    {
        $this->db->where('id', 1);
        $this->db->update($this->table, $mydata);
    }
}

/* End of file Mcauhinh.php */
/* Location: ./application/models/Mcauhinh.php */