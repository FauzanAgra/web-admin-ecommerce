<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{
    function get_all_categories($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('category_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('categories')->result_array();
    }

    function get_count_categories($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('categories')->count_all_results();
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
    }


    function insert_category($params)
    {
        return $this->db->insert('categories', $params);
    }

    function update_category($id, $params)
    {
        $this->db->where('category_id', $id);
        return $this->db->update('categories', $params);
    }

    function delete_category($id_category)
    {
        return $this->db->delete('categories', array('category_id' => $id_category));
    }

    function get_where_category($id)
    {
        return $this->db->get_where('categories', array('category_id' => $id))->row_array();
    }

    function update_stat_active($id_category, $status)
    {
        return $this->db->update('categories', $status, 'category_id =' . $id_category);
    }

    function update_stat_deactive($id_category, $status)
    {
        return $this->db->update('categories', $status, 'category_id =' . $id_category);
    }
}
