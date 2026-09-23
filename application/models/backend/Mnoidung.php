<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mnoidung extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'posts';
    }

    /**
     * Lấy danh sách (Tin tức hoặc Slider)
     */
    public function content_all($type = 'news', $limit = null, $first = null)
    {
        $this->db->where('trash', 1);
        $this->db->where('type', $type);
        $this->db->order_by('created_at', 'desc');
        if ($limit !== null && $first !== null) {
            $query = $this->db->get($this->table, $limit, $first);
        } else {
            $query = $this->db->get($this->table);
        }
        return $query->result_array();
    }

    public function content_count($type = 'news')
    {
        $this->db->where('trash', 1);
        $this->db->where('type', $type);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function content_detail($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();   
    }

    public function content_insert($mydata)
    {
        $this->db->insert($this->table, $mydata);
    }

    public function content_update($mydata, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $mydata);
    }

    public function content_trash($type = 'news', $limit = null, $first = null)
    {
        $this->db->where('trash', 0);
        $this->db->where('type', $type);
        if ($limit !== null && $first !== null) {
            $query = $this->db->get($this->table, $limit, $first);
        } else {
            $query = $this->db->get($this->table);
        }
        return $query->result_array();
    }

    public function content_trash_count($type = 'news')
    {
        $this->db->where('trash', 0);
        $this->db->where('type', $type);
        $query = $this->db->get($this->table);
        return $query->num_rows();
    }

    public function content_restore($id)
    {
        $data = array('trash' => 1);
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
    }

    public function content_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    // Hàm bổ sung để tương thích với các View cũ gọi trực tiếp slider
    public function slider_trash_count()
    {
        return $this->content_trash_count('slider');
    }

    public function slider_count()
    {
        return $this->content_count('slider');
    }
}