<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('loggedin')) {
            redirect(base_url('login'));
        } else {
            $this->check_session();
        }
    }

    private function check_session($user_name = null)
    {
        $userdata = $this->session->userdata('userdata');
        if ($user_name) {
            if ($user_name != $userdata['user_name']) {
                redirect(base_url('login/logout'));
            }
        }

        $last_time = $userdata['last_time'];
        $curr_time = time();
        $mins = ($curr_time - $last_time) / 60;
        if ($mins > 60) {
            redirect(base_url('login'));
        } else {
            $userdata['last_time'] = $curr_time;
            $this->session->set_userdata('userdata', $userdata);
        }
    }
}
