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
        //$this->load->library('fpdf_master');
        $data = array();
        $data = $this->Admin_model->getForm($id)[0];
        $data['company'] = $this->Companies_model->getCompanies('', $data['client_name'])[0];
        //print_r($data['company']);
        $company = $data['company'];

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($company['name']);
        $pdf->SetSubject('-פנימי-');
        $pdf->setMyHeader($company['logo'],$company['form_header']);

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
        $pdf->SetFont('dejavusans', '', 11, '', true);

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

        $html ='<table style="width:1000px" cellpadding="5" cellspacing="1" border="0.2">
        <tr>
        <td style="width:150px;">תאריך:</td>
        <td>'.$data['date'].'</td>
        </tr><tr>
        <td style="width:150px;">מס. לקוח:</td>
        <td>'.$data['client_num'].'</td>
        </tr><tr>
        <td style="width:150px;">מס. פניה\תקלה:</td>
        <td>'.$data['issue_num'].'</td>
        </tr><tr>
        <td style="width:150px;">שם לקוח: </td>
        <td>'.$data['client_name'].'</td>
        </tr><tr>
        <td style="width:150px;">סוג תקלה\ התקנה: </td>
        <td>'.$data['issue_kind'].'</td>
        </tr><tr>
        <td style="width:150px;">מיקום</td>
        <td>'.$data['place'].'</td>
        </tr><tr>
        <td style="width:150px;">שעת התחלה: </td>
        <td>'.$data['start_time'].'</td>
        </tr><tr>
        <td style="width:150px;">שעת סיום: </td>
        <td>'.$data['end_time'].'</td>
        </tr><tr>
        <td style="width:150px;">אחראי</td>
        <td>'.$data['manager'].'</td>
        </tr><tr>
        <td style="width:150px;">איש קשר: </td>
        <td>'.$data['contact_name'].'</td>
        </tr><tr>
        <td style="width:150px;">תיאור תקלה\ התקנה: </td>
        <td>'.$data['activity_text'].'</td>
        </tr><tr>
        <td style="width:150px;">תוצאות הבדיקה: </td>
        <td>'.$data['checking_text'].'</td>
        </tr><tr>
        <td style="width:150px;">סיכום</td>
        <td>'.$data['summary_text'].'</td>
        </tr><tr>
        <td style="width:150px;">הערות: </td>
        <td>'.$data['remarks_text'].'</td>
        </tr><tr>
        <td style="width:150px;">המלצות: </td>
        <td>'.$data['recommendations_text'].'</td>
        </tr><tr>
        <td style="width:150px;">שעת נסיעה הלוך: </td>
        <td>'.$data['trip_start_time'].'</td>
        </tr><tr>
        <td style="width:150px;">שעת נסיעה חזור: </td>
        <td>'.$data['trip_end_time'].'</td>
        </tr></table>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, 'R', true);

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('example_001.pdf', 'I');
    }
}


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF
{
    public function setMyHeader($logo,$header)
    {
        $this->logo = '.' . $logo;
        $this->header = $header;
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
        $this->Cell(0, 0, $this->header , 0, false, 'R', 0, '', 0, false, 'M', 'M');        
    }
}
