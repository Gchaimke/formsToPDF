<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Admin_model');
        $this->load->model('Production_model');
        $this->load->model('Companies_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $data = array();
        // get data from model
        $data['companies'] = $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/dashboard', $data);
        $this->load->view('footer');
    }

    public function new_form()
    {
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/new_form');
        $this->load->view('footer');
    }


    public function add_form()
    {
        $user_name = $this->session->userdata['logged_in']['name'];
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('date', 'date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company', 'company', 'trim|xss_clean');
        $this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_num', 'issue_num', 'trim|xss_clean');
        $this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_kind', 'issue_kind', 'trim|xss_clean');
        $this->form_validation->set_rules('place', 'place', 'trim|xss_clean');
        $this->form_validation->set_rules('start_time', 'start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('end_time', 'end_time', 'trim|xss_clean');
        $this->form_validation->set_rules('manager', 'manager', 'trim|xss_clean');
        $this->form_validation->set_rules('contact_name', 'contact_name', 'trim|xss_clean');
        $this->form_validation->set_rules('activity_text', 'activity_text', 'trim|xss_clean');
        $this->form_validation->set_rules('checking_text', 'checking_text', 'trim|xss_clean');
        $this->form_validation->set_rules('summary_text', 'summary_text', 'trim|xss_clean');
        $this->form_validation->set_rules('remarks_text', 'remarks_text', 'trim|xss_clean');
        $this->form_validation->set_rules('recommendations_text', 'recommendations_text', 'trim|xss_clean');
        $this->form_validation->set_rules('trip_start_time', 'trip_start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('trip_end_time', 'trip_end_time', 'trim|xss_clean');
        $this->form_validation->set_rules('back_start_time', 'trip_start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('back_end_time', 'trip_end_time', 'trim|xss_clean');
        $this->form_validation->set_rules('client_sign', 'client_sign', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $data = array(
                'date' =>  $this->input->post('date'),
                'creator' =>  $user_name,
                'company' =>  $this->input->post('company'),
                'client_num' =>  $this->input->post('client_num'),
                'issue_num' => $this->input->post('issue_num'),
                'client_name' => $this->input->post('client_name'),
                'issue_kind' => $this->input->post('issue_kind'),
                'place' => $this->input->post('place'),
                'start_time' => $this->input->post('start_time'),
                'end_time' => $this->input->post('end_time'),
                'manager' => $this->input->post('manager'),
                'contact_name' => $this->input->post('contact_name'),
                'activity_text' => $this->input->post('activity_text'),
                'checking_text' => $this->input->post('checking_text'),
                'summary_text' => $this->input->post('summary_text'),
                'remarks_text' => $this->input->post('remarks_text'),
                'recommendations_text' => $this->input->post('recommendations_text'),
                'trip_start_time' => $this->input->post('trip_start_time'),
                'trip_end_time' => $this->input->post('trip_end_time'),
				'back_start_time' => $this->input->post('back_start_time'),
                'back_end_time' => $this->input->post('back_end_time'),
				'client_sign' => $this->input->post('client_sign')
            );
            $response =  $this->Production_model->add_form($data);
            if ($response > 0 || $response) {
                echo $response;
            } else {
                echo "דוח לא נשמר";
            }
        } else {
            echo "יש בעיה בנתונים שהזנתה, או שלא הזנתה כל הנתונים הנדרשים!";
        }
    }

	public function view_form($id = '1')
	{
		$data = array();
        $data['form_data'] = $this->Admin_model->getForm($id);
        $data['companies'] = $this->Companies_model->getCompanies();
		$this->load->view('header');
		$this->load->view('main_menu');
		$this->load->view('production/view_form', $data);
		$this->load->view('footer');
	}

	public function update_form()
	{
		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
		$this->form_validation->set_rules('company', 'company', 'trim|xss_clean');
		$this->form_validation->set_rules('date', 'date', 'trim|xss_clean');
		$this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
		$this->form_validation->set_rules('issue_num', 'issue_num', 'trim|xss_clean');
		$this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
		$this->form_validation->set_rules('issue_kind', 'issue_kind', 'trim|xss_clean');
		$this->form_validation->set_rules('place', 'place', 'trim|xss_clean');
		$this->form_validation->set_rules('start_time', 'start_time', 'trim|xss_clean');
		$this->form_validation->set_rules('end_time', 'end_time', 'trim|xss_clean');
		$this->form_validation->set_rules('manager', 'manager', 'trim|xss_clean');
		$this->form_validation->set_rules('contact_name', 'contact_name', 'trim|xss_clean');
		$this->form_validation->set_rules('activity_text', 'activity_text', 'trim|xss_clean');
		$this->form_validation->set_rules('checking_text', 'checking_text', 'trim|xss_clean');
		$this->form_validation->set_rules('summary_text', 'summary_text', 'trim|xss_clean');
		$this->form_validation->set_rules('remarks_text', 'remarks_text', 'trim|xss_clean');
		$this->form_validation->set_rules('recommendations_text', 'recommendations_text', 'trim|xss_clean');
		$this->form_validation->set_rules('trip_start_time', 'trip_start_time', 'trim|xss_clean');
		$this->form_validation->set_rules('trip_end_time', 'trip_end_time', 'trim|xss_clean');
		$this->form_validation->set_rules('back_start_time', 'trip_start_time', 'trim|xss_clean');
		$this->form_validation->set_rules('back_end_time', 'trip_end_time', 'trim|xss_clean');
		$this->form_validation->set_rules('client_sign', 'client_sign', 'trim|xss_clean');
		if (!$this->form_validation->run() == FALSE) {
			$data = array(
				'id' =>  $this->input->post('id'),
				'company' =>  $this->input->post('company'),
				'date' =>  $this->input->post('date'),
				'client_num' =>  $this->input->post('client_num'),
				'issue_num' => $this->input->post('issue_num'),
				'client_name' => $this->input->post('client_name'),
				'issue_kind' => $this->input->post('issue_kind'),
				'place' => $this->input->post('place'),
				'start_time' => $this->input->post('start_time'),
				'end_time' => $this->input->post('end_time'),
				'manager' => $this->input->post('manager'),
				'contact_name' => $this->input->post('contact_name'),
				'activity_text' => $this->input->post('activity_text'),
				'checking_text' => $this->input->post('checking_text'),
				'summary_text' => $this->input->post('summary_text'),
				'remarks_text' => $this->input->post('remarks_text'),
				'recommendations_text' => $this->input->post('recommendations_text'),
				'trip_start_time' => $this->input->post('trip_start_time'),
				'trip_end_time' => $this->input->post('trip_end_time'),
				'back_start_time' => $this->input->post('back_start_time'),
				'back_end_time' => $this->input->post('back_end_time'),
				
			);
			if($this->input->post('client_sign')!=''){
				$data +=array('client_sign' => $this->input->post('client_sign'));
			}
			$response =  $this->Admin_model->update_form($data);
			if ($response) {
				echo "דוח נשמר בהצלחה!";
			} else {
				echo "אין אפשרות לשמור דוח! " . $this->input->post('id');
			}
		} else {
			echo "יש בעיה בפרטים שצריך למאלות!";
		}
    }
    
    public function manage_forms()
	{
		$this->load->database();
		// init params
		$params = array();
		$config = array();
		$limit_per_page = 20;
		define('SEGMENT', 3);
		$start_index = ($this->uri->segment(SEGMENT)) ? $this->uri->segment(SEGMENT) : 0;
		$total_records = $this->Admin_model->get_total();
		if ($total_records > 0) {
			$params["results"] = $this->Admin_model->get_current_forms_records($limit_per_page, $start_index);

			$config['base_url'] = base_url() . 'production/manage_forms/';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = SEGMENT;

			$config['full_tag_open'] = '<ul class="pagination right">';
			$config['full_tag_close'] = '</ul>';

			$config['cur_tag_open'] = '<li class="page-item active "><a class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			$config['num_tag_open'] = '<li class="page-item num-link">';
			$config['num_tag_close'] = '</li>';

			$config['first_tag_open'] = '<li class="page-item num-link">';
			$config['first_tag_close'] = '</li>';

			$config['last_tag_open'] = '<li class="page-item num-link">';
			$config['last_tag_close'] = '</li>';

			$config['next_tag_open'] = '<li class="page-item num-link">';
			$config['next_tag_close'] = '</li>';

			$config['prev_tag_open'] = '<li class="page-item num-link">';
			$config['prev_tag_close'] = '</li>';

			$this->pagination->initialize($config);

			// build paging links
			$params["links"] = $this->pagination->create_links();
		}
		$this->load->view('header');
		$this->load->view('main_menu', $params);
		$this->load->view('production/manage_forms', $params);
		$this->load->view('footer');
	}

	public function form_search()
	{
		$this->form_validation->set_rules('search', 'Search', 'trim|xss_clean');
		$data = $this->Admin_model->searchForm($this->input->post('search'));
		$str = '';
		$count = 0;
		foreach ($data as $result) {
			$str .= "<a class='badge badge-info' href='/production/view_form/" . $result["id"] . "?issue=" . $result["issue_num"] . "'>" . urldecode($result["client_name"]) . ": " . $result["issue_num"] . "</a>";
			$count++;
		}
		echo "<h2>מצאתי " . $count . " דוחות.</h2>" . $str;
	}

	public function delete_form()
	{
		$this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
		$id = $this->input->post('id');
		$this->Admin_model->deleteForm($id);
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
        /* Image compresion on windows servers
        if (!file_exists("C:\Program Files\Ampps\www\assets\exec\pngquanti.exe")) {
            shell_exec('"C:\Program Files\Ampps\www\assets\exec\pngquanti.exe" --ext .jpeg --speed 5 --nofs --force ' . escapeshellarg($file));
        }
        */
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
                $this->log_data('deleted ' . $photo, 3);
            }
        }
    }

    public function log_data($msg, $level = 0)
    {
        if (!file_exists('application/logs/admin')) {
            mkdir('application/logs/admin', 0770, true);
        }
        $level_arr = array('INFO', 'CREATE', 'TRASH', 'DELETE');
        $user = $this->session->userdata['logged_in']['name'];
        $log_file = APPPATH . "logs/production/" . date("m-d-Y") . ".log";
        $fp = fopen($log_file, 'a'); //opens file in append mode  
        fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
        fclose($fp);
    }
}
