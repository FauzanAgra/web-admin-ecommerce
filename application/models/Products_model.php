<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products_model extends CI_Model
{
    function get_all_products($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('product_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('products')->result_array();
    }

    function get_count_products($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('products')->count_all_results();
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
        $this->db->join('categories', 'categories.category_id = products.product_category');
    }

    function delete_product($id_product)
    {
        return $this->db->delete('products', array('product_id' => $id_product));
    }

    function save($params)
    {
        $this->db->insert('products', $params);
        return $this->db->insert_id();
    }

    function update_product($ids, $params)
    {
        $this->db->where('product_id', $ids);
        return $this->db->update('products', $params);
    }

    function get_image($ids)
    {
        $this->db->select('product_id, product_image');
        $this->db->where('product_id', $ids);
        return $this->db->get('products')->row_array();
    }

    function get_where_product($id)
    {
        $this->set_join();
        return $this->db->get_where('products', array('product_id' => $id))->row_array();
    }

    function update_stat_active($id_product, $status)
    {
        return $this->db->update('products', $status, 'product_id =' . $id_product);
    }
    function update_stat_deactive($id_product, $status)
    {
        return $this->db->update('products', $status, 'product_id =' . $id_product);
    }
}
