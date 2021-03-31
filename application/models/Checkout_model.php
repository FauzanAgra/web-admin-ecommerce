<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Checkout_model extends CI_Model
{
    function generateTrx()
    {
        date_default_timezone_set("Asia/Jakarta");
        $maxIdTrax = $this->db->query("SELECT MAX(`trans_id`) as maxId FROM transactions")->row_array();
        $data = $maxIdTrax['maxId'];
        if ($data == null) {
            $data = 0;
            $data++;
        } else {
            $data++;
        }
        $kodeBarang = "DMT" . date("Ymd") . sprintf("%08s", $data);
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
