<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{
    function get_all_users($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('user_full_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get_where('users', array('user_role' => 2))->result_array();
    }

    function get_count_users($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        $this->db->where('user_role', 2);
        return $this->db->from('users')->count_all_results();
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
        $this->db->join('roles', 'roles.role_id = users.user_role');
    }

    function insert_user($params)
    {
        return $this->db->insert('users', $params);
    }

    function delete_user($id_user)
    {
        return $this->db->delete('users', array('user_id' => $id_user));
    }

    function save($params)
    {
        $this->db->insert('users', $params);
        return $this->db->insert_id();
    }

    function update_user($ids, $params)
    {
        $this->db->where('user_id', $ids);
        return $this->db->update('users', $params);
    }

    function get_image($id_user)
    {
        $this->db->select('user_id, user_image');
        $this->db->where('user_id', $id_user);
        return $this->db->get('users')->row_array();
    }

    function change_password($user_id, $password)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', array('user_password' => $password));
    }

    function get_where_user($id)
    {
        $this->set_join();
        return $this->db->get_where('users', array('user_id' => $id))->row_array();
    }

    function update_stat_active($id_user, $status)
    {
        return $this->db->update('users', $status, 'user_id =' . $id_user);
    }
    function update_stat_deactive($id_user, $status)
    {
        return $this->db->update('users', $status, 'user_id =' . $id_user);
    }
}
