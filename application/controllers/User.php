<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function index()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            date_default_timezone_set("Asia/Jakarta");

            $action =  $this->input->post('action');
            if ($action == 'load') {
                $columns = array(
                    '0' => 'user_id'
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
                $datas = $this->Users_model->get_all_users($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Users_model->get_count_users($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            } else if ($action == 'insert') {
                $data = $this->input->post();
                $image = $this->input->post('image-user');
                $params = array(
                    'user_full_name' => htmlspecialchars($data['name-full-user']),
                    'user_name' => htmlspecialchars($data['name-user']),
                    'user_password' => password_hash($data['password-user'], PASSWORD_DEFAULT),
                    'user_phone' => htmlspecialchars($data['phone-user']),
                    'user_address' => htmlspecialchars($data['address-user']),
                    'user_datetime' => date('Y-m-d H:i:s'),
                    'user_role' => htmlspecialchars($data['role-user']),
                    'user_image' => $image,
                    'user_stat' => 1
                );

                $user_id = $data['id-user'];

                if ($user_id == '') {
                    $ids = $this->Users_model->save($params);
                    if ($ids) {
                        $path = FCPATH . 'assets/img/users/';
                        $config['image_library'] = 'gd2';
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->input->post('image-user') != 'undefined') {
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
                                    $data = $this->Users_model->get_image($ids);
                                    if ($data && $data['user_id']) {
                                        $params = array(
                                            'user_image' => $raw_photo
                                        );
                                        if (!empty($data['user_image'])) {
                                            if (file_exists($path . $data['user_image'])) {
                                                unlink($path . $data['puser_image']);
                                            }
                                        }
                                        $stat = $this->Users_model->update_user($ids, $params);
                                        if ($stat) {
                                            $ret->stat = 1;
                                            $ret->mesg = "Data Berhasil Terinputkan";
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
                        $ret->mesg = 'Gagal Insert Data';
                    }
                } else {
                    if ($params['user_image']) {
                        $this->Users_model->update_user($data['id-user'], $params);
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
                                    $data = $this->Users_model->get_image($data['id-user']);
                                    if ($data && $data['user_id']) {
                                        $params = array(
                                            'user_image' => $raw_photo
                                        );
                                        if (!empty($data['user_image'])) {
                                            if (file_exists($path . $data['user_image'])) {
                                                unlink($path . $data['user_image']);
                                            }
                                        }
                                        $stat = $this->Users_model->update_user($data['user_id'], $params);
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
                }
            }
            // else if ($action == 'deactive') {
            //     $id_product = $this->input->post('id-product');
            //     $status = array('product_stat' => 0);
            //     $stat = $this->Products_model->update_stat_deactive($id_product, $status);
            //     if ($stat) {
            //         $ret->stat = 1;
            //         $ret->mesg = 'Data Berhasil di Update';
            //     }
            // } else if ($action == 'active') {
            //     $id_product = $this->input->post('id-product');
            //     $status = array('product_stat' => 1);
            //     $stat = $this->Products_model->update_stat_active($id_product, $status);
            //     if ($stat) {
            //         $ret->stat = 1;
            //         $ret->mesg = 'Data Berhasil di Update';
            //     }
            // } 
            else if ($action == 'edit') {
                $id_user = $this->input->post('id-user');
                $data = $this->Users_model->get_where_user($id_user);
                if ($data) {
                    $ret->stat = 1;
                    $ret->data = $data;
                }
            } else if ($action == 'delete') {
                $id_user = $this->input->post('id-user');
                $data = $this->Users_model->get_image($id_user);
                $path = FCPATH . 'assets/img/users/';
                if ($data && $data['user_image'] != 'default.png') {
                    unlink($path . $data['product_image']);
                    $stat = $this->Users_model->delete_user($id_user);
                    if ($stat) {
                        $ret->stat = 1;
                        $ret->mesg = 'Hapus Data Berhasil';
                    }
                } else {
                    $stat = $this->Users_model->delete_user($id_user);
                    if ($stat) {
                        $ret->stat = 1;
                        $ret->mesg = 'Hapus Data Berhasil';
                    }
                }
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['role'] = $this->db->get('roles')->result_array();
            $data['title'] = 'User';
            $data['content'] = 'admin/user/user.php';
            $data['script'] = 'admin/user/script-user.php';
            $this->load->view('layout/index.php', $data);
        }
    }
}
