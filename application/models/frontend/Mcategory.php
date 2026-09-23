<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategory extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->db->dbprefix('category');
    }

    /* =========================
        LẤY ID DANH MỤC THEO LINK
    ========================== */
    public function category_id($link)
    {
        $this->db->where('link', $link);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);

        $row = $this->db->get($this->table)->row_array();

        return $row ? (int)$row['id'] : 0;
    }

    /* =========================
        LẤY TÊN DANH MỤC
    ========================== */
    public function category_name($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);

        $row = $this->db->get($this->table)->row_array();
        return $row ? $row['name'] : '';
    }

    /* =========================
        LẤY LINK DANH MỤC
    ========================== */
    public function category_link($id)
    {
        $this->db->where('id', $id);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->limit(1);

        $row = $this->db->get($this->table)->row_array();
        return $row ? $row['link'] : '';
    }

    /* =========================
        LẤY DANH MỤC THEO PARENT
        (DÙNG CHO HOME)
    ========================== */
    public function category_list($parentid = 0, $limit = 10)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('sort_order', 'ASC');
        $this->db->limit($limit);

        return $this->db->get($this->table)->result_array();
    }

    /* =========================
        LẤY LIST CATID (CHA + CON)
        -> CỰC KỲ QUAN TRỌNG
    ========================== */
    public function category_listcat($parentid)
    {
        if ($parentid == 0) return [];

        $ids = [$parentid];

        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);

        $list = $this->db->get($this->table)->result_array();

        foreach ($list as $row) {
            $ids[] = $row['id'];
        }

        return $ids;
    }

    /* =========================
        MENU
    ========================== */
    public function category_menu($parentid)
    {
        $this->db->where('parentid', $parentid);
        $this->db->where('status', 1);
        $this->db->where('trash', 1);
        $this->db->order_by('orders ASC, updated_at DESC');

        return $this->db->get($this->table)->result_array();
    }
}
