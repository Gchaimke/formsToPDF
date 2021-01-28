<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tickets extends CI_Controller
{
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Admin_model');
        $this->load->model('Companies_model');
        $this->load->model('Production_model');
        $this->load->model('Tickets_model');
        if (isset($this->session->userdata['logged_in'])) {
            $this->user = $this->session->userdata['logged_in'];
        } else {
            header("location: /users/logout");
        }
    }

    public function index()
    {
        $data = array();
        $data['creator'] = isset($_GET['creator']) ?  $_GET['creator'] : '';
        $data['company'] = isset($_GET['company']) ? $_GET['company'] : '';
        $data['city'] = isset($_GET['city']) ? $_GET['city'] : '';
        $data['status'] = isset($_GET['status']) ? $_GET['status'] : '';
        if ($this->user['role'] == 'User') {
            $data['tickets'] = $this->Tickets_model->get_all($this->user['id'], $data['company'], $data['city'], $data['status']);
        } else {
            $data['tickets'] = $this->Tickets_model->get_all($data['creator'], $data['company'], $data['city'], $data['status']);
        }
        $data['users'] =  $this->Users_model->getusers();
        $data['companies'] =  $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('tickets/manage', $data);
        $this->load->view('footer');
    }

    public function uploader()
    {
        $file_name = 'Uploads/tmp/' . $this->user['id'] . '/last_uploaded.xlsx';
        if (!file_exists($file_name)) {
            $file_name = '';
        }
        $data = array();
        $this->load->view('header');
        $this->load->view('main_menu');
        include_once APPPATH . 'third_party/SimpleXLSX.php';
        if ($file_name != '') {
            if ($xlsx = SimpleXLSX::parse($file_name)) {
                $data['xlsx'] = $xlsx;
                $data['companies'] = $this->Companies_model->getCompanies();
                $this->load->view('tickets/import', $data);
            } else {
                echo SimpleXLSX::parseError();
            }
        } else {
            $data['message_display'] = 'Upload File first';
            $this->load->view('tickets/import', $data);
        }
        $this->load->view('footer');
    }


    public function upload_xlsx($upload_folder = 'Uploads/tmp')
    {
        if (!file_exists($upload_folder . '/' . $this->user['id'])) {
            mkdir($upload_folder . '/' . $this->user['id'], 0770, true);
            copy('application/index.html', $upload_folder . '/' . $this->user['id'] . 'index.html');
        }
        $config = array(
            'upload_path' => $upload_folder . '/' . $this->user['id'],
            'file_name' => 'last_uploaded',
            'overwrite' => TRUE,
            'allowed_types' => 'xlsx|xls',
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('files')) {
            $data = array('upload_data' => $this->upload->data());
            echo  $data['upload_data']["file_name"];
        } else {
            $error = "error " . $this->upload->display_errors();
            echo $error;
        }
    }

    public function import($company_num = "")
    {
        $this->form_validation->set_rules('items_array', 'items_array', 'trim|xss_clean');
        $items = array();
        $tmp_s = '';
        $tmp_f = '';
        if (isset($_POST['items_array']) && $company_num != "") {
            foreach ($_POST['items_array'] as $line) {
                $sql_data = array();
                foreach ($line as $column) {
                    $sql_data += array($column['name'] => $column['value']);
                }
                $sql_data += array(
                    'company_id' => $company_num,
                    'status' =>  '0'
                );
                if ($this->Tickets_model->add($sql_data)) {
                    $tmp_s .= $sql_data['client_num'] . ',';
                } else {
                    $tmp_f .= $sql_data['client_num'] . ',';
                }
            }
            $items['inserted'] = explode(',', $tmp_s);
            $items['updated'] = explode(',', $tmp_f);
            print_r(json_encode($items));
        }
    }

    public function update($id = "")
    {
        $this->form_validation->set_rules('status', 'status', 'trim|xss_clean');
        $this->form_validation->set_rules('user_id', 'user_id', 'trim|xss_clean');
        if ($id != "") {
            $data = array(
                'id' => $id
            );
            if ($this->input->post('user_id') != '') {
                $data += array('creator_id' => $this->input->post('user_id'));
            }
            if ($this->input->post('status') != '') {
                $data += array('status' => $this->input->post('status'));
            }
            if ($this->Tickets_model->update($data)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function delete()
    {
        if ($this->user['role'] == "Admin") {
            $id = $_POST['id'];
            $this->Tickets_model->delete($id);
        }
    }
}
