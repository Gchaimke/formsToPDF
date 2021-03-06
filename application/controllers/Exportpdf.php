<?php
require_once APPPATH . 'third_party/tcPDF/tcpdf.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Exportpdf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Production_model');
        $this->load->model('Users_model');
        $this->load->model('Companies_model');
        $this->load->model('Admin_model');
    }

    public function create($id = '1')
    {
        $send_email = false;
        if (isset($_POST['email'])) {
            $send_email = $_POST['email'];
        }
        $add_attachments = false;
        if (isset($_POST['add_attachments'])) {
            $add_attachments = $_POST['add_attachments'];
        }

        $form = array();
        $form = $this->Production_model->getForm($id)[0];
        if (isset($this->Companies_model->getCompanies('', $form['company'])[0])) {
            $company = $this->Companies_model->getCompanies('', $form['company'])[0];
        } else {
            $company = $this->Companies_model->getCompanies()[0];
        }
        $creator =  $this->Users_model->getUser($form['creator_id'])[0];

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $form['date'] = date("d-m-Y", strtotime($form['date']));
        $file_name = $form['date'] . '_' . $company['name'] . '_' . $form['client_num'] . '_' . $form['client_name'] . '_' . $form['place'];

        // Remove anything which isn't a word, whitespace, number
        // or any of the following caracters -_~,;[]().
        $file_name = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file_name);
        // Remove any runs of periods
        $file_name = mb_ereg_replace("([\.]{2,})", '', $file_name);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($file_name);
        $pdf->SetSubject('-פנימי-');
        $pdf->setMyHeader($company['logo'], $company['form_header'], $company['form_footer']);

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
        // print standard ASCII chars
        $pdf->SetFont('dejavusans', '', 10, '', true);
        $pdf->AddPage();
        $pdf->setRTL(true);
        $pdf->SetY(25);
        $html = '<h1>דו"ח סיכום פעילות</h1>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

        $pdf->SetY(40);

        $lables_array = array(
            'date' => 'תאריך:',
            'creator_name' => 'טכנאי:',
            'client_num' => 'מס. לקוח:',
            'issue_num' => 'מס. פניה\תקלה:',
            'client_name' => 'שם לקוח:',
            'issue_kind' => 'סוג תקלה\ התקנה:',
            'place' => 'מיקום',
            'city' => 'עיר',
            'start_time' => 'שעת התחלה:',
            'end_time' => 'שעת סיום:',
            'manager' => 'אחראי',
            'contact_name' => 'איש קשר:',
            'activity_text' => 'תיאור תקלה\ התקנה:',
            'checking_text' => 'תוצאות הבדיקה:',
            'summary_text' => 'סיכום',
            'remarks_text' => 'הערות:',
            'recommendations_text' => 'המלצות:',
            'old_serial' => 'מספר סריאלי - ישן',
            'new_serial' => 'מספר סריאלי - חדש',
            'attachments' => 'קבצים להורדה:',
            'client_sign' => 'חתימת לקוח:',
        );

        $html = '<table style="width:950px" cellpadding="5" cellspacing="1" border="1">';
        foreach ($lables_array as $key => $row) {
            if (isset($form[$key]) && $form[$key] != '') {
                if ($key == 'start_time' || $key == 'end_time') {
                    if ($form['start_time'] != '00:00:00' || $form['end_time'] != '00:00:00') {
                        $html .= $this->print_time($form[$key], $lables_array[$key]);
                        continue;
                    } else {
                        continue;
                    }
                }
                if ($key == 'activity_text' || $key == 'checking_text' || $key == 'summary_text' || $key == 'remarks_text' || $key == 'recommendations_text') {
                    $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:14px;">' . $lables_array[$key] . '</td>
                                <td>' . $this->hebrewFix($form[$key]) . '</td></tr>';
                    continue;
                }
                if ($key == 'attachments') {
                    $html .= $this->print_attachments($form[$key], $lables_array[$key]);
                    continue;
                }
                if ($key == 'client_sign') {
                    $html .= $this->print_client_sign($form[$key], $lables_array[$key]);
                    continue;
                }
                $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:14px;">' . $lables_array[$key] . '</td>
                    <td style="direction:rtl;">' . $form[$key] . '</td>
                    </tr>';
            }
        }
        $html .= '</table>';
        //die($html);
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, 'R', true);

        if ($send_email) {
            define('UPLOAD_DIR',  FCPATH . '/Uploads/PDF/');
            $pdf_file = UPLOAD_DIR . $file_name . '.pdf';
            if (!file_exists(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0770, true);
            }
            $pdf->Output($pdf_file, 'F');
            chmod($pdf_file, 0664);
            $attachments = array($pdf_file);
            if (!empty($pdf_file)) {
                if ($add_attachments == 'yes' && $form['attachments'] != '') {
                    $form_att_arr = explode(',', $form['attachments']);
                    foreach ($form_att_arr as $att) {
                        array_push($attachments, $att);
                    }
                }
                $this->SendEmail($attachments, $file_name,  $form['email_to'], $creator, $id, $company['name']);
            } else {
                print_r('Could not trace file path');
            }
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
        if (isset($tmp_image) and file_exists($tmp_image)) {
            unlink($tmp_image);
        }
    }

    function print_time($time, $lable)
    {
        return '<tr><td style="width:160px;font-weight:bolder;font-size:14px;">' . $lable . '</td>
            <td>' . date('G:i', strtotime($time)) . '</td></tr>';
    }

    function print_attachments($attachments, $lable)
    {
        $html = '';
        $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:14px;">' . $lable . '</td>';
        $html .= '<td style="text-align:left;">';
        $form_att_arr = explode(',', $attachments);
        foreach ($form_att_arr as $att) {
            $attachment_name_array = explode('/', $att);
            $attachment_name = end($attachment_name_array); //get last array element
            $html .= '<a target="blank" href="http://' . $_SERVER['SERVER_NAME'] . '/' . $att . '" dir="ltr">' . $attachment_name . '</a><br/>';
        }
        $html .= '</td></tr>';
        return $html;
    }

    function print_client_sign($client_sign, $lable)
    {
        $html = '';
        $sign_dir =  FCPATH . '/Uploads/tmp/';
        if (!file_exists($sign_dir)) {
            mkdir($sign_dir, 0770, true);
            copy('application/index.html', $sign_dir . 'index.html');
        }
        $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:14px;">' . $lable . '</td>';
        $imgdata = base64_decode($client_sign);
        $img_base64_encoded = "data:image/png;base64," . $client_sign;
        $imageContent = file_get_contents($img_base64_encoded);
        $tmp_image = tempnam($sign_dir, 'prefix');
        file_put_contents($tmp_image, $imageContent);
        if ($imgdata != '') {
            $html .= '<td><div style="position:relative;text-align:left;left:0;"><img  style="width:200px;" src="' . $tmp_image . '" alt="client_sign"/></div></td></tr>';
        }
        return $html;
    }

    function hebrewFix($string)
    {
        //fix for new line in forms
        $needles = array("<br>", "&#13;", "<br/>", "\n");
        $replacement = "<br />";
        $string = str_replace($needles, $replacement, $string);
        $arr = explode($replacement, $string);
        $out = '';
        $regex = '~(:\w+)~';
        foreach ($arr as $line) {
            $words = explode(" ", $line);
            foreach ($words as $word) {
                if (preg_match('/[^A-Za-z0-9]/', substr($word, 0, 1)) === 1) {
                    $out .= " "  . $word; //if word not start from english or digit just add to string
                } else if ($word == '') {
                    $out .= "";
                } else {
                    $out .= " " . "׳" . $word; //if not hebrew add tag before
                }
            }
            $out .= " " . $replacement;
        }
        return $out;
    }

    function SendEmail($attachments, $file_name, $recipients, $creator, $id = 1, $company_name = '')
    {
        $this->load->library('email');
        $settings = $this->Admin_model->getSettings()[0];
        $sender = 'yossigorbov@garin.co.il';
        if ($recipients == '') {
            $recipients = $creator['email'];
        } else {
            $recipients .= $creator['email'];
        }
        if ($settings['emails'] != '') {
            $recipients .= ',' . $settings['emails'];
        }
        if ($settings['smtp_on'] == 1) {
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $settings['smtp_host'];
            $config['smtp_user'] = $settings['smtp_user'];
            $config['smtp_pass'] = $settings['smtp_pass'];
            $config['smtp_port'] = $settings['smtp_port'];;
            $this->email->initialize($config);
            $sender = $settings['smtp_user'];
        }
        $Subject = $file_name;
        $Message = '';
        $this->email
            ->from($sender, 'דוח חדש - ' . $company_name . ' - ' . $creator['view_name'])
            ->to($recipients)
            ->bcc($creator['email'])
            ->subject($Subject)
            ->message($Message);
        foreach ($attachments as $att) {
            $this->email->attach($att);
        }
        if ($this->email->send()) {
            $msg = "מייל נשלח ל:  " . $recipients . " בהצלחה!";
            $this->log_data($msg, $id);
            print_r($msg);
        } else {
            $error = $this->email->print_debugger();
            $msg = strtok($error, '.');
            $this->log_data($msg, $id, 4);
            print_r($msg);
        }
        $this->email->clear(TRUE);
    }

    public function log_data($msg, $file_id = '', $level = 0)
    {
        date_default_timezone_set("Asia/Jerusalem");
        if (!file_exists('application/logs/admin')) {
            mkdir('application/logs/admin', 0770, true);
            copy('application/index.html', 'application/logs/admin/index.html');
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
                copy('application/index.html', 'Uploads/logs/index.html');
            }
            $log_file = "Uploads/logs/" . $file_id . ".log";
            $fp = fopen($log_file, 'a');
            fwrite($fp, $level_arr[$level] . " - " . date("H:i:s") . " --> " . $user . " - " . $msg . PHP_EOL);
            fclose($fp);
        }
    }

    public static function hebrew_fix($FieldName, &$CurrVal, &$CurrPrm)
    {
        $CurrVal = '</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:rtl/></w:rPr><w:t>' . $CurrVal . '</w:t></w:r><w:r><w:t>';
    }

    public function export_doc($id = '')
    {

        if ($id != '') {
            $form = $this->Production_model->getForm($id);
            $creator =  $this->Users_model->getUser($form[0]['creator_id'])[0];
            $creator_name = $creator['view_name'];
            $form[0] += ["creator" => $creator_name];
            include_once APPPATH . 'third_party/OpenTBS/tbs_plugin_opentbs.php';
            include_once APPPATH . 'third_party/OpenTBS/tbs_class.php';
            $template = './Uploads/DOC/' . $form[0]['company'] . '.docx';
            if (!file_exists('./Uploads/DOC/')) {
                mkdir('./Uploads/DOC/', 0770, true);
                copy('application/index.html', 'Uploads/DOC/index.html');
            }
            if (!@file_exists($template)) {
                copy('./assets/doc/template.docx', $template);
            }
            $TBS = new clsTinyButStrong;
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
            $TBS->MergeBlock('c', $form);
            $save_as = ''; //download file, set 1 to save.
            //$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
            //$output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $template);
            $output_file_name =  date('Y-m-d') . '_' . $form[0]['company'] . '.docx';
            if ($save_as === '') {
                // Output the result as a downloadable file (only streaming, no data saved in the server)
                $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
                // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
                exit();
            } else {
                // Output the result as a file on the server.
                $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
                // The script can continue.
                exit("File [$output_file_name] has been created.");
            }
        } else {
            echo "Form not Found";
        }
    }
}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    public function setMyHeader($logo, $header, $footer)
    {
        $this->logo = '.' . $logo;
        $this->header = $header;
        $this->footer = $footer;
    }
    //Page header
    public function Header()
    {
        // Logo
        $image_file = $this->logo;
        $style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        $this->SetAlpha(0.6);
        $this->Line(10, 10, 200, 10, $style);
        $this->Image($image_file, 10, 10.5, 30, '', '', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('dejavusans', '', 10, '', true);
        $this->SetTextColor(0, 0, 0);
        // Title
        $this->SetY(13);
        $this->Cell(0, 0, $this->header, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        $cur_y = $this->y - 12;
        $this->footer_line_color = array(0, 0, 0);
        $this->footer_text_color = array(0, 0, 0);
        // footer text

        //set style for cell border
        $this->SetAlpha(0.6);
        $this->SetY($cur_y);
        $line_width = (0.35 / $this->k);
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
        $this->SetFont('dejavusans', '', 8, '', true);

        $this->SetTextColorArray($this->footer_text_color);
        $this->SetY($cur_y + 1);
        //Print page number
        $this->SetX($this->original_rMargin);
        $this->MultiCell(180, 15, $this->footer, 'T', 'C', 0, 1, '', '', true);

        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';
        if (empty($this->pagegroups)) {
            $pagenumtxt =  $w_page . $this->getAliasNumPage() . '/' . $this->getAliasNbPages();
        } else {
            $pagenumtxt =  $w_page . $this->getPageNumGroupAlias() . '/' . $this->getPageGroupAlias();
        }
        $this->writeHTMLCell('', '', '', '', $pagenumtxt, 0, 0, 0, true, 'L', true);
    }
}
