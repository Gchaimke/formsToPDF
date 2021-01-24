<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tickets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Admin_model');
        $this->load->model('Companies_model');
        $this->load->model('Production_model');
        $this->load->model('Tickets_model');
    }

    public function index()
    {
        $data = array();
        $user_role = $this->session->userdata['logged_in']['role'];
        $user_id = $this->session->userdata['logged_in']['id'];
        if($user_role=='User'){
            $data['tickets'] = $this->Tickets_model->get_all($user_id);
        }else{
            $data['tickets'] = $this->Tickets_model->get_all();
        }
        
        $data['users'] =  $this->Users_model->getusers();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('tickets/manage', $data);
        $this->load->view('footer');
    }

    public function uploader()
    {
        $user_id = $this->session->userdata['logged_in']['id'];
        $file_name = 'Uploads/tmp/' . $user_id . '/last_uploaded.xlsx';
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
        $user_id = $this->session->userdata['logged_in']['id'];
        if (!file_exists($upload_folder . '/' . $user_id)) {
            mkdir($upload_folder . '/' . $user_id, 0770, true);
        }
        $config = array(
            'upload_path' => $upload_folder . '/' . $user_id,
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
        $this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
        $this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
        $this->form_validation->set_rules('address', 'address', 'trim|xss_clean');
        $this->form_validation->set_rules('warehouse_num', 'warehouse_num', 'trim|xss_clean');
        if ($company_num != "") {
            $data = array(
                'client_num' =>  $this->input->post('client_num'),
                'client_name' =>  $this->input->post('client_name'),
                'address' =>  $this->input->post('address'),
                'warehouse_num' =>  $this->input->post('warehouse_num'),
                'company_id' => $company_num,
                'status' =>  'new'
            );
            if ($this->Tickets_model->add($data)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function update($id = "")
    {
        $this->form_validation->set_rules('user_id', 'user_id', 'trim|xss_clean');
        if ($id != "") {
            $data = array(
                'id' => $id,
                'creator_id' => $this->input->post('user_id')
            );
            if ($this->Tickets_model->update($data)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Tickets_model->delete($id);
        }
    }
}
