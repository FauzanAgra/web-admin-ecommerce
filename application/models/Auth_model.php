<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function check_users($username)
    {
        $this->db->where('user_name', $username);
        return $this->db->get('users');
    }
}
