<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles_model extends CI_Model
{
    function get_all_roles($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('role_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('roles')->result_array();
    }

    function get_count_roles($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('roles')->count_all_results();
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


    function insert_role($params)
    {
        return $this->db->insert('roles', $params);
    }

    function update_role($id, $params)
    {
        $this->db->where('role_id', $id);
        return $this->db->update('roles', $params);
    }

    function delete_role($id_role)
    {
        return $this->db->delete('roles', array('role_id' => $id_role));
    }

    function get_where_role($id)
    {
        return $this->db->get_where('roles', array('role_id' => $id))->row_array();
    }

    function update_stat_active($id_role, $status)
    {
        return $this->db->update('roles', $status, 'role_id =' . $id_role);
    }

    function update_stat_deactive($id_role, $status)
    {
        return $this->db->update('roles', $status, 'role_id =' . $id_role);
    }
}
