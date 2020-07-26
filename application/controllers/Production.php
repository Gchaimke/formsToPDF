<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Production_model');
        $this->load->model('Companies_model');
        $this->load->model('Templates_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data = array();
        // get data from model
        $data['companies'] = $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/view_companies', $data);
        $this->load->view('footer');
    }

    public function new_form()
    {
        $data = array();
        $this->load->view('header');
        $this->load->view('main_menu', $data);
        $this->load->view('footer');
    }


    public function save_form()
    {
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('data', 'Data', 'trim|xss_clean');
        $this->form_validation->set_rules('log', 'Log', 'trim|xss_clean');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|xss_clean');
        $this->form_validation->set_rules('assembler', 'assembler', 'trim|xss_clean');
        $this->form_validation->set_rules('qc', 'Qc', 'trim|xss_clean');
        $this->form_validation->set_rules('scans', 'Scans', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $data = array(
                'data' =>  $this->input->post('data'),
                'log' =>  $this->input->post('log'),
                'progress' => $this->input->post('progress'),
                'assembler' => $this->input->post('assembler'),
                'qc' => $this->input->post('qc'),
                'scans' => $this->input->post('scans')
            );
            $this->Production_model->editForm($data);
            echo 'Form saved successfully!';
        }
    }

    public function trashForm()
    {
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $this->form_validation->set_rules('project', 'Project', 'trim|xss_clean');
        $this->form_validation->set_rules('serial', 'Serial', 'trim|xss_clean');
        $project = $this->input->post('project');
        $serial = $this->input->post('serial');
        $data = array(
            'id' =>  $this->input->post('id'),
            'project' => $project
        );
        $this->Production_model->move_to_trash($data);
        $this->log_data("trashed '$project' form with serial '$serial'",2);
    }

    public function save_photo()
    {
        // requires php5
        define('UPLOAD_DIR', 'Uploads/');
        $folder = $_POST['project'];
        $company = $_POST['company'];
        $serial = $_POST['serial'];
        $num = $_POST['num'];
        $upload_folder = UPLOAD_DIR . $company . "/" . $folder . "/" . $serial;
        $img = $_POST['data'];
        if (preg_match('/^data:image\/(\w+);base64,/', $img, $type)) {
            $img = substr($img, strpos($img, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }

            $img = base64_decode($img);

            if ($img === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        if (!file_exists($upload_folder)) {
            mkdir($upload_folder, 0770, true);
        }
        $file = $upload_folder . "/" . $serial . "_" . $num . ".$type";
        if (!file_exists($file)) {
            $success = file_put_contents($file, $img);
        } else {
            $num++;
            $file = $upload_folder . "/" . $serial . "_" . $num . ".$type";
            $success = file_put_contents($file, $img);
        }
        if (!file_exists("C:\Program Files\Ampps\www\assets\exec\pngquanti.exe")) {
            //shell_exec('"C:\Program Files\Ampps\www\assets\exec\pngquanti.exe" --ext .jpeg --speed 5 --nofs --force ' . escapeshellarg($file));
        }
        print $success ? $file : 'Unable to save the file.';
    }


    public function delete_photo()
    {
        $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean');
        
        if ($this->form_validation->run() == TRUE) {
            $photo = $this->input->post('photo');
            // Use unlink() function to delete a file  
            if (!unlink($_SERVER["DOCUMENT_ROOT"] . $photo)) {
                echo ($_SERVER["DOCUMENT_ROOT"] . $photo . " cannot be deleted due to an error");
            } else {
                echo ($_SERVER["DOCUMENT_ROOT"] . $photo . " has been deleted");
                $this->log_data('deleted '.$photo,3);
            }
        }
    }

    public function save_page2pdf()
    {
        $url = $_POST['url'];
        $cookie = $_POST['cookie'];
        $html2pdf = '"' . getcwd() . '\assets\exec\html2pdf\wkhtmltopdf.exe" ';
        exec($html2pdf . ' ' . $url . ' --cookie "ci_session" ' . $cookie . ' "' . getcwd() . '\test.pdf"');
        echo "ok";
    }

    public function log_data($msg,$level=0)
    {
        if (!file_exists('application/logs/admin')) {
			mkdir('application/logs/admin', 0770, true);
		}
		$level_arr = array('INFO','CREATE','TRASH','DELETE');
        $user = $this->session->userdata['logged_in']['name'];
        $log_file = APPPATH . "logs/admin/" . date("m-d-Y") . ".log";
        $fp = fopen($log_file, 'a'); //opens file in append mode  
        fwrite($fp, $level_arr[$level]." - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
        fclose($fp);
    }
}
