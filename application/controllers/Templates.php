<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Templates extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Templates_model');
        $this->load->model('Clients_model');
    }

    public function index($data = '')
    {
        $data = array();
        // get data from model
        $data['projects'] = $this->Templates_model->getTemplates();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('templates/manage_templates', $data);
        $this->load->view('footer');
    }

    // Validate and store checklist data in database
    public function add_template()
    {
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('client', 'Client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('project', 'Project', 'trim|required|xss_clean');
        $this->form_validation->set_rules('data', 'Data', 'trim|xss_clean');
        $this->form_validation->set_rules('template', 'Template', 'trim|xss_clean');
        $this->form_validation->set_rules('scans', 'Scans', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['js_to_load'] = array("add_template.js");
            $data['clients'] = $this->Clients_model->getClients();
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('templates/add_template', $data);
            $this->load->view('footer');
        } else {
            $data = array(
                'client' => $this->input->post('client'),
                'project' => $this->input->post('project'),
                'data' => $this->input->post('data'),
                'template' => $this->input->post('template'),
                'scans' => $this->input->post('scans')
            );
            $result = $this->Templates_model->addTemplate($data);
            if ($result == TRUE) {
                $data['message_display'] = 'Template added Successfully !';
                $this->index($data);
            } else {
                $data['js_to_load'] = array("add_template.js");
                $data['message_display'] = 'Template already exist!';
                $data['clients'] = $this->Clients_model->getClients();
                $this->load->view('header');
                $this->load->view('main_menu');
                $this->load->view('templates/add_template', $data);
                $this->load->view('footer');
            }
        }
    }

    public function edit_template($id = '')
    {
        $data = array();
        // Check validation for user input in form
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('client', 'Client', 'trim|xss_clean');
        $this->form_validation->set_rules('project', 'Project', 'trim|xss_clean');
        $this->form_validation->set_rules('data', 'Data', 'trim|xss_clean');
        $this->form_validation->set_rules('template', 'Template', 'trim|xss_clean');
        $this->form_validation->set_rules('scans', 'Scans', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['clients'] = $this->Clients_model->getClients();
            $data['project'] =  $this->Templates_model->getTemplate($id);
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('templates/edit_template', $data);
            $this->load->view('footer');
        } else {
            $sql = array(
                'id' => $this->input->post('id'),
                'data' => $this->input->post('data'),
                'template' => $this->input->post('template'),
                'scans' => $this->input->post('scans')
            );
            $data['message_display'] = $this->Templates_model->editTemplate($sql);
            $data['message_display'] .= ' Project edited Successfully !';
            $this->index($data);
        }
    }

    public function delete_template()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Templates_model->deleteTemplate($id);
        }
    }
}
