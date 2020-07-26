<?php
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// Load model
		$this->load->model('Users_model');
		$this->load->model('Admin_model');
		$this->load->model('Production_model');
		$this->load->library('pagination');
	}

	function settings()
	{
		$data = array();
		$data['settings'] = '';
		$data['response'] = '';
		$this->load->view('header');
		$this->load->view('main_menu');
		$data = $this->Admin_model->getStatistic();
		if ($this->db->table_exists('settings')) {
			$data['settings'] = $this->Admin_model->getSettings();
		}
		$this->load->view('admin/settings', $data);
		$this->load->view('footer');
	}

	public function save_settings()
	{
		// Check validation for user input in SignUp form
		$this->form_validation->set_rules('roles', 'Roles', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->settings();
		} else {
			$data = array(
				'roles' => $this->input->post('roles')
			);
			$this->Admin_model->save_settings($data);
			echo 'Settings saved successfully!';
		}
	}

	function create()
	{
		$data = array();
		$data['response'] = '';
		if (!$this->db->table_exists('users')) {
			$this->Admin_model->createUsersDb();
			$data['response'] .= "Table 'users' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'users' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('companies')) {
			$this->Admin_model->createCompaniesDb();
			$data['response'] .= "Table 'companies' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'companies' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('forms')) {
			$this->Admin_model->createFormsDb();
			$data['response'] .= "Table 'forms' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'forms' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('settings')) {
			$this->Admin_model->createSettingsDb();
			$data['settings'] = $this->Admin_model->getSettings();
			$data['response'] .= "Table 'settings' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'settings' exists!<br>" . PHP_EOL;
			$data['settings'] = $this->Admin_model->getSettings();
		}
		echo $data['response'];
	}

	public function manage_forms()
    {
        $this->load->database();
        // init params
        $params = array();
        $config = array();
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $total_records = $this->Production_model->get_total();
        if ($total_records > 0) {
            $params["results"] = $this->Production_model->get_current_forms_records($limit_per_page, $start_index);

            $config['base_url'] = base_url() . 'admin/forms/';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 4;

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
        $this->load->view('admin/manage_forms', $params);
        $this->load->view('footer');
	}
	
	
    public function form_search()
    {
        $this->form_validation->set_rules('search', 'Search', 'trim|xss_clean');
        $data = $this->Admin_model->searchForm($this->input->post('search'));
        $str = '';
        $count = 0;
        foreach ($data as $result) {
            if (strpos($result["issue_num"], 'Trash') !== false) {
                $str .= "<div class='badge badge-danger' >" . urldecode($result["client_name"]) . ": " . $result["issue_num"] . "</div>";
            } else {
                $str .= "<a class='badge badge-info' href='/production/edit_form/" . $result["id"] . "?sn=" . $result["issue_num"] . "'>" . urldecode($result["client_name"]) . ": " . $result["issue_num"] . "</a>";
            }

            $count++;
        }
        echo "<h2>Found " . $count . " serials.</h2>" . $str;
    }

	function manage_trash()
	{
		$form = 'Trash';
		$this->load->database();
		// init params
		$params = array();
		$config = array();
		$limit_per_page = 10;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = $this->Admin_model->get_total($form);
		if ($total_records > 0) {
			$params["results"] = $this->Admin_model->get_current_forms_records($limit_per_page, $start_index, $form);

			$config['base_url'] = base_url() . 'admin/manage_trash';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;

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
		$this->load->view('admin/manage_trash', $params);
		$this->load->view('footer');
	}

	public function restoreForm()
	{
		$this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
		$this->form_validation->set_rules('form', 'Project', 'trim|xss_clean');

		$data = array(
			'id' =>  $this->input->post('id'),
			'form' => $this->input->post('form')
		);
		$this->Admin_model->restore_from_trash($data);
	}

	public function delete_from_trash()
	{
		$this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
		$this->form_validation->set_rules('form', 'Project', 'trim|xss_clean');
		$this->form_validation->set_rules('serial', 'Serial', 'trim|xss_clean');
		$id = $this->input->post('id');
		$form = $this->input->post('form');
		$serial = $this->input->post('serial');
		$this->Admin_model->deleteForm($id);
		$this->log_data("deleted from '$form' form '$serial'", 3);
	}

	public function view_log()
	{
		if (!file_exists('application/logs/admin')) {
			mkdir('application/logs/admin', 0770, true);
		}
		$dirlistR = $this->getFileList('application/logs/admin');
		// init params
		$params = array();
		$config = array();
		$limit_per_page = 10;
		$start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$total_records = count($dirlistR);
		if ($total_records > 0) {
			$params["results"] = array_slice($dirlistR, $start_index, $limit_per_page);

			$config['base_url'] = base_url() . 'admin/view_log';
			$config['total_rows'] = $total_records;
			$config['per_page'] = $limit_per_page;
			$config["uri_segment"] = 3;

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
		$this->load->view('admin/view_log', $params);
		$this->load->view('footer');
	}

	public function get_log()
	{
		$this->form_validation->set_rules('file', 'File', 'trim|xss_clean');
		echo file_get_contents(APPPATH . 'logs/admin/' . $this->input->post('file'));
	}

	function getFileList($dir, $recurse = FALSE)
	{
		$retval = [];
		$patterns[0] = '/\:/';
		$patterns[1] = '/\./';
		$dir = preg_replace($patterns, '',  $dir);
		// add trailing slash if missing
		if (substr($dir, -1) != "/") {
			$dir .= "/";
		}
		// open pointer to directory and read list of files
		$d = @dir($dir) or die("getFileList: Failed opening directory {$dir} for reading");
		while (FALSE !== ($entry = $d->read())) {
			// skip hidden files
			if ($entry[0] == ".") continue;
			if (is_dir("{$dir}{$entry}")) {
				$retval[] = [
					'name' => "{$dir}{$entry}",
					'type' => filetype("{$dir}{$entry}"),
					'size' => 0,
					'lastmod' => filemtime("{$dir}{$entry}")
				];
				if ($recurse && is_readable("{$dir}{$entry}/")) {
					$retval = array_merge($retval, getFileList("{$dir}{$entry}/", TRUE));
				}
			} elseif (is_readable("{$dir}{$entry}")) {
				$retval[] = [
					'name' => "{$dir}{$entry}",
					'type' => mime_content_type("{$dir}{$entry}"),
					'size' => filesize("{$dir}{$entry}"),
					'lastmod' => filemtime("{$dir}{$entry}")
				];
			}
		}
		$d->close();

		return $retval;
	}

	function human_filesize($bytes, $decimals = 2)
	{
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}

	public function log_data($msg, $level = 0)
	{
		if (!file_exists('application/logs/admin')) {
			mkdir('application/logs/admin', 0770, true);
		}
		$level_arr = array('INFO', 'CREATE', 'TRASH', 'DELETE');
		$user = $this->session->userdata['logged_in']['name'];
		$log_file = APPPATH . "logs/admin/" . date("m-d-Y") . ".log";
		$fp = fopen($log_file, 'a'); //opens file in append mode  
		fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
		fclose($fp);
	}

	function mange_uploads()
	{
		$data = array();
		$folder = $this->security->xss_clean($this->input->get('folder'));
		$data['folders'] = $this->build_folder_view($folder);
		$this->load->view('header');
		$this->load->view('main_menu');
		$this->load->view('admin/mange_uploads', $data);
		$this->load->view('footer');
	}

	function build_folder_view($dir = "Uploads")
	{
		if ($dir == '') {
			$dir = "Uploads";
		}
		$html_view = '';
		$dirlistR = $this->getFileList($dir);
		$dir = explode('/', $dir);  //string to array
		$last_dir = array_pop($dir);            //remove last element
		$dir = implode('/', $dir);  //array to string
		if($dir!=''){
			$html_view .=  "<a href='?folder=$dir'>$dir/<a><b>" . $last_dir . "/</b><br>";
		}
		// output file list as HTML table
		$html_view .= "<table class='table files'";
		$html_view .= "<thead>\n";
		$html_view .= "<tr><th>image</th><th>Path</th><th>Type</th><th>Size</th><th>Last Modified</th><th>Delete</th></tr>\n";
		$html_view .= "</thead>\n";
		$html_view .= "<tbody>\n";
		foreach ($dirlistR as $file) {
			//filter file types
			if ($file['type'] != 'image/png' && $file['type'] != 'image/jpeg' && $file['type'] != 'image/jpg' && $file['type'] != 'dir') {
				continue;
			}

			if ($file['type'] == 'dir') {
				$subDir = $this->getFileList($file['name']);
				$count = count(array_filter($subDir, function ($x) {
					return $x['type'] != 'text/html';
				})); //count all files, filter html
				$html_view .= '<a class="btn btn-primary folder" href="?folder=' . $file['name'] .
					'" role="button"><i class="fa fa-folder"></i> ' .
					basename($file['name']) . ' (' .  $count . ')</a>';
			} else {
				$html_view .= "<tr>\n";
				$html_view .=  "<td class='td_file_manager'><a target='_blank' href=\"/{$file['name']}\"><img class='img-thumbnail' src=\"/{$file['name']}\"></a>" .
					"</td>\n"; //basename($file['name'])
				$html_view .=  "<td>" . $file['name'] . "</td>\n"; //basename($file['name'])
				$html_view .= "<td>{$file['type']}</td>\n";
				$html_view .= "<td>" . $this->human_filesize($file['size']) . "</td>\n";
				$html_view .= "<td>" . date('d/m/Y h:i:s', $file['lastmod']) . "</td>\n";
				$html_view .= '<td><span id="/' . $file['name'] . '" onclick="delFile(this.id)" class="btn btn-danger delete-photo">delete</span></td>';
				$html_view .= "</tr>\n";
			}
		}
		$html_view .= "</tbody>\n";
		$html_view .= "</table>\n\n";
		return $html_view;
	}

	function RemoveEmptySubFolders($path = 'Uploads', $msg = "")
	{
		$msg .= "Cleaning folder: " . $path . "<br>";
		$empty = true;
		foreach (glob($path . DIRECTORY_SEPARATOR . "*") as $file) {
			$empty &= is_dir($file) && $this->RemoveEmptySubFolders($file);
		}
		echo $msg;
		return $empty && rmdir($path);
	}
}
