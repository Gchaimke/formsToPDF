<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tickets extends CI_Controller
{
    private $user;
    private $file_name;
    private $fields;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Admin_model');
        $this->load->model('Companies_model');
        $this->load->model('Production_model');
        $this->load->model('Tickets_model');
        if (isset($this->session->userdata['logged_in'])) {
            $this->user = $this->session->userdata['logged_in'];
        } else {
            header("location: /users/logout");
        }
        $this->file_name = 'Uploads/tmp/' . $this->user['id'] . '/last_uploaded.xlsx';
        $this->fields = array(
            'client_num' => 'מספר לקוח',
            'client_name' => 'שם לקוח',
            'address' => 'כתובת לקוח',
            'city' => 'עיר',
            'warehouse_num' => 'משימה למחסן'
        );
        $language = $this->session->userdata['logged_in']['language'];
		$this->lang->load('main', $language);
    }

    public function index()
    {
        $data = array();
        $data['creator'] = isset($_GET['creator']) ?  $_GET['creator'] : '';
        $data['company'] = isset($_GET['company']) ? $_GET['company'] : '';
        $data['city'] = isset($_GET['city']) ? $_GET['city'] : '';
        $data['status'] = isset($_GET['status']) ? $_GET['status'] : '';
        $data['tickets'] = $this->Tickets_model->get_all($data['creator'], $data['company'], $data['city'], $data['status']);
        $data['users'] =  $this->Users_model->getusers();
        $data['companies'] =  $this->Companies_model->getCompanies();
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('tickets/manage', $data);
        $this->load->view('footer');
    }

    public function import_xlsx()
    {
        if (!file_exists($this->file_name)) {
            $this->file_name = '';
        }
        $data = array();
        $this->load->view('header');
        $this->load->view('main_menu');
        include_once APPPATH . 'third_party/SimpleXLSX.php';
        if ($this->file_name != '') {
            if ($xlsx = SimpleXLSX::parse($this->file_name)) {
                $data['xlsx_columns'] = $this->get_xlsx_columns($xlsx);
                $data['fields'] = $this->fields;
                $this->load->view('tickets/import_xlsx', $data);
            } else {
                echo SimpleXLSX::parseError();
            }
        } else {
            $data['message_display'] = 'נא להעלות קובץ XLSX';
            $this->load->view('tickets/import_xlsx', $data);
        }
        $this->load->view('footer');
    }


    public function upload_xlsx($upload_folder = 'Uploads/tmp')
    {
        if (!file_exists($upload_folder . '/' . $this->user['id'])) {
            mkdir($upload_folder . '/' . $this->user['id'], 0770, true);
            copy('application/index.html', $upload_folder . '/' . $this->user['id'] . 'index.html');
        }
        $config = array(
            'upload_path' => $upload_folder . '/' . $this->user['id'],
            'file_name' => 'last_uploaded',
            'overwrite' => TRUE,
            'allowed_types' => 'xlsx|xls',
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

    function view_table()
    {
        $this->load->view('header');
        $this->load->view('main_menu');
        include_once APPPATH . 'third_party/SimpleXLSX.php';
        $data['companies'] = $this->Companies_model->getCompanies();
        $row_nums = array();
        foreach ($this->fields as $key => $value) {
            $row_nums[$key] = $this->input->post($key);
        }
        if ($xlsx = SimpleXLSX::parse($this->file_name)) {
            $data['html_table'] = $this->build_table($xlsx, $row_nums);
        }
        $this->load->view('tickets/import_table', $data);
        $this->load->view('footer');
    }

    function build_table($xlsx, $rows)
    {
        $html_table = '<div class="table-responsive"><table class="table"><thead class="thead-dark">';
        $i = 0;
        $count = 0;
        if (isset($xlsx)) {
            $columns = array('מספר לקוח', 'שם לקוח', 'כתובת לקוח', 'עיר', 'משימה למחסן');

            $html_table .= "<tr id='table_header'>";
            foreach ($columns as $column) {
                $html_table .= "<th>$column</th>";
            }
            $html_table .= "</tr></thead><tbody>";
            foreach ($xlsx->rows() as $row) {
                if ($i != 0 && count($rows) > 4) {
                    if (1 === preg_match('~[0-9]~', $row[$rows['warehouse_num']])) {
                        preg_match_all('!\d+!', $row[$rows['warehouse_num']], $matches);
                        $row[$rows['warehouse_num']] = $matches[0][0];
                    } else {
                        continue;
                    }
                    $html_table .= "<form class='tickets_row'><tr id='$row[0]' class='column'>";
                    foreach ($rows as $key => $value) {
                        $html_table .= "<td style='min-width:120px'>
                            <input type='hidden' name='$key' value='{$row[$value]}'>{$row[$value]}</td>";
                    }
                    $html_table .= "</tr></form>";
                    $count++;
                }
                $i++;
            }
            $msg = $count > 0 ? '' : 'פומרט של קובץ לא נכון, נא לבדוק קמות של פריטים בשורה';
            $html_table .= "</tbody></table></div>" . $msg;
        }
        return $html_table;
    }

    function get_xlsx_columns($xlsx)
    {
        $all_columns = array();
        foreach ($xlsx->rows() as $row) {
            foreach ($row as $key => $column) {
                $all_columns[$key] = $column;
            }
            break;
        }
        return $all_columns;
    }

    public function import($company_num = "")
    {
        $items = array();
        $tmp_s = '';
        $tmp_f = '';
        if (isset($_POST['items_array']) && $company_num != "") {
            foreach ($_POST['items_array'] as $line) {
                $sql_data = array();
                foreach ($line as $column) {
                    $sql_data += array($column['name'] => $column['value']);
                }
                $sql_data += array(
                    'company_id' => $company_num,
                    'status' =>  '0'
                );
                if ($this->Tickets_model->add($sql_data)) {
                    $tmp_s .= $sql_data['client_num'] . ',';
                } else {
                    $tmp_f .= $sql_data['client_num'] . ',';
                }
            }
            $items['inserted'] = explode(',', $tmp_s);
            $items['updated'] = explode(',', $tmp_f);
            print_r(json_encode($items));
        }
    }

    public function update($id = "")
    {
        $this->form_validation->set_rules('status', 'status', 'trim|xss_clean');
        $this->form_validation->set_rules('user_id', 'user_id', 'trim|xss_clean');
        if ($id != "") {
            $data = array(
                'id' => $id
            );
            if ($this->input->post('user_id') != '') {
                $data += array('creator_id' => $this->input->post('user_id'));
            }
            if ($this->input->post('status') != '') {
                $data += array('status' => $this->input->post('status'));
            }
            if ($this->Tickets_model->update($data)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }

    public function delete()
    {
        if ($this->user['role'] == "Admin") {
            $id = $_POST['id'];
            $this->Tickets_model->delete($id);
        }
    }
}
