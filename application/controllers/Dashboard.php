<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['profile'] = $this->session->userdata('userdata');
        $data['database'] = array(
            'products' => $this->db->count_all_results('products'),
            'users' => $this->db->get_where('users', array('user_role' => 2))->num_rows(),
            'trans' => $this->db->count_all_results('transactions')
        );
        $data['title'] = 'Dashboard';
        $data['content'] = 'admin/dashboard/dashboard.php';
        $data['script'] = 'admin/dashboard/script-dashboard.php';
        $this->load->view('layout/admin/index.php', $data);
    }
}
