<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Companies extends CI_Controller
{
    private $user;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Companies_model');
        if (isset($this->session->userdata['logged_in'])) {
            $this->user = $this->session->userdata['logged_in'];
            if($this->user['role']!="Admin" && $this->user['role']!="Manager"){
                header("location: /");
            }
        } else{
            header("location: /users/logout");
        }
    }

    public function index($msg = '')
    {
        $data = array();
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data['companies'] = $this->Companies_model->getCompanies();
        $data['role'] = $this->user['role'];
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
            $result = $this->Companies_model->addCompany($data);
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
                $col_name => json_encode($this->form_filds())
            );
            $this->Companies_model->editCompany($sql);
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
            $this->Companies_model->editCompany($sql);
            $data['message_display'] = ' Comapny updated Successfully';
        }
        $data['view_filds'] = $this->form_filds();
        $data['companies'] = $this->Companies_model->getCompanies($id);
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('companies/edit', $data);
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
            $type = strtolower($type[1]);

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
            copy('application/index.html',UPLOAD_DIR.'index.html');
        }
        $file = UPLOAD_DIR . $file_name . ".$type";
        $success = file_put_contents($file, $img);
        chmod($file, 0664);
        print $success ? $file : 'Unable to save the file.';
    }

    function form_filds()
    {
        $filds = '{
            "start_time_column":"1",
            "end_time_column":"1",
            "client_num_column":"1",
            "issue_num_column":"1",
            "issue_kind_column":"1",
            "client_name_column":"1",
            "place_column":"1",
            "city_column":"1",
            "manager_column":"1",
            "contact_name_column":"1",
            "activity_text_column":"1",
            "checking_text_column":"1",
            "summary_text_column":"1",
            "remarks_text_column":"1",
            "recommendations_text_column":"1",
            "emails":"1",
            "files_column":"1",
            "details_column":"1",
            "old_serial":"1",
            "new_serial":"1"
        }';
        return json_decode($filds);
    }

    public function delete()
    {
        $role = ($this->session->userdata['logged_in']['role']);
        if ($role == "Admin") {
            $id = $_POST['id'];
            $this->Companies_model->deleteCompany($id);
        }
    }
}
