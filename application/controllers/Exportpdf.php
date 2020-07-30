<?php
require_once APPPATH . 'third_party/tcPDF/tcpdf.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Exportpdf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
        $this->load->model('Admin_model');
        $this->load->model('Users_model');
        $this->load->model('Companies_model');
    }

    public function create($id = '1')
    {
        $send_email = false;
        if (isset($_POST['email'])) {
            $send_email = $_POST['email'];
        }

        //fix for new line in forms
        $needles = array("<br>", "&#13;", "<br/>", "\n");
        $replacement = "<br />";

        $form = array();
        $form = $this->Admin_model->getForm($id)[0];
        $form['company_data'] = $this->Companies_model->getCompanies('', $form['company'])[0];
        $company = $form['company_data'];

        $add_trip = "<br/> נסיעה:";
        $add_trip .= "<br/> הלוך: " . date('G:i', strtotime($form['trip_start_time'])) . " - " . date('G:i', strtotime($form['trip_end_time']));
        $add_trip .= "<br/> חזור: " . date('G:i', strtotime($form['back_start_time'])) . " - " . date('G:i', strtotime($form['back_end_time']));

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $file_name = $form['date'] . ' ' . $form['issue_num'] . ' ' . $form['client_name'];
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
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->setRTL(true);
        $pdf->SetY(30);
        // Set some content to print
        $html = '<h1>דו"ח סיכום פעילות</h1>';
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

        $pdf->SetY(50);
        $html = '<table style="width:950px" cellpadding="5" cellspacing="1" border="1">
        <tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">תאריך:</td>
        <td>' . $form['date'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">מס. לקוח:</td>
        <td>' . $form['client_num'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">מס. פניה\תקלה:</td>
        <td>' . $form['issue_num'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">שם לקוח: </td>
        <td>' . $form['client_name'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">סוג תקלה\ התקנה: </td>
        <td>' . $form['issue_kind'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">מיקום</td>
        <td>' . $form['place'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">שעת התחלה: </td>
        <td>' . date('G:i', strtotime($form['start_time'])) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">שעת סיום: </td>
        <td>' . date('G:i', strtotime($form['end_time'])) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">אחראי</td>
        <td>' . $form['manager'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">איש קשר: </td>
        <td>' . $form['contact_name'] . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">תיאור תקלה\ התקנה: </td>
        <td>' . str_replace($needles, $replacement, $form['activity_text']) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">תוצאות הבדיקה: </td>
        <td>' . str_replace($needles, $replacement, $form['checking_text']) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">סיכום</td>
        <td>' . str_replace($needles, $replacement, $form['summary_text']) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">הערות: </td>
        <td>' . str_replace($needles, $replacement, $form['remarks_text']) . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:13;">המלצות: </td>
        <td>' . str_replace($needles, $replacement, $form['recommendations_text']) . $add_trip . '</td>
        </tr></table>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, 'R', true);

        $html = '<b>חתימת לקוח:</b>';
        $pdf->writeHTMLCell('', '', 20, 240, $html, 0, 0, 0, true, 'R', true);

        //write sign border
        $pdf->writeHTMLCell('80', '30', 60, 230, '', 1 , 0, 0, true, 'R', true);

        $pdf->SetXY(135, 235);
        $imgdata = base64_decode($form['client_sign']);
        if ($imgdata != '') {
            $pdf->Image('@' . $imgdata, '', '', 70, '', '', '', 'T', false, 150, '', false, false, 0, false, false, false);
        }
        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$pdf->Output($file_name.'.pdf', 'I');

        //the option E: return the document as base64 mime multi-part email attachment (RFC 2045)
        if ($send_email) {
            define('UPLOAD_DIR',  FCPATH . '/Uploads/PDF/');
            $filePath = UPLOAD_DIR . $file_name . '.pdf';
            if (!file_exists(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0770, true);
            }
            $pdf->Output($filePath, 'F');
            chmod($filePath, 0664);
            if (!empty($filePath)) {
                $this->SendEmail($filePath, $file_name);
            } else {
                print_r('Could not trace file path');
            }
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    function SendEmail($fileatt, $file_name)
    {
        $user =  $this->Users_model->getUser($this->session->userdata['logged_in']['id'])[0];
        if ($user['email'] != '') {
            $this->load->library('email');
            $Subject = $file_name;
            $Message = 'Form sent from server ' . $_SERVER['SERVER_NAME'];
            $this->email
                ->from($user['email'], 'Online Forms - ' . $user['name'])
                ->to($user['email_to'] . ',' . $user['email'])
                ->subject($Subject)
                ->message($Message)
                ->attach($fileatt);

            if ($this->email->send()) {
                print_r('מייל נשלח ל:  ' . $user['email_to'] . ',' . $user['email'] . " בהצלחה!");
            } else {
                print_r($this->email->print_debugger());
            }
        } else {
            print_r('לא יכול לשלוח מייל, דואר משתמש לא מוגדר או אין רשימת תפוצה. ');
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
        $this->SetFont('dejavusans', '', 12, '', true);
        $this->SetTextColor(0, 0, 0);
        // Title
        $this->SetY(13);
        $this->Cell(0, 0, $this->header, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        $cur_y = $this->y - 15;
        $this->footer_line_color = array(0, 0, 0);
        $this->footer_text_color = array(0, 0, 0);
        // footer text

        //set style for cell border
        $this->SetAlpha(0.6);
        $this->SetY($cur_y);
        $line_width = (0.85 / $this->k);
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
        $this->SetFont('dejavusans', '', 10, '', true);

        $this->SetTextColorArray($this->footer_text_color);
        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';
        if (empty($this->pagegroups)) {
            $pagenumtxt = "עמוד " . $w_page . $this->getAliasNumPage() . ' מתוך ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = "עמוד " . $w_page . $this->getPageNumGroupAlias() . ' מתוך ' . $this->getPageGroupAlias();
        }
        $this->SetY($cur_y - 5);
        //Print page number
        $this->SetX($this->original_rMargin);
        $this->MultiCell(180, 20, $this->footer, 'T', 'C', 0, 1, '', '', true);
        $this->SetX($this->k / 2);
        $this->SetAlpha(1);
        $this->Cell(0, 0, $pagenumtxt, 0, 0, 'C');
    }
}
