<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_User extends MY_Controller
{
    public function index()
    {
        $data['profile'] = $this->session->userdata('userdata');
        $data['title'] = 'User';
        $data['content'] = 'web/user.php';
        $data['script'] = 'web/script-user.php';
        $this->load->view('layout/web/index.php', $data);
    }
}
