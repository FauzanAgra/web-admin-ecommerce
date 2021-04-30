<?php defined('BASEPATH') or exit('No direct script access allowed');

class Checkout extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Checkout_model');
        $this->load->library('cart');
    }

    public function index()
    {
        $total = 0;
        $userdata = $this->session->userdata('userdata');

        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'load') {
                $ret->stat = 1;
                $ret->data = $this->show_cart();
            } else if ($action == 'insert') {
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
            } else if ($action == 'delete') {
                $params = array(
                    'rowid' => $this->input->post('checkout-id'),
                    'qty' => 0
                );

                $stat = $this->cart->update($params);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = "Data Telah Terhapus";
                }
            } else if ($action == 'insert-trans') {
                //Loop Data Session Cart untuk ambil Total Harga
                foreach ($this->cart->contents() as $content) {
                    if ($content['user'] == $userdata['user_id']) {
                        $total += $content['subtotal'];
                    }
                }
                $kode_trans = $this->Checkout_model->generateTrx();

                //Ambil Data untuk di eksekusi ke Insert Table Transactions
                $params_trans = array(
                    'trans_number' => $kode_trans,
                    'trans_user' => $userdata['user_id'],
                    'trans_total' => $total,
                    'trans_paid_type' => $this->input->post('paid-type'),
                    'trans_paid_bank' => $this->input->post('paid-bank'),
                    'trans_courier' => $this->input->post('courier'),
                    'trans_stat' => 1,
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_address' => $this->input->post('address')
                );

                // Data  dimasukkan kedalam Table Transactions
                $this->Checkout_model->insert_trans($params_trans);

                //Ambil id Transaction
                $trans_id = $this->Checkout_model->get_id_trans($kode_trans);

                //Looping sekagilus menginputkan di kedalam Table Detail
                foreach ($this->cart->contents() as $data) {
                    if ($data['user'] == $userdata['user_id']) {
                        //Insert Detail Trans
                        $params_detail = array(
                            'detail_trans' => $trans_id['trans_id'],
                            'detail_product' => $data['id'],
                            'detail_price' => $data['subtotal'],
                            'detail_qty' => $data['qty']
                        );
                        $this->Checkout_model->insert_detail_trans($params_detail);

                        //Hapus data yang sudah di Inputkan 
                        $params_destroy = array(
                            'rowid' => $data['rowid'],
                            'qty' => 0
                        );
                        $this->cart->update($params_destroy);
                    }
                }

                $ret->stat = 1;
                $ret->mesg = "Berhasil di Order";
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['title'] = 'Checkout';
            $data['content'] = 'web/checkout.php';
            $data['script'] = 'web//script-checkout.php';
            $this->load->view('layout/web/index.php', $data);
        }
    }

    function show_cart()
    {
        $cartSession = $this->cart->contents();
        $userdata = $this->session->userdata('userdata');
        $bank = $this->db->get('banks')->result_array();

        $output = '';
        $total = 0;
        $item = 0;

        if (count($cartSession) > 0) {

            $output .= '
                <div class="col-lg-8 col-md-12">
                <h4 class="text-center">KERANJANG</h4>
                <div class="card">
                    <form id="form-checkout" class="m-3">
                        <table class="table table-striped table-responsive-md">
                            <thead class="text-center">
                                <tr>
                                    <th width="5%"></th>
                                    <th width="10%">Gambar</th>
                                    <th width="30%">Produk</th>
                                    <th width="25%">Harga</th>
                                    <th width="5%">Qty</th>
                                    <th width="25%">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="checkout-body">
            ';

            foreach ($cartSession as $content) {
                if ($content['user'] == $userdata['user_id']) {
                    $output .= '
                        <tr>
                            <td>
                                <button type="button" id="' . $content['rowid'] . '" class="remove-cart btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>
                                <img src="' . base_url("assets/img/products/") . $content['image'] . '" width="80px" class="border rounded" >
                            </td>
                            <td>' . $content['name'] . '</td>
                            <td>Rp. ' . number_format($content['price'], 0, ',', '.') . '</td>
                            <td>' . $content['qty'] . '</td>
                            <td>Rp. ' . number_format($content['subtotal'], 0, ',', '.') . '</td>
                        </tr>
                    ';
                    $total += $content['subtotal'];
                    $item += $content['qty'];
                }
            }

            $output .= '
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            ';

            if ($total != 0) {
                $output .= '
                <div class="col-lg-4 col-md-12">
                    <h4 class="text-center">DETAIL</h4>
                    <div class="card p-4">
                        <div class="row">
                            <h5 style="font-size: 1rem; font-weight: 800;">Detail penerima</h5>
                        </div>
                        <div class="row mb-2">
                            <input type="text" class="form-control" id="nama" placeholder="Nama Penerima"></input>
                        </div>
                        <div class="row mb-2">
                            <input type="number" class="form-control" id="nomor" placeholder="Nomor Handphone"></input>
                        </div>
                        <div class="row mb-2">
                            <textarea class="form-control" id="alamat" rows="2" placeholder="Alamat"></textarea>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 style="font-size: 1rem; font-weight: 800;">Pembayaran</h5>
                        </div>
                        <div class="row">
                            <select class="custom-select" id="pembayaran">
                                <option value="0" selected>-- Pembayaran --</option>';
                foreach ($bank as $b) {
                    $output .= '<option value="' . $b['bank_id'] . '">Bank ' . $b['bank_name'] . ' - ' . $b['bank_number'] . '</option>';
                }
                $output .= ' </select>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 style="font-size: 1rem; font-weight: 800;">Pengiriman</h5>
                        </div>
                        <div class="row">
                            <select class="custom-select" id="pengiriman">
                                <option value="0" selected>-- Pengiriman --</option>
                                <option value="1">JNE - Regular</option>
                                <option value="2">JNE - YES</option>
                                <option value="3">JNE - OKE</option>
                                <option value="4">SiCepat - Reguler</option>
                                <option value="5">SiCepat - Next Day</option>
                            </select>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 style="font-size: 1rem; font-weight: 800;">Ringkasan belanja</h5>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <p>Total Harga (' . $item . ' barang)</p>
                            <p>Rp. ' . number_format($total, 0, ',', '.') . '</p>
                        </div>
                        <hr>
                        <div class="row d-flex justify-content-between">
                            <p>Total Harga</p>
                            <p>Rp. ' . number_format($total, 0, ',', '.') . '</p>
                        </div>
                        <button type="button" class="btn btn-success btnPayment">Bayar</button>
                    </div>
                </div>
                ';
            } else {
                $output = '';
                $output .= '
                <div class="col-12 text-center">
                    <img src=" ' . base_url('assets/img/frontend/cart-empty.jpg') . '" width="200px">
                    <h4 class="mt-2">Wah, keranjang belanjamu kosong</h4>
                    <p>Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="' . base_url('ecommerce/product') . '" class="btn btn-dark" >Mulai Belanja</a>
                </div>
                ';
            }
        } else {
            $output .= '
                <div class="col-12 text-center">
                    <img src=" ' . base_url('assets/img/frontend/cart-empty.jpg') . '" width="200px">
                    <h4 class="mt-2">Wah, keranjang belanjamu kosong</h4>
                    <p>Yuk, isi dengan barang-barang impianmu!</p>
                    <a href="' . base_url('ecommerce/product') . '" class="btn btn-success" >Mulai Belanja</a>
                </div>
                ';
        }
        return $output;
    }
}
