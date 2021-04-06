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
                $data =  $this->Trans_model->get_trans_user($id_user);
                $show_data = $this->show_trans_user($data);
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

    function show_trans_user($data)
    {
        // $output = '';

        // foreach ($data as $d) {
        //     $output = '

        //     ';
        // }
    }
}
