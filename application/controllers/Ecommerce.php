<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ecommerce extends CI_Controller
{
    public function index()
    {
        $data['profile'] = $this->session->userdata('userdata');
        $data['title'] = 'E-Commerce';
        $data['jumbotron'] = 'Jumbotron';
        $data['content'] = 'web/product-front.php';
        $data['script'] = 'web/script-product-front.php';
        $this->load->view('layout/web/index.php', $data);
    }
}
