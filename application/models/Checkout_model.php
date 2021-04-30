<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_model extends CI_Model
{
    function generateTrx()
    {
        $kodeBarang = "DMT" . date("Ymd") . mt_rand(0, 99999999);
        return $kodeBarang;
    }

    function insert_trans($params)
    {
        return $this->db->insert('transactions', $params);
    }

    function insert_detail_trans($params)
    {
        return $this->db->insert('trans_details', $params);
    }

    function get_id_trans($id_trans)
    {
        $this->db->select('trans_id');
        return $this->db->get_where('transactions', array('trans_number' => $id_trans))->row_array();
    }
}
