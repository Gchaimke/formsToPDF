<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacts extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Contacts_model');
    }

    public function index($msg = '')
    {
        $data = array();
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data['companies'] = $this->Emails_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('companies/manage', $data);
        $this->load->view('footer');
    }

    public function create()
    {
        $msg = array();
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('logo', 'Logo', 'trim|xss_clean');
        $this->form_validation->set_rules('form_header', 'form_header', 'trim');
        $this->form_validation->set_rules('form_extra_filds', 'form_extra_filds', 'trim|xss_clean');
        $this->form_validation->set_rules('form_footer', 'form_footer', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('companies/create');
            $this->load->view('footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'logo' => $this->input->post('logo'),
                'form_header' => $this->input->post('form_header'),
                'form_extra_filds' => $this->input->post('form_extra_filds'),
                'form_footer' => $this->input->post('form_footer')
            );
            $result = $this->Emails_model->addCompany($data);
            if ($result == TRUE) {
                $msg = 'Company added Successfully';
                $this->index($msg);
            } else {
                $msg['message_display'] = 'Company with this name already exist';
                $this->load->view('header');
                $this->load->view('main_menu');
                $this->load->view('companies/create', $msg);
                $this->load->view('footer');
            }
        }
    }

    public function edit($id = '', $msg = '')
    {
        $this->load->dbforge();
        $col_name = 'view_filds';

        if (!$this->db->field_exists($col_name, 'companies')) {
            $fields = array($col_name => array('type' => 'TEXT', 'after' => 'logo'));
            $this->dbforge->add_column('companies', $fields);
            $sql = array(
                'id' => $this->input->post('id'),
            );
            $this->Emails_model->editCompany($sql);
        }

        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data = array();
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('logo', 'Logo', 'trim|xss_clean');
        $this->form_validation->set_rules('form_header', 'Form_header', 'trim');
        $this->form_validation->set_rules('view_filds[]', 'view_filds', 'trim');
        $this->form_validation->set_rules('form_extra_filds', 'Form_extra_filds', 'trim|xss_clean');
        $this->form_validation->set_rules('form_footer', 'Form_footer', 'trim|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $filds = json_encode($this->input->post('view_filds[]'));
            $sql = array(
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'logo' => $this->input->post('logo'),
                'view_filds' => $filds,
                'form_header' => $this->input->post('form_header'),
                'form_extra_filds' => $this->input->post('form_extra_filds'),
                'form_footer' => $this->input->post('form_footer')
            );
            $this->Emails_model->editCompany($sql);
            $data['message_display'] = ' Comapny updated Successfully';
        }
        $data['companies'] = $this->Emails_model->getCompanies($id);
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('companies/edit', $data);
        $this->load->view('footer');
    }



    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Emails_model->deleteCompany($id);
        }
    }
}
