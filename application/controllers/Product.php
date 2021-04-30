<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
        $this->load->model('Category_model');
    }

    public function index()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action =  $this->input->post('action');
            if ($action == 'load') {
                $columns = array(
                    '0' => 'product_id'
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
                $datas = $this->Products_model->get_all_products($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Products_model->get_count_products($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            } else if ($action == 'insert') {
                $data = $this->input->post();
                $image = $this->input->post('image-product');
                $params = array(
                    'product_id' => $data['id-product'],
                    'product_name' => $data['name-product'],
                    'product_price' => $data['price-product'],
                    'product_category' => $data['category-product'],
                    'product_stat' => $data['stat-product'],
                    'product_image' => $image
                );

                $product_id = $data['id-product'];

                if ($product_id == '') {
                    $ids = $this->Products_model->save($params);
                    if ($ids) {
                        $path = FCPATH . 'assets/img/products/';
                        $config['image_library'] = 'gd2';
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->input->post('image-product') != 'undefined') {
                            if ($this->upload->do_upload('image-product')) {
                                $upload = $this->upload->data();
                                $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                                $old_name = $upload['full_path'];
                                $new_name = $path . $raw_photo;
                                if (rename($old_name, $new_name)) {
                                    //compress
                                    $compress['image_library'] = 'gd2';
                                    $compress['source_image'] = 'assets/img/products/' . $raw_photo;
                                    $compress['create_thumb'] = FALSE;
                                    $compress['maintain_ratio'] = TRUE;
                                    $compress['width'] = 640;
                                    $compress['new_image'] = 'assets/img/products/' . $raw_photo;
                                    $this->load->library('image_lib', $compress);
                                    $this->image_lib->resize();
                                    $data = $this->Products_model->get_image($ids);
                                    if ($data && $data['product_id']) {
                                        $params = array(
                                            'product_image' => $raw_photo
                                        );
                                        if (!empty($data['product_image'])) {
                                            if (file_exists($path . $data['product_image'])) {
                                                unlink($path . $data['product_image']);
                                            }
                                        }
                                        $stat = $this->Products_model->update_product($ids, $params);
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
                    if ($params['product_image']) {
                        $this->Products_model->update_product($data['id-product'], $params);
                        $ret->stat = 1;
                        $ret->mesg = "Update Berhasil";
                    } else {
                        $path = FCPATH . 'assets/img/products/';
                        $config['image_library']    = 'gd2';
                        $config['upload_path'] = $path;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->input->post('image-product') != "undefined") {
                            if ($this->upload->do_upload('image-product')) {
                                $upload = $this->upload->data();
                                $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                                $old_name = $upload['full_path'];
                                $new_name = $path . $raw_photo;
                                if (rename($old_name, $new_name)) {
                                    //compress
                                    $compress['image_library'] = 'gd2';
                                    $compress['source_image'] = 'assets/img/products/' . $raw_photo;
                                    $compress['create_thumb'] = FALSE;
                                    $compress['maintain_ratio'] = TRUE;
                                    $compress['width'] = 640;
                                    $compress['new_image'] = 'assets/img/products/' . $raw_photo;
                                    $this->load->library('image_lib', $compress);
                                    $this->image_lib->resize();
                                    $data = $this->Products_model->get_image($data['id-product']);
                                    if ($data && $data['product_id']) {
                                        $params = array(
                                            'product_image' => $raw_photo
                                        );
                                        if (!empty($data['product_image'])) {
                                            if (file_exists($path . $data['product_image'])) {
                                                unlink($path . $data['product_image']);
                                            }
                                        }
                                        $stat = $this->Products_model->update_product($data['product_id'], $params);
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
            } else if ($action == 'deactive') {
                $id_product = $this->input->post('id-product');
                $status = array('product_stat' => 0);
                $stat = $this->Products_model->update_stat_deactive($id_product, $status);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Berhasil di Update';
                }
            } else if ($action == 'active') {
                $id_product = $this->input->post('id-product');
                $status = array('product_stat' => 1);
                $stat = $this->Products_model->update_stat_active($id_product, $status);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Berhasil di Update';
                }
            } else if ($action == 'edit') {
                $id_product = $this->input->post('id-product');
                $data = $this->Products_model->get_where_product($id_product);
                if ($data) {
                    $ret->stat = 1;
                    $ret->data = $data;
                }
            } else if ($action == 'delete') {
                $id_product = $this->input->post('id-product');
                $data = $this->Products_model->get_image($id_product);
                $path = FCPATH . 'assets/img/products/';
                if ($data && $data['product_image']) {
                    unlink($path . $data['product_image']);
                    $stat = $this->Products_model->delete_product($id_product);
                    if ($stat) {
                        $ret->stat = 1;
                        $ret->mesg = 'Hapus Data Berhasil';
                    }
                }
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['category'] = $this->db->get('categories')->result_array();
            $data['title'] = 'Produk';
            $data['content'] = 'admin/product/product.php';
            $data['script'] = 'admin/product/script-product.php';
            $this->load->view('layout/admin/index.php', $data);
        }
    }

    function category()
    {
        if ($this->input->post() && $this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            $action = $this->input->post('action');
            if ($action == 'load') {
                $columns = array(
                    '0' => 'category_id'
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
                $datas = $this->Category_model->get_all_categories($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Category_model->get_count_categories($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            } else if ($action == 'deactive') {
                $id_category = $this->input->post('id-category');
                $status = array('category_stat' => 0);
                $stat = $this->Category_model->update_stat_deactive($id_category, $status);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Berhasil di Update';
                }
            } else if ($action == 'active') {
                $id_category = $this->input->post('id-category');
                $status = array('category_stat' => 1);
                $stat = $this->Category_model->update_stat_active($id_category, $status);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Berhasil di Update';
                }
            } else if ($action == 'delete') {
                $id_category = $this->input->post('id-category');
                $stat = $this->Category_model->delete_category($id_category);
                if ($stat) {
                    $ret->stat = 1;
                    $ret->mesg = 'Data Kategori berhasil di Hapus';
                }
            } else if ($action == 'edit') {
                $id_category = $this->input->post('id-category');
                $data = $this->Category_model->get_where_category($id_category);
                if ($data) {
                    $ret->stat = 1;
                    $ret->data = $data;
                }
            } else if ($action == 'insert') {
                $data =  $this->input->post();
                $params = array(
                    'category_name' => $data['name-category'],
                    'category_stat' => $data['stat-category']
                );

                $id_category = $data['id-category'];
                if ($id_category == '') {
                    $stat = $this->Category_model->insert_category($params);
                    if ($stat) {
                        $ret->stat = 1;
                        $ret->mesg = 'Data Kategori Berhasil di Input';
                    }
                } else {
                    $stat = $this->Category_model->update_category($id_category, $params);
                    if ($stat) {
                        $ret->stat = 1;
                        $ret->mesg = 'Data Kategori Berhasil di Update';
                    }
                }
            }
            echo json_encode($ret);
        } else {
            $data['profile'] = $this->session->userdata('userdata');
            $data['title'] = 'Kategori';
            $data['content'] = 'admin/product/category.php';
            $data['script'] = 'admin/product/script-category.php';
            $this->load->view('layout/admin/index.php', $data);
        }
    }
}
