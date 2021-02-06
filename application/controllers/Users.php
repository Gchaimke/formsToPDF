<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    private $user;
    private $user_roles;
    private $languages;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Admin_model');
        $this->load->model('Companies_model');
        $this->load->model('Production_model');
        $language = $this->config->item('language');
        if (isset($this->session->userdata['logged_in'])) {
            $this->user = $this->session->userdata['logged_in'];
            $language = $this->user['language'];
        }
        $this->lang->load('main', $language);
        $this->user_roles = array("Admin", "Manager", "User");
        $this->languages = array("english", "hebrew");
    }

    public function index($msg = '')
    {
        if (isset($this->user) && $this->user['role'] == "User") {
            header("location: /");
        }
        $data = array();
        $data['users'] = $this->Users_model->getUsers();
        $data['message_display'] = $msg;
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('users/manage', $data);
        $this->load->view('footer');
    }

    public function create()
    {
        $data = array();
        if ($this->user['role'] != "Admin" && $this->user['role'] != 'Manager') {
            header("location: /");
        }
        $this->form_validation->set_rules('name', lang('username'), 'trim|required|xss_clean|is_unique[users.name]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('view_name', 'view_name', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['user_roles'] = $this->user_roles;
            $data['role'] = $this->user['role'];
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
    }

    public function delete()
    {
        if ($this->user['role'] == "Admin") {
            $id = $_POST['id'];
            $this->Users_model->deleteUser($id);
        }
    }

    public function edit($id = '')
    {
        $data['companies'] = $this->Companies_model->getCompanies();
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('view_name', 'Name', 'trim|xss_clean');
        $this->form_validation->set_rules('role', 'Role', 'trim|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'email', 'trim|xss_clean');
        $this->form_validation->set_rules('language', 'language', 'trim|xss_clean');
        $this->form_validation->set_rules('companies_list[]', 'companies_list', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $data['user'] =  $this->Users_model->getUser($id)[0];
            $data['user_roles'] = $this->user_roles;
            $data['languages'] = $this->languages;
            $data['role'] = $this->user['role'];
            $user_role = $data['user']['role'];
            $user_id = $data['user']['id'];
            $this->load->view('header');
            $this->load->view('main_menu');
            if ($this->user['role'] != "Admin" && $user_role == "Admin") {
                header("location: /");
            } else if ($this->user['role'] != "Admin" && $user_role == "Manager" && $id != $user_id) {
                header("location: /");
            }
            $this->load->view('users/edit', $data);
            $this->load->view('footer');
        } else {
            $companies_list = json_encode($this->input->post('companies_list[]'));
            if ($this->user['role'] == "Admin") {
                $sql = array(
                    'id' => $this->input->post('id'),
                    'name' => $this->input->post('name'),
                    'view_name' => $this->input->post('view_name'),
                    'role' => $this->input->post('role'),
                    'email' => $this->input->post('email'),
                    'language' => $this->input->post('language'),
                    'companies_list' => $companies_list
                );
            } else {
                $sql = array(
                    'id' => $this->input->post('id'),
                    'view_name' => $this->input->post('view_name'),
                    'email' => $this->input->post('email'),
                    'language' => $this->input->post('language')
                );
            }
            if ($this->input->post('password') != '') {
                $sql += array('password' => $this->input->post('password'));
            }
            print_r($this->Users_model->editUser($sql));
        }
        $this->set_session_data($this->user['name']);
    }

    public function user_login_process()
    {
        $this->check_blacklist_ip();
        $data = array();
        if (!$this->db->table_exists('users')) {
            $this->Users_model->create();
            $this->Admin_model->create();
            $this->Companies_model->create();
            $this->Production_model->create();
            $this->Contacts_model->create();
            $this->Tickets_model->create();
            $data['error_message'] .= "New DB created!<br> username:Admin <br> Password:Admin.";
        }
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
            $sql = array(
                'name' => $this->input->post('name'),
                'password' => $this->input->post('password')
            );
            $result = $this->Users_model->login($sql);
            if ($result == true) {
                $this->set_session_data($this->input->post('name'));
                header("location: /tickets");
            } else {
                $data['error_message'] = 'Invalid Username or Password';
                $this->load->view('/users/login', $data);
                $this->load->view('footer');
            }
        }
    }

    function set_session_data($user_name = '')
    {
        if ($this->Admin_model->getSettings()[0]['language'] != '') {
            $sys_lang = $this->Admin_model->getSettings()[0]['language'];
        } else {
            $sys_lang = $this->config->item('language');
        }
        $result = $this->Users_model->read_user_information($user_name);
        if ($result != false) {
            $language = ($result[0]->language == 'system') ? $sys_lang : $result[0]->language;
            $session_data = array(
                'id' => $result[0]->id,
                'name' => $result[0]->name,
                'view_name' => $result[0]->view_name,
                'role' => $result[0]->role,
                'email' => $result[0]->email,
                'language' => $language
            );
            $this->session->set_userdata('logged_in', $session_data);
            session_write_close();
        }
    }

    public function logout()
    {
        $data = array();
        // Removing session data
        $this->session->sess_destroy();
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('users/login', $data);
        $this->load->view('footer');
    }

    function check_blacklist_ip()
    {
        $blockIP = array("127.0.0.2", "192.168.0.2");
        if (in_array($this->get_client_ip(), $blockIP)) {
            $heading = 'Yor hardware are blocket for 5 invalid logins';
            $message = '<p>You can\'t use this site any more</p>';
            show_error($message, 404, $heading);
            $this->log_data($this->get_client_ip() . ' are blocked out!', 1);
            exit();
        } else {
            $this->log_data($this->get_client_ip() . ' view your site.');
        }
    }

    function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function log_data($msg, $level = 0)
	{
		if (!file_exists('application/logs/admin')) {
			mkdir('application/logs/admin', 0770, true);
		}
		$level_arr = array('INFO', 'ERROR');
		$log_file = APPPATH . "logs/admin/" . date("m-d-Y") . ".log";
		$fp = fopen($log_file, 'a');
		fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> ". $msg . PHP_EOL);
		fclose($fp);
	}
}
