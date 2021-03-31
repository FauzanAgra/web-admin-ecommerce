<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ecommerce extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'load') {
                $data = $this->db->get('products', 4)->result_array();
                $user = $this->session->userdata('userdata');
                $show = $this->show_data($data, $user);
                if ($data) {
                    $ret->stat = 1;
                    $ret->data = $show;
                }
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['title'] = 'E-Commerce';
            $data['jumbotron'] = 'Jumbotron';
            $data['info'] = 'Info';
            $data['content'] = 'web/product-front.php';
            $data['script'] = 'web/script-product-front.php';
            $this->load->view('layout/web/index.php', $data);
        }
    }

    function product()
    {
        $userdata = $this->session->userdata('userdata');

        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'load') {
                $datas = $this->db->get('products')->result_array();
                $user = $this->session->userdata('userdata');
                $show = $this->show_data($datas, $user);
                if ($show) {
                    $ret->stat = 1;
                    $ret->data = $show;
                }
            } else if ($action == 'insert-checkout') {
                $params = array(
                    'id' => $this->input->post('product-id'),
                    'name' => $this->input->post('product-name'),
                    'price' => $this->input->post('product-price'),
                    'qty' => $this->input->post('product-qty'),
                    'image' => $this->input->post('product-image'),
                    'user' =>  $userdata['user_id']
                );
                $stat = $this->cart->insert($params);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Berhasil Ditambahkan di Keranjang';
                }
            }

            echo json_encode($ret);
        } else {
            $data['profile'] = $userdata;
            $data['title'] = 'Product';
            $data['info'] = 'Info';
            $data['content'] = 'web/product.php';
            $data['script'] = 'web/script-product.php';
            $this->load->view('layout/web/index.php', $data);
        }
    }

    function product_detail()
    {
        $param = array('product_id' => $this->input->post('productid'));
        $data['profile'] = $this->session->userdata('userdata');
        $data['title'] = 'Detail Product';
        $data['detail'] = $this->db->get_where('products', $param)->row_array();
        $data['content'] = 'web/detail-product.php';
        $data['script'] = 'web/script-detail.php';
        $this->load->view('layout/web/index.php', $data);
    }

    function show_data($datas, $user)
    {
        $output = '';
        foreach ($datas as $d) {
            $output .= '
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                    <div class="card shadow mt-sm-3">
                        <div class="text-center">
                            <img class="card-img-top p-lg-3" style="width:250px;height:230px" src="' . base_url('assets/img/products/') . $d['product_image'] . '">
                        </div>
                        <div class="card-body">
                            <h5>' . $d['product_name'] . '</h5>
                            <p class="text-muted">Rp. ' . number_format($d['product_price'], 0, ',', '.')  . '</p>
            ';
            if (isset($user)) {
                $output .= '
                    <a href="#" class="btn btn-primary btnDetail" data-productid="' . $d['product_id'] . '" >Detail</a>
                    <a href="#" class="btn btn-danger btnAddCart" data-productid="' . $d['product_id'] . '" data-productname="' . $d['product_name'] . '" data-productprice="' . $d['product_price'] . '" data-productimage="' . $d['product_image'] . '" >Add to Cart</a>
                ';
            }
            $output .=    '
                    </div>
                </div>
            </div>
            ';
        }
        return $output;
    }
}
