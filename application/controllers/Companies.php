<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Companies extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Companies_model');
    }

    public function index($msg = '')
    {
        $data = array();
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        // get data from model
        $data['companies'] = $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('Companies/manage', $data);
        $this->load->view('footer');
    }

    // Validate and store checklist data in database
    public function create()
    {
        $msg = array();
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('logo', 'Logo', 'trim|xss_clean');
        $this->form_validation->set_rules('form_header', 'form_header', 'trim|xss_clean');
        $this->form_validation->set_rules('form_extra_filds', 'form_extra_filds', 'trim|xss_clean');
        $this->form_validation->set_rules('form_footer', 'form_footer', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('Companies/create');
            $this->load->view('footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'logo' => $this->input->post('logo'),
                'form_header' => $this->input->post('form_header'),
                'form_extra_filds' => $this->input->post('form_extra_filds'),
                'form_footer' => $this->input->post('form_footer')
            );
            $result = $this->Companies_model->addCompany($data);
            if ($result == TRUE) {
                $msg = 'Company added Successfully !';
                $this->index($msg);
            } else {
                $msg['message_display'] = 'Client already exist!';
                $this->load->view('header');
                $this->load->view('main_menu');
                $this->load->view('Companies/create', $msg);
                $this->load->view('footer');
            }
        }
    }

    public function edit($id = '',$msg='')
    {
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data = array();
        // Check validation for user input in form
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('logo', 'Logo', 'trim|xss_clean');
        $this->form_validation->set_rules('form_header', 'Form_header', 'trim|xss_clean');
        $this->form_validation->set_rules('form_extra_filds', 'Form_extra_filds', 'trim|xss_clean');
        $this->form_validation->set_rules('form_footer', 'Form_footer', 'trim|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $sql = array(
                'id' => $this->input->post('id'),                
                'name' => $this->input->post('name'),
                'logo' => $this->input->post('logo'),
                'form_header' => $this->input->post('form_header'),
                'form_extra_filds' => $this->input->post('form_extra_filds'),
                'form_footer' => $this->input->post('form_footer')
            );
            $this->Companies_model->editCompany($sql);
            $data['message_display'] = 'Comapny updated Successfully !';
        }
        $data['companies'] = $this->Companies_model->getCompanies($id);
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('Companies/edit', $data);
        $this->load->view('footer');
    }

    public function logo_upload()
    {
        // requires php5
        define('UPLOAD_DIR', 'Uploads/Companies/');
        $file_name = $_POST['company'] . "_logo";
        $img = $_POST['data'];
        if (preg_match('/^data:image\/(\w+);base64,/', $img, $type)) {
            $img = substr($img, strpos($img, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $img = base64_decode($img);
            if ($img === false) {
                echo 'base64_decode failed';
                throw new \Exception('base64_decode failed');
            }
        } else {
            echo 'did not match data URI with image data';
            throw new \Exception('did not match data URI with image data');
        }
        if (!file_exists(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0770, true);
        }
        $file = UPLOAD_DIR . $file_name . ".$type";
        $success = file_put_contents($file, $img);
        print $success ? $file : 'Unable to save the file.';
    }

    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Companies_model->deleteClient($id);
        }
    }
}
