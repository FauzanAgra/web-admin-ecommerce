<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_User extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
    }
    public function index()
    {

        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'update-user') {
                $user_id = $this->input->post('id-user');
                $params = array(
                    'user_name' => $this->input->post('name-user'),
                    'user_full_name' => $this->input->post('name-full-user'),
                    'user_phone' => $this->input->post('phone-user'),
                    'user_address' => $this->input->post('address-user'),
                    'user_image' => $this->input->post('image-user')
                );

                if ($params['user_image']) {
                    $this->Users_model->update_user($user_id, $params);
                    $ret->stat = 1;
                    $ret->mesg = "Update Berhasil";
                } else {
                    $path = FCPATH . 'assets/img/users/';
                    $config['image_library']    = 'gd2';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->input->post('image-user') != "undefined") {
                        if ($this->upload->do_upload('image-user')) {
                            $upload = $this->upload->data();
                            $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                            $old_name = $upload['full_path'];
                            $new_name = $path . $raw_photo;
                            if (rename($old_name, $new_name)) {
                                //compress
                                $compress['image_library'] = 'gd2';
                                $compress['source_image'] = 'assets/img/users/' . $raw_photo;
                                $compress['create_thumb'] = FALSE;
                                $compress['maintain_ratio'] = TRUE;
                                $compress['width'] = 640;
                                $compress['new_image'] = 'assets/img/users/' . $raw_photo;
                                $this->load->library('image_lib', $compress);
                                $this->image_lib->resize();
                                $data = $this->Users_model->get_image($user_id);
                                if ($data && $data['user_id']) {
                                    $params = array(
                                        'user_image' => $raw_photo
                                    );
                                    if (!empty($data['user_image'])) {
                                        if (file_exists($path . $data['user_image'])) {
                                            unlink($path . $data['user_image']);
                                        }
                                    }
                                    $stat = $this->Users_model->update_user($user_id, $params);
                                    $this->session->unset_userdata('userdata');
                                    $user = $this->db->get_where('users', array('user_id' => $user_id))->row_array();
                                    if ($stat == true) {
                                        $ret->stat = 1;
                                        $ret->mesg = "Update Berhasil";
                                    }
                                }
                            }
                        } else {
                            $ret->stat = 1;
                            $ret->mesg = 'Upload Gambar Gagal';
                        }
                    } else {
                        $ret->stat = 1;
                        $ret->mesg = 'Gambar Tidak Ada';
                    }
                }
            } else if ($action == 'change-password') {
                $user_id = $this->input->post('id-user');
                $current_password = $this->input->post('current-password');
                $new_password1 = $this->input->post('new-password');
                $new_password2 = $this->input->post('new-password-repeat');

                $data = $this->db->get_where('users', array('user_id' => $user_id))->row_array();
                if ($data) {
                    if (password_verify($current_password, $data['user_password'])) {
                        if ($new_password1 == $new_password2) {
                            $hash = password_hash($new_password1, PASSWORD_DEFAULT);
                            $stat = $this->Users_model->change_password($user_id, $hash);
                            if ($stat) {
                                $ret->stat = 1;
                                $ret->mesg = "Password berhasil diubah";
                            }
                        } else {
                            $ret->stat = 0;
                            $ret->mesg = "Password tidak sama!";
                        }
                    } else {
                        $ret->stat = 0;
                        $ret->mesg = "Password salah!";
                    }
                } else {
                    $ret->stat = 0;
                    $ret->mesg = "User tidak ada";
                }
            } else if ($action == 'load-trans') {
                $id_user = $this->input->post('id-user');
                $datas =  $this->Trans_model->get_trans_user($id_user);
                for ($x = 0; $x < count($datas); $x++) {
                    $datas[$x]['trans_count'] = $this->db->get_where('trans_details', array('detail_trans' => $datas[$x]['trans_id']))->num_rows();
                    $datas[$x]['trans_detail'] = $this->Trans_model->get_where_detail($datas[$x]['trans_id'])->row_array();
                }
                $show_data = $this->show_trans_user($datas);
                if ($show_data) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Berhasil di Load';
                    $ret->data = $show_data;
                }
            } else if ($action == 'upload') {
                // $image_trans = $this->input->post('upload');
                // $params = array(
                //     'trans_stat' => $this->input->post('status')
                // );
                $where = array(
                    'trans_id' => $this->input->post('id_trans'),
                    'trans_number' => $this->input->post('trans_number')
                );

                $data = $this->db->get_where('transactions', $where)->row_array();

                if ($data) {
                    $path = FCPATH . 'assets/img/invoice/';
                    $config['image_library'] = 'gd2';
                    $config['upload_path'] = $path;
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->input->post('upload') != 'undefined') {
                        if ($this->upload->do_upload('upload')) {
                            $upload = $this->upload->data();
                            $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                            $old_name = $upload['full_path'];
                            $new_name = $path . $raw_photo;
                            if (rename($old_name, $new_name)) {
                                if ($data && $data['trans_id']) {
                                    $params = array(
                                        'trans_stat' => $this->input->post('trans_stat'),
                                        'trans_invoice' => $raw_photo
                                    );

                                    if (!empty($data['trans_invoice'])) {
                                        if (file_exists($path . $data['trans_invoice'])) {
                                            unlink($path . $data['trans_invoice']);
                                        }
                                    }
                                    $stat = $this->db->update('transactions', $params, array('trans_id' => $data['trans_id']));
                                    if ($stat) {
                                        $ret->stat = 1;
                                        $ret->mesg = "Upload Berhasil, mohon menunggu konfirmasi admin!";
                                    }
                                }
                            }
                        } else {
                            $ret->stat = 1;
                            $ret->mesg = 'Upload Gambar Gagal';
                        }
                    } else {
                        $ret->stat = 1;
                        $ret->mesg = 'Gambar Tidak Ada';
                    }
                } else {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Tidak Ditemukan';
                }
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['title'] = 'User';
            $data['content'] = 'web/user.php';
            $data['script'] = 'web/script-user.php';
            $this->load->view('layout/web/index.php', $data);
        }
    }

    function show_trans_user($datas)
    {
        $output = '';

        if ($datas) {
            foreach ($datas as $data) {
                $output .= '
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="card shadow-sm p-3" style="border-radius: 1rem;">
                                    <div class="row mb-4">
                                        <div class="col-12 d-flex flex-row">
                                            <small class="font-weight-bold border-right pr-3">
                                                #' . $data['trans_number'] . '
                                            </small>';

                if ($data['trans_stat'] == 1) {
                    $output .= '<span class="badge badge-warning ml-3">Upload Bukti Transaksi</span>';
                } else if ($data['trans_stat'] == 2) {
                    $output .= '<span class="badge badge-warning ml-3">Menunggu Konfirmasi</span>';
                } else if ($data['trans_stat'] == 3) {
                    $output .= '<span class="badge badge-warning ml-3">Proses</span>';
                } else if ($data['trans_stat'] == 4) {
                    $output .= '<span class="badge badge-warning ml-3">Pengiriman</span>';
                } else if ($data['trans_stat'] == 5) {
                    $output .= '<span class="badge badge-success ml-3">Diterima</span>';
                } else if ($data['trans_stat'] == 6) {
                    $output .= '<span class="badge badge-danger ml-3">Dibatalkan</span>';
                }

                $output .= '</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12">
                ';

                if ($data['trans_count'] > 1) {
                    $count = $data['trans_count'] - 1;
                    $output .= '
                        <div class="row">
                            <div class="col-lg-9 col-sm-8 col-md-8 border-right m-0">
                                <div class="media">
                                    <img src="' . base_url('assets/img/products/') . $data['trans_detail']['product_image'] . '" class="mr-3 img-thumbnail" style="max-width: 80px;">
                                    <div class="media-body ">
                                        <h6 class="m-0 d-inline-block font-weight-bold text-truncate" style="max-width: 200px;">' . $data['trans_detail']['product_name'] . '</h6>
                                        <br>
                                        <small>' . $data['trans_detail']['detail_qty'] . ' Barang x Rp. ' . number_format($data['trans_detail']['detail_price'], 0, '.', '.') . '</small>
                                        <br>
                                        <small>+' . $count . ' produk lainnya</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 col-md-4 ">
                                <p class="mb-0 font-weight-normal">Total Berlanja</p>
                                <p class="font-weight-bold">Rp. ' . number_format($data['trans_total'], 0, '.', '.') . '</p>
                            </div>
                        </div>
                    ';
                } else {
                    $output .= '
                        <div class="row">
                            <div class="col-lg-9 col-sm-8 col-md-8 border-right m-0">
                                <div class="media">
                                    <img src="' . base_url('assets/img/products/') . $data['trans_detail']['product_image'] . '" class="mr-3 img-thumbnail" style="max-width: 80px;">
                                    <div class="media-body ">
                                        <h6 class="m-0 d-inline-block font-weight-bold text-truncate" style="max-width: 200px;">' . $data['trans_detail']['product_name'] . '</h6>
                                        <br>
                                        <small>' . $data['trans_detail']['detail_qty'] . ' Barang x Rp. ' . number_format($data['trans_detail']['detail_price'], 0, '.', '.') . '</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-4 col-md-4 ">
                                <p class="mb-0 font-weight-normal">Total Berlanja</p>
                                <p class="font-weight-bold">Rp. ' . number_format($data['trans_total'], 0, '.', '.') . '</p>
                            </div>
                        </div>
                    ';
                }


                $output .= '
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-lg-4 text-right">
                                    <button class="btn btn-sm w-100 font-weight-bold" id="btnUpload" data-id="' . $data['trans_id'] . '" data-trans="' . $data['trans_number'] . '">Lihat Detail Transaksi</button>
                                </div>
                ';
                if ($data['trans_stat'] == 1) {
                    $output .= '                
                                    <div class="col-lg-3 text-right">
                                        <button class="btn btn-sm w-100 btn-warning font-weight-bold" id="btnUpload" data-id="' . $data['trans_id'] . '" data-trans="' . $data['trans_number'] . '">Upload Bukti</button>
                                    </div>
                    ';
                } else if ($data['trans_stat'] == 3) {
                    $output .= '
                                    <div class="col-lg-3 text-right">
                                        <button class="btn btn-sm w-100 btn-warning font-weight-bold" id="btnFind" data-id="' . $data['trans_id'] . '" data-trans="' . $data['trans_number'] . '">Lacak Pengiriman</button>
                                    </div>
                    ';
                } else if ($data['trans_stat'] == 4) {
                    $output .= '
                                    <div class="col-lg-3 text-right">
                                        <button class="btn btn-sm w-100 btn-warning font-weight-bold" id="btnAccept" data-id="' . $data['trans_id'] . '" data-trans="' . $data['trans_number'] . '">Pesanan Diterima</button>
                                    </div>
                    ';
                }

                $output .= '
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            $output .= '
            <div class="col-12 text-center">
                <img src=" ' . base_url('assets/img/frontend/trans-empty.png') . '" width="200px">
                <h4 class="mt-2">Oops, nggak ada transaksi</h4>
                <p>Yuk, isi dengan barang-barang impianmu!</p>
                <a href="' . base_url('ecommerce/product') . '" class="btn btn-success" >Mulai Belanja</a>
            </div>
            ';
        }

        return $output;
    }
}
