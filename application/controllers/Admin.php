<?php
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model');
		$this->load->model('Admin_model');
		$this->load->model('Production_model');
		$this->load->model('Companies_model');
		$this->load->model('Contacts_model');
		$this->load->library('pagination');
	}

	function settings()
	{
		$this->Admin_model->add_field('settings', 'emails'); //one time update db to add new field
		$this->Admin_model->add_field('forms', 'old_serial','VARCHAR',100); //one time update db to add new field
		$this->Admin_model->add_field('forms', 'new_serial','VARCHAR',100); //one time update db to add new field
		$data = array();
		$data['settings'] = '';
		$this->load->view('header');
		$this->load->view('main_menu');
		$data = $this->Admin_model->getStatistic();
		if ($this->db->table_exists('settings')) {
			$data['settings'] = $this->Admin_model->getSettings()[0];
		}
		$this->load->view('admin/settings', $data);
		$this->load->view('footer');
	}

	public function save_settings()
	{
		$smtp_on = 0;
		$this->form_validation->set_rules('roles', 'Roles', 'trim|xss_clean');
		$this->form_validation->set_rules('emails', 'emails', 'trim|xss_clean');
		$this->form_validation->set_rules('smtp_host', 'smtp_host', 'trim|xss_clean');
		$this->form_validation->set_rules('smtp_user', 'smtp_user', 'trim|xss_clean');
		$this->form_validation->set_rules('smtp_pass', 'smtp_pass', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->settings();
		} else {
			$data = array(
				'roles' => $this->input->post('roles'),
				'emails' => $this->input->post('emails')
			);
			if (isset($_POST['smtp_on'])) {
				$smtp_on = 1;
				$data += array(
					'smtp_on' => $smtp_on,
					'smtp_host' => $this->input->post('smtp_host'),
					'smtp_port' => $this->input->post('smtp_port'),
					'smtp_user' => $this->input->post('smtp_user')
				);
				if ($this->input->post('smtp_pass') != '') {
					$data += array('smtp_pass' => $this->input->post('smtp_pass'));
				}
			} else {
				$data += array('smtp_on' => $smtp_on);
			}
			$this->Admin_model->save_settings($data);
			echo 'הגדרות נשמרו בהצלחה!';
		}
	}

	function create()
	{
		$data = array();
		$data['response'] = '';
		if (!$this->db->table_exists('users')) {
			$this->Users_model->createUsersDb();
			$data['response'] .= "Table 'users' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'users' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('companies')) {
			$this->Companies_model->createCompaniesDb();
			$data['response'] .= "Table 'companies' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'companies' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('forms')) {
			$this->Production_model->createFormsDb();
			$data['response'] .= "Table 'forms' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'forms' exists!<br>" . PHP_EOL;
		}
		if (!$this->db->table_exists('contacts')) {
			$this->Contacts_model->create();
			$data['response'] .= "Table 'contacts' created!<br>" . PHP_EOL;
		} else {
			$data['response'] .= "Table 'contacts' exists!<br>" . PHP_EOL;
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

	public function view_log()
	{
		if (!file_exists('application/logs/admin')) {
			mkdir('application/logs/admin', 0770, true);
		}
		$dirlistR = $this->getFileList('application/logs/admin');
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
			if ($entry[0] == ".") continue; // skip hidden files
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
		$fp = fopen($log_file, 'a');
		fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
		fclose($fp);
	}

	function view_folders()
	{
		$data = array();
		$folder = $this->security->xss_clean($this->input->get('folder'));
		$data['folders'] = $this->build_folder_view($folder);
		$this->load->view('header');
		$this->load->view('main_menu');
		$this->load->view('admin/view_folders', $data);
		$this->load->view('footer');
	}

	function view_charts($user_id = '')
	{
		$data = array();
		$data['year'] = isset($_GET['year']) ? $_GET['year'] : '';
		$year = ($data['year'] != '') ? substr($data['year'], 0, 4) : date('Y');
		if ($user_id == '') {
			$data['users'] = $this->Users_model->getusers();
			foreach ($data['users'] as $user) {
				$data['user_' . $user['id']] = $this->get_year_stats($user['id'], $year);
			}
		} else {
			$data['csv_user'] = $user_id;
			$data['users'] = $this->Users_model->getUser($user_id);
			$data['user_' . $user_id] = $this->get_year_stats($user_id, $year);
		}
		$this->load->view('header');
		$this->load->view('main_menu');
		$this->load->view('admin/view_charts', $data);
		$this->load->view('footer');
	}

	function get_year_stats($user_id, $year)
	{
		$data = '';
		if ($user_id == '') {
			$user_id = $this->security->xss_clean($this->input->get('user'));
		}
		for ($i = 1; $i < 13; $i++) {
			$monthSum = $this->Production_model->getMonthTotal($i, $year, $user_id)[0]['SUM(price)'];
			if ($monthSum > 0) {
				$data .= $monthSum . ',';
			} else {
				$data .= ',';
			}
		}
		return $data;
	}

	function build_folder_view($dir = "Uploads")
	{
		if ($dir == '') {
			$dir = "Uploads";
		}
		$html_view = '';
		$dirlistR = $this->getFileList($dir);
		$dir = explode('/', $dir);
		$last_dir = array_pop($dir);
		$dir = implode('/', $dir);
		if ($dir != '') {
			$html_view .=  "<a href='?folder=$dir'>$dir/<a><b>" . $last_dir . "/</b><br>";
		}
		$html_view .= "<table class='table files'";
		$html_view .= "<thead>\n";
		$html_view .= "<tr><th>image</th><th>Path</th><th>Type</th><th>Size</th><th>Last Modified</th><th>Delete</th></tr>\n";
		$html_view .= "</thead>\n";
		$html_view .= "<tbody>\n";
		foreach ($dirlistR as $file) {
			//filter file types
			if ($file['type'] != 'image/png' && $file['type'] != 'image/jpeg' && $file['type'] != 'image/jpg' && $file['type'] != 'dir') {
				//continue;
			}

			if ($file['type'] == 'dir') {
				$subDir = $this->getFileList($file['name']);
				$count = count(array_filter($subDir, function ($x) {
					return $x['type'] != 'text/html';
				}));
				$html_view .= '<a class="btn btn-primary folder" href="?folder=' . $file['name'] .
					'" role="button"><i class="fa fa-folder"></i> ' .
					basename($file['name']) . ' (' .  $count . ')</a>';
			} else {
				$html_view .= "<tr>\n";
				if ($file['type'] == 'image/png' || $file['type'] == 'image/jpeg' || $file['type'] == 'image/jpg') {
					//continue;
					$html_view .=  "<td class='td_file_manager'><a target='_blank' href=\"/{$file['name']}\"><img class='img-thumbnail' src=\"/{$file['name']}\"></a></td>\n";
				} else {
					$html_view .=  "<td class='td_file_manager'>No Preview</td>\n";
				}
				$html_view .=  "<td><a target='_blank' href=\"/{$file['name']}\">" . $file['name'] . "</a></td>\n";
				$html_view .= "<td>{$file['type']}</td>\n";
				$html_view .= "<td>" . $this->human_filesize($file['size']) . "</td>\n";
				$html_view .= "<td>" . date('d/m/Y h:i', $file['lastmod']) . "</td>\n";
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

	function backupDB()
	{
		date_default_timezone_set("Asia/Jerusalem");
		$working_dir = 'Uploads/Backups/'.date("Y-m")."/";
		if (!file_exists($working_dir)) {
            mkdir($working_dir, 0770, true);
        }
		// Load the DB utility class
		$this->load->dbutil();
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		$file = $working_dir.'db-'.date("Y-m-d_h-i").'.zip';
		$success = file_put_contents($file, $backup);
		// Load the download helper and send the file to your desktop
		echo $success ? "backup file saved! ".'db-'.date("Y-m-d_h-i").'.zip' : 'Unable to save the backup file!';
	}
}
