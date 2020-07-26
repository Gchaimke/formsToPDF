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
        $this->load->view('production/view_companies', $data);
        $this->load->view('footer');
    }

    public function new_form()
    {
        $this->load->view('header');
        $this->load->view('main_menu');
        $this->load->view('production/new_form');
        $this->load->view('footer');
    }


    public function save_form()
    {
        // Check validation for user input in SignUp form
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
        $this->form_validation->set_rules('trip_start_time', 'trip_start_time', 'trim|xss_clean');
        $this->form_validation->set_rules('trip_end_time', 'trip_end_time', 'trim|xss_clean');
        if (!$this->form_validation->run() == FALSE) {
            $data = array(
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
                'trip_start_time' => $this->input->post('trip_start_time'),
                'trip_end_time' => $this->input->post('trip_end_time')
            );
            $response =  $this->Production_model->save_form($data);
            if ($response) {
                echo "Form saved successfully!";
            } else {
                echo "Form Not saved! Issue Number exists!";
            }
        } else {
            echo "Form validation error!";
        }
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
        $log_file = APPPATH . "logs/admin/" . date("m-d-Y") . ".log";
        $fp = fopen($log_file, 'a'); //opens file in append mode  
        fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
        fclose($fp);
    }


    public function to_pdf($id = '1')
    {
        $this->load->library('fpdf_master');
        $data = array();
        $data = $this->Admin_model->getForm($id)[0];
        $data['company'] = $this->Companies_model->getCompanies('', $data['client_name'])[0];
        //print_r($data['company']);
        $company = $data['company'];

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/heb.php')) {
            require_once(dirname(__FILE__) . '/lang/heb.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->setRTL(true);
        // Set some content to print
        $html = <<<EOD
<h1 >שלום to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');
    }
}
