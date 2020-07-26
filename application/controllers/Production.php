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

    // Validate and store form data in database
    public function add_form($project = '', $data = '')
    {
        $data = array();
        // Check validation for user input in SignUp form
        $zero_str = implode(",", array_fill(0, 400, ""));
        $this->form_validation->set_rules('client', 'Client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('project', 'Project', 'trim|required|xss_clean');
        $this->form_validation->set_rules('serial', 'Serial', 'trim|required|xss_clean');
        $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['client'] = $this->Companies_model->getCompanies('', $project);
            $data['project'] = urldecode($project);
            if (isset($this->Templates_model->getTemplate('', $project)[0]['template'])) {
                $data['template'] = $this->Templates_model->getTemplate('', $project)[0]['template'];
            } else {
                $data['template'] = " - not set!";
            }
            $this->load->view('header');
            $this->load->view('main_menu', $data);
            $this->load->view('production/add_form', $data);
            $this->load->view('footer');
        } else {
            $serial = trim($this->input->post('serial'));
            $data = array(
                'client' => $this->input->post('client'),
                'project' => $this->input->post('project'),
                'serial' => trim($this->input->post('serial')),
                'data' =>  $zero_str,
                'date' => $this->input->post('date')
            );
            $result = $this->Production_model->addChecklist($data);
            if ($result == TRUE) {
                $this->log_data("created '$project' form with serial '$serial'",1);
                header("location: /production/forms/" . $project);
            } else {
                if (isset($this->Templates_model->getTemplate('', $project)[0]['template'])) {
                    $data['template'] = $this->Templates_model->getTemplate('', $project)[0]['template'];
                } else {
                    $data['template'] = " - not set!";
                }
                $data['message_display'] = 'Checklist ' . $this->input->post('serial') . ' already exist!';
                $data['client'] = $this->Companies_model->getCompanies('', $project);
                $data['project'] = urldecode($this->input->post('project'));
                if (isset($this->Templates_model->getTemplate('', $project)[0]['template'])) {
                    $data['template'] = $this->Templates_model->getTemplate('', $project)[0]['template'];
                } else {
                    $data['template'] = " - not set!";
                }
                $this->load->view('header');
                $this->load->view('main_menu', $data);
                $this->load->view('production/add_form', $data);
                $this->load->view('footer');
            }
        }
    }

    // Validate and store form data in database 
    public function gen_forms()
    {
        $result = 'Serial template not set!';
        $dfend_month = array('01' => '1', '02' => '2', '03' => '3', '04' => '4', '05' => '5', '06' => '6', '07' => '7', '08' => '8', '09' => '9', '10' => 'A', '11' => 'B', '12' => 'C');
        $zero_str = implode(",", array_fill(0, 400, ""));
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('client', 'Client', 'trim|required|xss_clean');
        $this->form_validation->set_rules('project', 'Project', 'trim|required|xss_clean');
        $this->form_validation->set_rules('count', 'Count', 'trim|required|xss_clean');
        $last_serial = $this->Production_model->getLastChecklist($this->input->post('project'));
        $serial_project = $this->Templates_model->getTemplate('', $this->input->post('project'));
        if (isset($serial_project[0]['template']) &&  $serial_project[0]['template'] != "") {
            $serial = $serial_project[0]['template']; //Get serial template
            $serial = str_replace("yy", date("y"), $serial); //add year
            $serial = str_replace("mm", date("m"), $serial); //add month with zero
            $serial = str_replace("dm", $dfend_month[date("m")], $serial); //add month from dfend array
            $serial_end = substr($last_serial, strpos($serial, 'x'), substr_count($serial, 'x')) + 0;
            $zero_count = $this->zero_count(substr_count($serial, 'x'), $serial_end);
            $arr = array("xxxx", "xxx", "xx");
            $count = $this->input->post('count');
            for ($i = 1; $i <= $count; $i++) {
                $serial_end++;
                $zero_count = $this->zero_count(substr_count($serial, 'x'), $serial_end);
                $current_serial = str_replace($arr, $zero_count, $serial);
                $project = $this->input->post('project');
                $data = array(
                    'client' => $this->input->post('client'),
                    'project' => $project,
                    'serial' => $current_serial,
                    'data' =>  $zero_str,
                    'date' => date("Y-m-d")
                );
                $result = $this->Production_model->addChecklist($data);
                if ($result != 1) {
                    echo 'Checklist ' . $data['serial'] . ' exists!';
                    return;
                }
                if ($result == TRUE) {
                    $this->log_data("created '$project' form with serial '$current_serial'",1);
                }
            }
        }
        echo $result;
    }

    private function zero_count($x, $num)
    {
        if ($x == 4) {
            if ($num < 10) {
                return "000" . $num;
            } else if ($num < 100) {
                return "00" . $num;
            } else {
                return "0" . $num;
            }
        }

        if ($x == 3) {
            if ($num < 10) {
                return "00" . $num;
            } else if ($num < 100) {
                return "0" . $num;
            } else {
                return $num;
            }
        }

        if ($x == 2) {
            if ($num < 10) {
                return "0" . $num;
            } else {
                return $num;
            }
        }

        return 0;
    }

    public function edit_form($id = '')
    {
        $data = array();
        $data['js_to_load'] = array("edit_form.js?" . filemtime('assets/js/edit_form.js'));
        $data['form'] =  $this->Production_model->getChecklists($id);
        if ($data['form']) {
            $data['project'] =  urldecode($data['form'][0]['project']);
            $data['form_rows'] = $this->build_form($data);
            $data['scans_rows'] = $this->build_scans($data);
            $data['client'] = $this->Companies_model->getCompanies('', $data['project']);
        }
        $this->load->view('header');
        $this->load->view('main_menu', $data);
        if ($data['form']) {
            $this->load->view('production/edit_form');
        }
        $this->load->view('footer');
    }

    public function edit_batch($ids = '0', $msg = '')
    {
        $data = array();
        if ($msg != '') {
            $data['message_display'] = $msg;
        }
        $data['ids'] = $ids;
        $data['js_to_load'] = array("edit_form.js?" . filemtime('assets/js/edit_form.js'));
        $data['forms'] =  $this->Production_model->getChecklists($ids);
        if ($data['forms']) {
            $data['form'] = $data['forms'];
            $data['project'] =  urldecode($data['forms'][0]['project']);
            $data['form_rows'] = $this->build_form($data);
        }
        $this->load->view('header');
        $this->load->view('main_menu', $data);
        if ($data['forms']) {
            $this->load->view('production/edit_batch');
        }
        $this->load->view('footer');
    }

    private function build_form($data)
    {
        $this->load->model('Users_model');
        $users = $this->Users_model->getUsers();
        $prefix_count = 0;
        $checked = "";
        $table = '';
        $options = '';
        $project = $data['form'][0]['project'];
        $form_data = $data['form'][0]['data'];
        if (count($this->Templates_model->getTemplate('', $project)) > 0) {
            $project_data = $this->Templates_model->getTemplate('', $project)[0]['data'];
            $rows = explode(PHP_EOL, $project_data);
            $status = explode(",", $form_data);
            //$table .= $form_data;
            $index = 0;
            $id = 0;
            foreach ($users as $user) {
                $options .= "<option >" . $user['name'] . "</option>";
            }
            for ($i = 0; $i < count($rows); $i++) {
                $tr = '';
                $checked = '';
                if (isset($status[$id]) && $status[$id] != '') {
                    $checked = "Checked name-data='" . $status[$id] . "'";
                }
                if ($index < 10) {
                    $prefix = $prefix_count . '.0';
                } else {
                    $prefix = $prefix_count . '.';
                }
                $col = explode(";", $rows[$i]);
                if (count($col) > 1) {
                    if (end($col) == "HD") {
                        $tr = '<table id="form" class="table"><thead class="thead-dark">' . '<tr><th scope="col">#</th><th id="result" scope="col">' . $col[0] . '</th>';
                        for ($j = 1; $j < count($col) - 1; $j++) {
                            $tr .= '<th scope="col">' . $col[$j] . '</th>';
                        }
                        $tr .= '</tr></thead><tbody>';
                        $index = 1;
                        $prefix_count++;
                    } else if (end($col) == "QC") {
                        $tr .= "<tr class='qc_row'><th scope='row'>$prefix$index</th><td class='description' colspan='2'>" . $col[0];
                        $tr .= "<select class='form-control review' id='" . ($id + count($rows)) . "'><option>Select</option>";
                        $tr .= $options . "</select></td></tr>";
                        $index++;
                        $id++;
                    } else if (end($col) == "N") {
                        $tr = "<tr class='check_row'><th scope='row'>$prefix$index</th><td class='description'>" . $col[0] . "</td>";
                        $tr .= "<td><div class='checkbox'><input type='checkbox' class='verify'  id='$id' $checked></div></td>";
                        $tr .= "<td><select class='form-control review' id='" . ($id + count($rows)) . "'><option>Select</option>";
                        $tr .= $options . "</select></td></tr>";
                        $index++;
                        $id++;
                    } else {
                        $tr = "<tr class='check_row'><th scope='row'>$prefix$index</th><td class='description'>" . $col[0] . "</td><td>" .
                            "<div class='checkbox'><input type='checkbox' class='verify' id='$id' $checked></div></td></tr>";
                        $index++;
                        $id++;
                    }
                }
                $table .= $tr;
            }
        }

        $table .= '</tbody></table>';
        return $table;
    }

    private function build_scans($data)
    {
        $table = '';
        $tr = '';
        $columns = 0;
        $id = 0;
        $project = $data['form'][0]['project'];
        if (count($this->Templates_model->getTemplate('', $project)) > 0) {
            $project_scans = $this->Templates_model->getTemplate('', $project)[0]['scans'];
            $rows = explode(PHP_EOL, $project_scans);
            if (count($rows) > 1) {
                $table .= '<center><h2> Scans Table</h2></center><table id="scans" class="table"><thead class="thead-dark">';
                for ($i = 0; $i < count($rows); $i++) {
                    $col = explode(";", $rows[$i]);
                    if (end($col) == "HD") {
                        $columns = count($col);
                        $tr = '<tr><th scope="col">#</th><th scope="col">' . $col[0] . '</th>';
                        for ($j = 1; $j < count($col) - 1; $j++) {
                            $tr .= '<th scope="col">' . $col[$j] . '</th>';
                        }
                        $tr .= '</tr></thead>';
                        $table .= $tr;
                    } else {
                        $tr = "<tr id='$id' class='scan_row'><th scope='row'>$i</th><td class='description'>" . $col[0] . "</td>";
                        for ($j = 2; $j < $columns; $j++) {
                            $tr .= "<td><input type='text' class='form-control scans'></td>";
                        }
                        $tr .=  "</tr>";
                        $table .= $tr;
                        $id++;
                    }
                }
            }
        }
        $table .= '</tbody></table>';
        return $table;
    }

    public function save_form($id = '')
    {
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('data', 'Data', 'trim|xss_clean');
        $this->form_validation->set_rules('log', 'Log', 'trim|xss_clean');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|xss_clean');
        $this->form_validation->set_rules('assembler', 'assembler', 'trim|xss_clean');
        $this->form_validation->set_rules('qc', 'Qc', 'trim|xss_clean');
        $this->form_validation->set_rules('scans', 'Scans', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit_form($id);
        } else {
            $data = array(
                'id' =>  $id,
                'data' =>  $this->input->post('data'),
                'log' =>  $this->input->post('log'),
                'progress' => $this->input->post('progress'),
                'assembler' => $this->input->post('assembler'),
                'qc' => $this->input->post('qc'),
                'scans' => $this->input->post('scans')
            );
            $this->Production_model->editChecklist($data);
            echo 'Checklist saved successfully!';
        }
    }

    public function save_batch_forms($ids = '')
    {
        // Check validation for user input in SignUp form
        $this->form_validation->set_rules('data', 'Data', 'trim|xss_clean');
        $this->form_validation->set_rules('log', 'Log', 'trim|xss_clean');
        $this->form_validation->set_rules('progress', 'Progress', 'trim|xss_clean');
        $this->form_validation->set_rules('assembler', 'assembler', 'trim|xss_clean');
        $this->form_validation->set_rules('qc', 'Qc', 'trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit_batch($ids);
        } else {
            $ids_arr = explode(':', $ids);
            foreach ($ids_arr as $id) {
                $data = array(
                    'id' =>  $id,
                    'data' =>  $this->input->post('data'),
                    'log' =>  $this->input->post('log'),
                    'progress' => $this->input->post('progress'),
                    'assembler' => $this->input->post('assembler'),
                    'qc' => $this->input->post('qc')
                );
                $this->Production_model->batchEditChecklist($data);
            }
            echo 'Checklists saved successfully!', $ids;
            //$this->edit_batch($ids, $message_display);
        }
    }

    public function trashChecklist()
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
        $client = $_POST['client'];
        $serial = $_POST['serial'];
        $num = $_POST['num'];
        $upload_folder = UPLOAD_DIR . $client . "/" . $folder . "/" . $serial;
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
