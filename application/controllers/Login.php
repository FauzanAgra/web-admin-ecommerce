<?php defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Users_model');
    }
    public function index()
    {
        $userdata = $this->session->userdata('userdata');

        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'login') {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $user = $this->Auth_model->check_users($username)->row_array();

                if ($user) {
                    //Cek Password
                    if (password_verify($password, $user['user_password'])) {
                        if ($user['user_stat'] == 1) {
                            //Cek Role
                            if ($user['user_role'] == 1) {
                                $ret->data = 'dashboard';
                            } else {
                                $ret->data = 'ecommerce';
                            }

                            //Set Session
                            $user['last_time'] = time();
                            $this->session->set_userdata('userdata', $user);
                            $this->session->set_userdata('loggedin', true);

                            //Pesan Ke User
                            $ret->stat = 1;
                            $ret->mesg = '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Login Success!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            ';
                        } else {
                            $ret->mesg = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Please contact Customer Service !
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            ';
                        }
                    } else {
                        $ret->mesg = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Passwords do not match!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        ';
                    }
                } else {
                    $ret->mesg = '
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Username is not registered!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    ';
                }
            }
            echo json_encode($ret);
        } else {
            if (!isset($userdata)) {
                $data['title'] = 'Login';
                $data['script'] = 'auth/script-login.php';
                $this->load->view('auth/login.php', $data);
            } else {
                redirect(base_url());
            }
        }
    }
    function logout()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'logout') {
                $this->session->unset_userdata('userdata');
                $this->session->unset_userdata('loggedin');
                $ret->stat = 1;
            }
            echo json_encode($ret);
        }
    }

    function registrasi()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'regis') {
                $data = $this->input->post();
                $params = array(
                    'user_name' => htmlspecialchars($data['name-user']),
                    'user_full_name' => htmlspecialchars($data['full-name-user']),
                    'user_password' => password_hash($data['password-user'], PASSWORD_DEFAULT),
                    'user_phone' => htmlspecialchars($data['phone-user']),
                    'user_address' => htmlspecialchars($data['address-user']),
                    'user_datetime' => date('Y-m-d H:i:s'),
                    'user_role' => 2,
                    'user_image' => 'default.png',
                    'user_stat' => 1
                );

                $stat = $this->Users_model->insert_user($params);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Registrasi Berhasil';
                }
            }

            echo json_encode($ret);
        } else {
            if (!isset($userdata)) {
                $data['title'] = 'Registrasi';
                $data['script'] = 'auth/script-registrasi.php';
                $this->load->view('auth/registrasi.php', $data);
            } else {
                redirect(base_url());
            }
        }
    }
}
