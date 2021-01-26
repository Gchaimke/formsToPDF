<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Admin_model');
        $this->load->model('Companies_model');
        $this->load->model('Production_model');
    }

    public function index($msg = '')
    {
        $data = array();
        $this->Admin_model->add_field('users', 'companies_list'); //one time update db to add new field
        $role = $this->session->userdata['logged_in']['role'];
        $data['users'] = $this->Users_model->getUsers();
        $data['message_display'] = $msg;
        $this->load->view('header');
        $this->load->view('main_menu');
        if ($role != "Admin" && $role != 'Manager') {
            header("location: /");
        } else {
            $this->load->view('users/manage', $data);
        }
        $this->load->view('footer');
    }

    public function create()
    {
        $data = array();
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin" || $role == 'Manager') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('view_name', 'view_name', 'trim|xss_clean');
            $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['settings'] = $this->Admin_model->getSettings();
                $data['role'] = $role;
                $this->load->view('header');
                $this->load->view('main_menu');
                $this->load->view('users/create', $data);
                $this->load->view('footer');
            } else {
                $data = array(
                    'name' => $this->input->post('name'),
                    'view_name' => $this->input->post('view_name'),
                    'role' => $this->input->post('role'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'email' => $this->input->post('email')
                );
                $result = $this->Users_model->registration_insert($data);
                if ($result == TRUE) {
                    $this->index('User Registration Successfully !');
                } else {
                    $data['message_display'] = 'Username already exist!';
                    $this->load->view('header');
                    $this->load->view('main_menu');
                    $this->load->view('users/create', $data);
                    $this->load->view('footer');
                }
            }
        } else {
            header("location: /");
        }
    }

    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Users_model->deleteUser($id);
        }
    }

    public function edit($id = '')
    {
        $role = $this->session->userdata['logged_in']['role'];
        $data['companies'] = $this->Companies_model->getCompanies();
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('view_name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('role', 'Role', 'trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
        $this->form_validation->set_rules('companies_list[]', 'companies_list', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $data['user'] =  $this->Users_model->getUser($id)[0];
            $data['settings'] = $this->Admin_model->getSettings();
            $data['role'] = $role;
            $user_role = $data['user']['role'];
            $user_id = $data['user']['id'];
            $this->load->view('header');
            $this->load->view('main_menu');
            if ($role != "Admin" && $user_role == "Admin") {
                header("location: /");
            } else if ($role != "Admin" && $user_role == "Manager" && $id != $user_id) {
                header("location: /");
            }
            $this->load->view('users/edit', $data);
            $this->load->view('footer');
        } else {
            $companies_list = json_encode($this->input->post('companies_list[]'));
            if ($role == "Admin") {
                $sql = array(
                    'id' => $this->input->post('id'),
                    'name' => $this->input->post('name'),
                    'view_name' => $this->input->post('view_name'),
                    'role' => $this->input->post('role'),
                    'email' => $this->input->post('email'),
                    'companies_list' => $companies_list
                );
            } else {
                $sql = array(
                    'id' => $this->input->post('id'),
                    'view_name' => $this->input->post('view_name'),
                    'email' => $this->input->post('email'),
                    'companies_list' => $companies_list
                );
            }
            if ($this->input->post('password') != '') {
                $sql += array('password' => $this->input->post('password'));
            }
            print_r($this->Users_model->editUser($sql));
        }
    }

    public function login()
    {
        $data = array();
        $data['response'] = '';
        if (!$this->db->table_exists('users')) {
            $this->Users_model->create();
            $this->Admin_model->create();
            $this->Companies_model->create();
            $this->Production_model->create();
            $this->Contacts_model->create();
            $this->Tickets_model->create();
            $data['response'] .= "New DB created!<br> username:Admin <br> Password:Admin.";
        }
        $this->load->view('users/login', $data);
        $this->load->view('footer');
    }

    public function user_login_process()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            if (isset($this->session->userdata['logged_in'])) {
                header("location: /");
            } else {
                $this->load->view('users/login');
                $this->load->view('footer');
            }
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'password' => $this->input->post('password')
            );
            $result = $this->Users_model->login($data);
            if ($result == true) {
                $name = $this->input->post('name');
                $result = $this->Users_model->read_user_information($name);
                if ($result != false) {
                    $session_data = array(
                        'id' => $result[0]->id,
                        'name' => $result[0]->name,
                        'view_name' => $result[0]->view_name,
                        'role' => $result[0]->role,
                        'email' => $result[0]->email
                    );
                    $this->session->set_userdata('logged_in', $session_data);
                    header("location: /tickets");
                }
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('/users/login', $data);
                $this->load->view('footer');
            }
        }
    }

    public function logout()
    {
        $data = array();
        // Removing session data
        $sess_array = array(
            'name' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('users/login', $data);
        $this->load->view('footer');
    }

    public function get_verify()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $data = array(
            'name' => $this->input->post('name'),
            'password' => $this->input->post('password')
        );
        $result = $this->Users_model->login($data);
        if ($result == TRUE) {
            echo true;
        } else {
            echo false;
        }
    }
}
