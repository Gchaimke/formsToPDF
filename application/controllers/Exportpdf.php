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
        $this->load->model('Companies_model');
    }

    public function create($id = '1')
    {
        $send_email = false;
        if(isset($_POST['email'])){
            $send_email = $_POST['email'];
        }
        
        //$this->load->library('fpdf_master');
        $data = array();
        $data = $this->Admin_model->getForm($id)[0];
        $data['company_name'] = $this->Companies_model->getCompanies('', $data['company'])[0];
        //print_r($data['company']);
        $company = $data['company_name'];

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $file_name = $company['name'] . ' - ' . $data['date'] . ' - ' . $data['issue_num'] . ' ' . $data['client_name'];
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
        $pdf->SetFont('dejavusans', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->setRTL(true);
        $pdf->SetY(45);
        // Set some content to print
        $html = '<h1>דו"ח סיכום פעילות</h1>';

        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

        $html = '<table style="width:950px" cellpadding="5" cellspacing="1" border="1">
        <tr>
        <td style="width:160px;">תאריך:</td>
        <td>' . $data['date'] . '</td>
        </tr><tr>
        <td style="width:160px;">מס. לקוח:</td>
        <td>' . $data['client_num'] . '</td>
        </tr><tr>
        <td style="width:160px;">מס. פניה\תקלה:</td>
        <td>' . $data['issue_num'] . '</td>
        </tr><tr>
        <td style="width:160px;">שם לקוח: </td>
        <td>' . $data['client_name'] . '</td>
        </tr><tr>
        <td style="width:160px;">סוג תקלה\ התקנה: </td>
        <td>' . $data['issue_kind'] . '</td>
        </tr><tr>
        <td style="width:160px;">מיקום</td>
        <td>' . $data['place'] . '</td>
        </tr><tr>
        <td style="width:160px;">שעת התחלה: </td>
        <td>' . date('G:i', strtotime($data['start_time'])) . '</td>
        </tr><tr>
        <td style="width:160px;">שעת סיום: </td>
        <td>' . date('G:i', strtotime($data['end_time'])) . '</td>
        </tr><tr>
        <td style="width:160px;">אחראי</td>
        <td>' . $data['manager'] . '</td>
        </tr><tr>
        <td style="width:160px;">איש קשר: </td>
        <td>' . $data['contact_name'] . '</td>
        </tr><tr>
        <td style="width:160px;">תיאור תקלה\ התקנה: </td>
        <td>' . $data['activity_text'] . '</td>
        </tr><tr>
        <td style="width:160px;">תוצאות הבדיקה: </td>
        <td>' . $data['checking_text'] . '</td>
        </tr><tr>
        <td style="width:160px;">סיכום</td>
        <td>' . $data['summary_text'] . '</td>
        </tr><tr>
        <td style="width:160px;">הערות: </td>
        <td>' . $data['remarks_text'] . '</td>
        </tr><tr>
        <td style="width:160px;">המלצות: </td>
        <td>' . $data['recommendations_text'] . '</td>
        </tr><tr>
        <td style="width:160px;">שעת התחלה נסיעה הלוך: </td>
        <td>' . date('G:i', strtotime($data['trip_start_time'])) . '</td>
        </tr><tr>
        <td style="width:160px;">שעת סיום נסיעה חזור: </td>
        <td>' . date('G:i', strtotime($data['trip_end_time'])) . '</td>
        </tr></table>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, 'R', true);

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
                $EmailAddress = 'gchaimke@gmail.com';
                $this->SendEmail($EmailAddress, $filePath);
            } else {
                print_r('Could not trace file path');
            }
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    function SendEmail($EmailAddress, $fileatt)
    {
        $this->load->library('email');
        $Subject = 'Pdf test';
        $Message = 'open pdf to test';

        $this->email
            ->from('admin@forms.garin.co.il', 'Online Forms')
            ->to($EmailAddress)
            ->subject($Subject)
            ->message($Message)
            ->attach($fileatt);

        if ($this->email->send()) {
            print_r('Email Sent to ' . $EmailAddress);
        } else {
            print_r($this->email->print_debugger());
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
        $this->Line(10, 10, 200, 10, $style);
        $this->Image($image_file, 10, 10.5, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('dejavusans', '', 14, '', true);
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
        $this->SetY($cur_y);
        $line_width = (0.85 / $this->k);
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $this->footer_line_color));
        $this->SetFont('dejavusans', '', 10, '', true);

        $this->SetTextColorArray($this->footer_text_color);
        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';
        if (empty($this->pagegroups)) {
            $pagenumtxt = " דף " . $w_page . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = " דף " . $w_page . $this->getPageNumGroupAlias() . ' / ' . $this->getPageGroupAlias();
        }
        $this->SetY($cur_y - 5);
        //Print page number
        $this->SetX($this->original_rMargin);
        $this->MultiCell(180, 20, $this->footer, 'T', 'C', 0, 1, '', '', true);
        $this->SetX($this->k / 2);
        $this->Cell(0, 0, $pagenumtxt, 0, 0, 'C');
    }
}
