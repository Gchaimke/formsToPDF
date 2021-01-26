<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Production_model');
        $this->load->model('Users_model');
        $this->load->model('Companies_model');
        $this->load->model('Contacts_model');
        $this->load->model('Tickets_model');
    }

    public function index()
    {
        $data = array();
        $data['companies'] = $this->Companies_model->getCompanies();
        $data['user'] = $this->Users_model->getUser($this->session->userdata['logged_in']['id'])[0];
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/dashboard', $data);
        $this->load->view('footer');
    }

    public function new_form($company = '')
    {
        $data = array();
        if ($company != '') {
            $company = urldecode($company);
            $data['companie'] = $this->Companies_model->getCompanies('', $company)[0];
        } else if (isset($_GET['company_id'])) {
            $data['companie'] = $this->Companies_model->getCompanies($_GET['company_id'])[0];
        } else {
            $data['companie'] = $this->Companies_model->getCompanies('1')[0];
        }

        $data['contacts'] = $this->Contacts_model->get();
        $data['hide_filds'] = $this->hide_filds($data['companie']['view_filds']);
        $data['user'] = $this->Users_model->getUser($this->session->userdata['logged_in']['id']);
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/new_form', $data);
        $this->load->view('footer');
    }

    public function add_form()
    {
        $creator_id = $this->session->userdata['logged_in']['id'];
        $creator_name = $this->Users_model->getUser($creator_id)[0]['view_name'];
        $this->form_validation->set_rules('date', 'date', 'trim|required|xss_clean');
        $this->form_validation->set_rules('company', 'company', 'trim|xss_clean');
        $this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_num', 'issue_num', 'trim|xss_clean');
        $this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_kind', 'issue_kind', 'trim|xss_clean');
        $this->form_validation->set_rules('place', 'place', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'city', 'trim|xss_clean');
        $this->form_validation->set_rules('start_time', 'start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('end_time', 'end_time', 'trim|xss_clean');
        $this->form_validation->set_rules('manager', 'manager', 'trim|xss_clean');
        $this->form_validation->set_rules('contact_name', 'contact_name', 'trim|xss_clean');
        $this->form_validation->set_rules('activity_text', 'activity_text', 'trim|xss_clean');
        $this->form_validation->set_rules('checking_text', 'checking_text', 'trim|xss_clean');
        $this->form_validation->set_rules('summary_text', 'summary_text', 'trim|xss_clean');
        $this->form_validation->set_rules('remarks_text', 'remarks_text', 'trim|xss_clean');
        $this->form_validation->set_rules('recommendations_text', 'recommendations_text', 'trim|xss_clean');
        $this->form_validation->set_rules('email_to', 'email_to', 'trim|xss_clean');
        $this->form_validation->set_rules('attachments', 'attachments', 'trim|xss_clean');
        $this->form_validation->set_rules('price', 'price', 'trim|xss_clean');
        $this->form_validation->set_rules('details', 'details', 'trim|xss_clean');
        $this->form_validation->set_rules('client_sign', 'client_sign', 'trim|xss_clean');
        $this->form_validation->set_rules('old_serial', 'old_serial', 'trim|xss_clean');
        $this->form_validation->set_rules('new_serial', 'new_serial', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $data = array(
                'date' =>  $this->input->post('date'),
                'creator_id' =>  $creator_id,
                'creator_name' =>  $creator_name,
                'company' =>  $this->input->post('company'),
                'client_num' =>  $this->input->post('client_num'),
                'issue_num' => $this->input->post('issue_num'),
                'client_name' => $this->input->post('client_name'),
                'issue_kind' => $this->input->post('issue_kind'),
                'place' => $this->input->post('place'),
                'city' => $this->input->post('city'),
                'start_time' => $this->input->post('start_time'),
                'end_time' => $this->input->post('end_time'),
                'manager' => $this->input->post('manager'),
                'contact_name' => $this->input->post('contact_name'),
                'activity_text' => $this->input->post('activity_text'),
                'checking_text' => $this->input->post('checking_text'),
                'summary_text' => $this->input->post('summary_text'),
                'remarks_text' => $this->input->post('remarks_text'),
                'recommendations_text' => $this->input->post('recommendations_text'),
                'email_to' => $this->input->post('email_to'),
                'attachments' => $this->input->post('attachments'),
                'price' => $this->input->post('price'),
                'details' => $this->input->post('details'),
                'client_sign' => $this->input->post('client_sign'),
                'old_serial' => $this->input->post('old_serial'),
                'new_serial' => $this->input->post('new_serial')
            );
            foreach ($data as $key => &$str) {
                if (!$key == 'client_sign') {
                    $str = $this->cleanStr($str);
                }
            }
            $id =  $this->Production_model->add_form($data);
            if ($id > 0 || $id) {
                $this->log_data(' יצר דוח ' . $id . ' לחברת ' . $this->input->post('company'), $id, 1);
                echo $id;
                if ($this->input->post('client_num') != '') {
                    $data = array(
                        'client_num' => $this->input->post('client_num'),
                        'status' => 'working'
                    );
                    $this->Tickets_model->update($data);
                }
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
        $data['form_data'] = $this->Production_model->getForm($id);
        $data['companies'] = $this->Companies_model->getCompanies();
        $data['contacts'] = $this->Contacts_model->get();
        $current_company = $this->Companies_model->getCompanies('', $data['form_data'][0]['company']);
        if (count($current_company) > 0) {
            $current_company = $current_company[0];
            $data['hide_filds'] = $this->hide_filds($current_company['view_filds']);
            $data['logo'] = $current_company['logo'];
        }
        $data['users'] = $this->Users_model->getUsers();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/view_form', $data);
        $this->load->view('footer');
    }

    public function update_form()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $this->form_validation->set_rules('creator_id', 'creator_id', 'trim|xss_clean');
        $this->form_validation->set_rules('creator_name', 'creator_name', 'trim|xss_clean');
        $this->form_validation->set_rules('company', 'company', 'trim|xss_clean');
        $this->form_validation->set_rules('date', 'date', 'trim|xss_clean');
        $this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_num', 'issue_num', 'trim|xss_clean');
        $this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
        $this->form_validation->set_rules('issue_kind', 'issue_kind', 'trim|xss_clean');
        $this->form_validation->set_rules('place', 'place', 'trim|xss_clean');
        $this->form_validation->set_rules('city', 'city', 'trim|xss_clean');
        $this->form_validation->set_rules('start_time', 'start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('end_time', 'end_time', 'trim|xss_clean');
        $this->form_validation->set_rules('manager', 'manager', 'trim|xss_clean');
        $this->form_validation->set_rules('contact_name', 'contact_name', 'trim|xss_clean');
        $this->form_validation->set_rules('activity_text', 'activity_text', 'trim|xss_clean');
        $this->form_validation->set_rules('checking_text', 'checking_text', 'trim|xss_clean');
        $this->form_validation->set_rules('summary_text', 'summary_text', 'trim|xss_clean');
        $this->form_validation->set_rules('remarks_text', 'remarks_text', 'trim|xss_clean');
        $this->form_validation->set_rules('recommendations_text', 'recommendations_text', 'trim|xss_clean');
        $this->form_validation->set_rules('email_to', 'email_to', 'trim|xss_clean');
        $this->form_validation->set_rules('attachments', 'attachments', 'trim|xss_clean');
        $this->form_validation->set_rules('price', 'price', 'trim|xss_clean');
        $this->form_validation->set_rules('details', 'details', 'trim|xss_clean');
        $this->form_validation->set_rules('client_sign', 'client_sign', 'trim|xss_clean');
        $this->form_validation->set_rules('old_serial', 'old_serial', 'trim|xss_clean');
        $this->form_validation->set_rules('new_serial', 'new_serial', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $data = array(
                'id' =>  $this->input->post('id'),
                'creator_id' =>  $this->input->post('creator_id'),
                'creator_name' =>  $this->input->post('creator_name'),
                'company' =>  $this->input->post('company'),
                'date' =>  $this->input->post('date'),
                'client_num' =>  $this->input->post('client_num'),
                'issue_num' => $this->input->post('issue_num'),
                'client_name' => $this->input->post('client_name'),
                'issue_kind' => $this->input->post('issue_kind'),
                'place' => $this->input->post('place'),
                'city' => $this->input->post('city'),
                'start_time' => $this->input->post('start_time'),
                'end_time' => $this->input->post('end_time'),
                'manager' => $this->input->post('manager'),
                'contact_name' => $this->input->post('contact_name'),
                'activity_text' => $this->input->post('activity_text'),
                'checking_text' => $this->input->post('checking_text'),
                'summary_text' => $this->input->post('summary_text'),
                'remarks_text' => $this->input->post('remarks_text'),
                'recommendations_text' => $this->input->post('recommendations_text'),
                'email_to' => $this->input->post('email_to'),
                'attachments' => $this->input->post('attachments'),
                'price' => $this->input->post('price'),
                'details' => $this->input->post('details'),
                'old_serial' => $this->input->post('old_serial'),
                'new_serial' => $this->input->post('new_serial')
            );
            foreach ($data as $key => &$str) {
                if (!$key == 'client_sign') {
                    $str = $this->cleanStr($str);
                }
            }
            if ($this->input->post('client_sign') != '') {
                $data += array('client_sign' => $this->input->post('client_sign'));
            }
            $response =  $this->Production_model->update_form($data);
            if ($response) {
                echo ' דוח ' .  $this->input->post('id') . ' נשמר בהצלחה! ';
                if ($this->input->post('client_num') != '') {
                    $data = array(
                        'client_num' => $this->input->post('client_num'),
                        'status' => 'working'
                    );
                    $this->Tickets_model->update($data);
                }
            } else {
                $msg = "אין אפשרות לשמור את הדוח! " . $this->input->post('id');
                $this->log_data($msg);
                echo $msg;
            }
        } else {
            echo "יש בעיה בפרטים שצריך למאלות!";
        }
    }

    function hide_filds($view_filds)
    {
        $view_filds = json_decode($view_filds, true);
        $hide_filds = '';
        if ($view_filds != '') {
            foreach ($view_filds as $name => $status) {
                if ($status) {
                    $hide_filds .= '#' . $name . ', ';
                }
            }
        }
        return $hide_filds;
    }

    public function manage_forms()
    {
        $this->load->library('pagination');
        $url = 'production/manage_forms/';
        $params = array();
        $params['creator'] = isset($_GET['creator']) ?  $_GET['creator'] : '';
        $params['company'] = isset($_GET['company']) ? $_GET['company'] : '';
        $params['year'] = isset($_GET['year']) ? $_GET['year'] : '';
        $params['month'] = isset($_GET['month']) ? $_GET['month'] : '';
        $params['date'] = isset($_GET['date']) ? $_GET['date'] : '';
        $limit_per_page = 40;
        $segment = 3;
        $start_index = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $total_records = $this->Production_model->get_total($params['creator'], $params['company'], $params['year'], $params['month'], $params['date']);
        if ($total_records > 0) {
            $params["results"] = $this->Production_model->get_current_forms_records($limit_per_page, $start_index, $params['creator'], $params['company'], $params['year'], $params['month'], $params['date']);
            $this->pagination->initialize($this->pagination_config($total_records, $limit_per_page, $url, $segment));
            $params["links"] = $this->pagination->create_links();
        }
        $params['users'] = $this->Users_model->getUsers();
        $params['companies'] = $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu', $params);
        $this->load->view('production/manage_forms', $params);
        $this->load->view('footer');
    }

    function pagination_config($total_records, $limit_per_page, $url, $segment)
    {
        $config = array();
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config["uri_segment"] = $segment;
        $config['full_tag_open'] = '<ul class="pagination right">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="page-item active "><a class="page-link" url="?creator=&company=">';
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
        return $config;
    }

    public function form_search()
    {
        $role = $this->session->userdata['logged_in']['role'];
        $this->form_validation->set_rules('search', 'Search', 'trim|xss_clean');
        $data = $this->Production_model->searchForm($this->input->post('search'));
        $str = '';
        $count = 0;
        foreach ($data as $form) {
            if ($role != 'Admin' && $form['creator_id'] != $this->session->userdata['logged_in']['id'])
                continue;
            $str .= "<a class='badge badge-info' href='/production/view_form/" . $form["id"] .
                "?issue=" . $form["issue_num"] . "'>" . urldecode($form["client_name"]) . ": " . date("d-m-Y", strtotime($form["date"])) . "</a>";
            $count++;
        }
        echo "<h2>מצאתי " . $count . " דוחות.</h2>" . $str;
    }

    public function delete_form()
    {
        $role = $this->session->userdata['logged_in']['role'];
        $this->form_validation->set_rules('id', 'Id', 'trim|xss_clean');
        $id = $this->input->post('id');
        if ($role == 'Admin') {
            $this->Production_model->deleteForm($id);
        }
    }

    public function save_photo()
    {
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
        print $success ? $file : 'Unable to save the file.';
    }


    public function delete_attachment()
    {
        $this->form_validation->set_rules('photo', 'Photo', 'trim|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $attachment = "./" . $this->input->post('attachment');
            if (!unlink($attachment)) {
                echo ($attachment . " cannot be deleted due to an error");
            } else {
                echo ($attachment . " has been deleted");
                $this->log_data('deleted ' . $this->input->post('attachment'), '', 3);
            }
        }
    }

    public function log_data($msg, $file_id = '', $level = 0)
    {
        date_default_timezone_set("Asia/Jerusalem");
        if (!file_exists('application/logs/admin')) {
            mkdir('application/logs/admin', 0770, true);
        }

        $level_arr = array('INFO', 'CREATE', 'TRASH', 'DELETE', 'ERROR');
        $user = $this->session->userdata['logged_in']['name'];

        $file_name = date("m-d-Y");
        $log_file = APPPATH . "logs/admin/" . $file_name . ".log";
        $fp = fopen($log_file, 'a');
        fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
        fclose($fp);

        if ($file_id != '') {
            if (!file_exists('Uploads/logs')) {
                mkdir('Uploads/logs', 0770, true);
            }
            $log_file = "Uploads/logs/" . $file_id . ".log";
            $fp = fopen($log_file, 'a');
            fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
            fclose($fp);
        }
    }

    public function get_log()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|xss_clean');
        $id = $this->input->post('id');
        $file = 'Uploads/logs/' . $id . '.log';
        if (!file_exists($file)) {
            $this->log_data('Log created', $id, $level = 1);
        }
        echo file_get_contents($file);
    }

    public function do_upload($id = '')
    {
        $upload_folder = "./Uploads/forms_attachments/" . $id;
        if (!file_exists($upload_folder)) {
            mkdir($upload_folder, 0770, true);
            copy('application/index.html', $upload_folder . 'index.html');
        }
        $config = array(
            'upload_path' => $upload_folder,
            'overwrite' => TRUE,
            'allowed_types' => '*', //'png|conf|xml|txt|jpeg|jpg|zip|rar|pdf',
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('files')) {
            $data = array('upload_data' => $this->upload->data());
            echo  $data['upload_data']["file_name"];
        } else {
            $error = "error " . $this->upload->display_errors();
            print_r($error);
        }
    }

    private function cleanStr($str)
    {
        // Remove anything which isn't a word, whitespace, number
        // or any of the following caracters -_~,;[]().:#
        // If you don't need to handle multi-byte characters
        // you can use preg_replace rather than mb_ereg_replace
        $str = mb_ereg_replace("([^\w\s\d\-_~,;:#\[\]\(\).])", '', $str); //allowed simbols
        // Remove any runs of periods
        $str = mb_ereg_replace("([\.]{2,})", '', $str);
        return htmlspecialchars($str);
    }

    function export_to($str = '1')
    {
        $role = $this->session->userdata['logged_in']['role'];
        $user = $this->security->xss_clean($this->input->get('creator'));
        $year = $this->security->xss_clean($this->input->get('year'));
        $company = $this->security->xss_clean($this->input->get('company'));
        $file_name = "froms_month_" . $str . "_" . $year . "_userid_" . $user . "_" . $company . ".csv";
        $data = $this->Production_model->getMonthFroms($str, $user, $year, $company);
        header('Content-Encoding: UTF-8');
        header("Content-type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=$file_name");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "\xEF\xBB\xBF";
        $fp = fopen('php://output', 'w');

        $tmp_arr = array(array('תאריך', 'יוצר', 'מספר לקוח', 'שם הלקוח', 'מיקום', 'סוג תקלה', 'חברה נותנת שירות', 'שעת התחלת', 'שעת סיום', 'הערות', 'סריאלי ישן', 'סריאלי חדש', 'מחיר'));
        $price = '';
        foreach ($data as  $line) {
            if ($role == 'Admin') {
                $price = $line['price'];
            }
            array_push($tmp_arr, array(
                $line['date'],
                $line['creator_name'],
                $line['client_num'],
                $line['client_name'],
                $line['place'],
                $line['issue_kind'],
                $line['company'],
                $line['start_time'],
                $line['end_time'],
                $line['details'],
                $line['old_serial'],
                $line['new_serial'],
                $price
            ));
        }
        foreach ($tmp_arr as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }

    public function create_script($company_id = 1)
    {
        $data = array();
        $this->load->view('header');
        $this->load->view('main_menu');
        $data['company_id']=$company_id;
        if (!file_exists('Uploads/tEditor/' . $company_id . '/template.txt')) {
            $data['no_template'] = true;
        }
        $this->load->view('production/script_editor', $data);
        $this->load->view('footer');
    }

    public function upload_template($company_id = 1)
    {
        $upload_folder = 'Uploads/tEditor';
        if (!file_exists($upload_folder . '/' . $company_id)) {
            mkdir($upload_folder . '/' . $company_id, 0770, true);
            copy('application/index.html', $upload_folder . '/' . $company_id . 'index.html');
        }
        $config = array(
            'upload_path' => $upload_folder . '/' . $company_id,
            'file_name' => 'template',
            'overwrite' => TRUE,
            'allowed_types' => 'txt|conf',
            'max_size' => "2048"
        );
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('files')) {
            $data = array('upload_data' => $this->upload->data());
            echo  $data['upload_data']["file_name"];
        } else {
            $error = "error " . $this->upload->display_errors();
            echo $error;
        }
    }

    function download_conf()
    {
        include_once APPPATH . 'third_party/tEditor/Template_editor.php';
        $this->form_validation->set_rules('client_num', 'client_num', 'trim|xss_clean');
        $this->form_validation->set_rules('client_name', 'client_name', 'trim|xss_clean');
        $this->form_validation->set_rules('phone_id', 'phone_id', 'trim|xss_clean');
        $this->form_validation->set_rules('manbas_ip', 'manbas_ip', 'trim|xss_clean');
        $this->form_validation->set_rules('pedagogy_ip', 'pedagogy_ip', 'trim|xss_clean');
        $this->form_validation->set_rules('wi_fi_ip', 'wi_fi_ip', 'trim|xss_clean');
        $this->form_validation->set_rules('wan_ip', 'wan_ip', 'trim|xss_clean');
        $this->form_validation->set_rules('clock_mac', 'clock_mac', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $user_id = $this->session->userdata['logged_in']['id'];
            $template = new Template_editor('Uploads/tEditor/' . $user_id . '/template.txt');
            $template->set('client_num', $this->input->post('client_num'));
            $template->set('client_name', str_replace(' ', '-', $this->input->post('client_name')));
            $template->set('phone_id', $this->input->post('phone_id'));
            $template->set('manbas_ip', $this->input->post('manbas_ip'));
            $template->set('pedagogy_ip', $this->input->post('pedagogy_ip'));
            $template->set('wi_fi_ip', $this->input->post('wi_fi_ip'));
            $template->set('wan_ip', $this->input->post('wan_ip'));
            $template->set('wan_ip_static', $this->prev_ip($this->input->post('wan_ip'))); // wan_ip - 1
            if ($this->input->post('clock_mac') != '') {
                $mac = trim(chunk_split($this->input->post('clock_mac'), 2, ':'));
                $template->set('clock_mac', substr($mac, 0, -1));
            } else {
                $template->set('clock_mac', '00:17:61:10:00:00');
            }
            $data = $template->render();
            $file_name = $this->input->post('client_num') . '_' . $this->input->post('client_name') . '_40F.conf';
            $myfile = fopen($file_name, "w") or die("Unable to open file!");
            fwrite($myfile, $data);
            fclose($myfile);
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Type: application/text");
            header("Content-Transfer-Encoding: binary");
            // read the file from disk
            readfile($file_name);
            unlink($file_name);
        }
    }

    function prev_ip($ip = '192.168.1.1')
    {
        $ip_arr = explode('.', $ip);
        end($ip_arr);
        $ip_arr[key($ip_arr)] -= 1;
        return implode('.', $ip_arr);
    }
}
