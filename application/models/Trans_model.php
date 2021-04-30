<?php defined('BASEPATH') or exit('No direct script access allowed');

class Trans_model extends CI_Model
{
    function get_all_trans($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('trans_number', "desc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('transactions')->result_array();
    }

    function get_count_trans($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('transactions')->count_all_results();
    }

    function set_params($params)
    {
        if ($params) {
            foreach ($params as $k => $v) {
                $this->db->where($k, $v);
            }
        }
    }

    function set_search($search)
    {
        if ($search) {
            $n = 0;
            $this->db->group_start();
            foreach ($search as $key => $val) {
                if ($n == 0) {
                    $this->db->like($key, $val);
                } else {
                    $this->db->or_like($key, $val);
                }

                $n++;
            }
            $this->db->group_end();
        }
    }

    function set_join()
    {
        $this->db->select('*');
        $this->db->join('users', 'users.user_id = transactions.trans_user');
    }

    function get_where_trans($id_trans)
    {
        $this->set_join();
        return $this->db->get_where('transactions', array('trans_id' => $id_trans))->row_array();
    }

    function get_where_detail($id_trans)
    {
        $this->db->select('*');
        $this->db->join('products', 'products.product_id = trans_details.detail_product');
        $this->db->where('detail_trans', $id_trans);
        return $this->db->get('trans_details');
    }

    function get_trans_user($id_user)
    {
        $this->set_join();
        $this->db->where('trans_user', $id_user);
        $this->db->order_by('trans_date', 'DESC');
        return $this->db->get('transactions')->result_array();
    }
}
