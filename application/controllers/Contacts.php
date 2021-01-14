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
        $data['contacts'] = $this->Contacts_model->get();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('contacts/manage', $data);
        $this->load->view('footer');
    }

    public function create()
    {
        $msg = array();
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('company', 'company', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('contacts/create');
            $this->load->view('footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'company' => $this->input->post('company')
            );
            $result = $this->Contacts_model->add($data);
            if ($result == TRUE) {
                $msg = 'איש קשר הוסף בהצלחה';
                $this->index($msg);
            } else {
                $msg['message_display'] = 'איש קשר עם מייל כזה כבר קיים';
                $this->load->view('header');
                $this->load->view('main_menu');
                $this->load->view('contacts', $msg);
                $this->load->view('footer');
            }
        }
    }

    public function edit($id = '', $msg = '')
    {
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data = array();
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('company', 'company', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $sql = array(
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'company' => $this->input->post('company')
            );
            $this->Contacts_model->edit($sql);
            $data['message_display'] = 'איש קשר שונה בהצלחה';
            $this->index($data['message_display']);
        } else {
            $data['contacts'] = $this->Contacts_model->get($id)[0];
            $this->load->view('header');
            $this->load->view('main_menu');
            $this->load->view('contacts/edit', $data);
            $this->load->view('footer');
        }
    }



    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Contacts_model->delete($id);
        }
    }
}
