<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Trans_model');
    }

    public function index()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'load') {
                $columns = array(
                    '3' => 'trans_stat',
                    '4' => 'trans_date'
                );
                $limit = $this->input->post('length');
                $start = $this->input->post('start');
                $order = $columns[$this->input->post('order')[0]['column']];
                $dir = $this->input->post('order')[0]['dir'];
                $search = [];
                if ($this->input->post('search')['value']) {
                    $s = $this->input->post('search')['value'];
                    foreach ($columns as $k => $v) {
                        $search[$v] = $s;
                    }
                }

                $params = array();
                $datas = $this->Trans_model->get_all_trans($params, $search, $limit, $start, $order, $dir);
                for ($x = 0; $x < count($datas); $x++) {
                    $datas[$x]['date_time'] = date('d M Y - H:i', strtotime($datas[$x]['trans_date']));
                }
                $ret->data = $datas;
                $totaldata = $this->Trans_model->get_count_trans($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            } else if ($action == 'detail') {
                $id_trans = $this->input->post('id-trans');
                $data = $this->Trans_model->get_where_trans($id_trans);
                $data['trans_detail'] = $this->Trans_model->get_where_detail($id_trans)->result_array();
                $show = $this->show_trans($data);
                $data['date_time'] = date('d M Y, H:i', strtotime($data['trans_date']));
                if ($show) {
                    $ret->stat = 1;
                    $ret->data = $data;
                    $ret->show = $show;
                }
            } else if ($action == 'getImage') {
                $id = $this->input->post('trans-id');

                $image = $this->db->get_where('transactions', array('trans_id' => $id))->row_array();
                $data = array(
                    'trans_id' => $image['trans_id'],
                    'trans_invoice' => $image['trans_invoice']
                );

                if ($data) {
                    $ret->stat = 1;
                    $ret->data = $data;
                    $ret->mesg = 'Data Berhasil';
                }
            } else if ($action ==  'cancel-trans') {
                $trans_id = $this->input->post('trans-id');
                $params = array(
                    'trans_stat' => 6,
                );
                $stat = $this->db->update('transactions', $params, array('trans_id' => $trans_id));

                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Transaksi berhasil dibatalkan';
                }
            } else if ($action == 'proses-trans') {
                $where = array(
                    'trans_id' => $this->input->post('trans-id')
                );
                $params = array(
                    'trans_stat' => 3
                );
                $stat = $this->db->update('transactions', $params, $where);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Transaksi berhasil di Proses';
                }
            } else if ($action == 'input-resi') {
                $where = array(
                    'trans_id' => $this->input->post('trans-id')
                );

                $params = array(
                    'trans_stat' => $this->input->post('trans-stat'),
                    'trans_resi' => $this->input->post('trans-resi')
                );

                $stat = $this->db->update('transactions', $params, $where);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Resi berhasil di inputkan';
                }
            }

            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['title'] = 'Transaksi';
            $data['content'] = 'admin/transaction/transaction.php';
            $data['script'] = 'admin/transaction/script-trans.php';
            $this->load->view('layout/admin/index.php', $data);
        }
    }

    function show_trans($data)
    {
        $output = '';

        $output .= '
            <div class="col-12">
                <div class="row">
                    <div class="col-8">
                        <h5 class="text-center">Daftar Produk</h5>
                    </div>
                    <div class="col-4">
                        <h5 class="text-center">Harga</h5>
                    </div>
                </div>
                <div class="mt-2">
        ';

        foreach ($data['trans_detail'] as $detail) {
            $output .= '
                    <div class="row mt-2">
                        <div class="col-8">
                            <div class="row border-right">
                                <div class="col-3">
                                    <img src="' . base_url('assets/img/products/') . $detail['product_image'] . '" style="width: 100px;" class="img-thumbnail">
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-bold">' . $detail['product_name'] . '</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p>' . $detail['detail_qty'] . ' Produk x Rp. ' . number_format($detail['detail_price'], 0, '.', '.') . '</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <div class="col-12">
                                    <p class="font-weight-bold">Rp. ' . number_format($detail['detail_qty'] * $detail['detail_price'], 0, '.', '.') . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
            ';
        }

        $output .= '
                </div>
            </div>
        </div>
        ';

        return $output;
    }
}
