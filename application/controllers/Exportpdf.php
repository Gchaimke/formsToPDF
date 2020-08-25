<?php
require_once APPPATH . 'third_party/tcPDF/tcpdf.php';

defined('BASEPATH') or exit('No direct script access allowed');

class Exportpdf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load model
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

        $form = array();
        $form = $this->Production_model->getForm($id)[0];
        if (isset($this->Companies_model->getCompanies('', $form['company'])[0])) {
            $company = $this->Companies_model->getCompanies('', $form['company'])[0];
        } else {
            $company = $this->Companies_model->getCompanies()[0];
        }

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $form_date = date("d-m-Y", strtotime($form['date']));
        $file_name = $form_date . '__' . $form['client_num'] . '__' . $form['client_name'] . '__' . $form['place'];

        // Remove anything which isn't a word, whitespace, number
        // or any of the following caracters -_~,;[]().
        // If you don't need to handle multi-byte characters
        // you can use preg_replace rather than mb_ereg_replace
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
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->setRTL(true);
        $pdf->SetY(25);
        // Set some content to print
        $html = '<h1>דו"ח סיכום פעילות</h1>';
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);

        $pdf->SetY(40);
        $html = '<table style="width:950px" cellpadding="5" cellspacing="1" border="1">
        <tr>
        <td style="width:160px;font-weight:bolder;font-size:11;">תאריך:</td>
        <td style="direction:rtl;">' . $form_date  . '</td>
        </tr><tr>
        <td style="width:160px;font-weight:bolder;font-size:11;">מס. לקוח:</td>
        <td>' . $form['client_num'] . '</td>
        </tr>';
        if ($form['issue_num'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">מס. פניה\תקלה:</td>
            <td>' . $form['issue_num'] . '</td></tr>';
        }
        if ($form['client_name'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">שם לקוח: </td>
            <td>' . $form['client_name'] . '</td></tr>';
        }
        if ($form['issue_kind'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">סוג תקלה\ התקנה: </td>
            <td>' . $form['issue_kind'] . '</td></tr>';
        }
        if ($form['place'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">מיקום</td>
            <td>' . $form['place'] . '</td></tr>';
        }
        $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">שעת התחלה: </td>
        <td>' . date('G:i', strtotime($form['start_time'])) . '</td></tr>
        <tr><td style="width:160px;font-weight:bolder;font-size:11;">שעת סיום: </td>
        <td>' . date('G:i', strtotime($form['end_time'])) . '</td></tr>';

        if ($form['manager'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">אחראי</td>
            <td>' . $form['manager'] . '</td></tr>';
        }
        if ($form['contact_name'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">איש קשר: </td>
            <td>' . $form['contact_name'] . '</td></tr>';
        }
        if ($form['activity_text'] != '') {
            $html .= ' <tr><td style="width:160px;font-weight:bolder;font-size:11;">תיאור תקלה\ התקנה: </td>
            <td>' . $this->hebrewFix($form['activity_text']) . '</td></tr>';
        }
        if ($form['checking_text'] != '') {
            $html .= ' <tr><td style="width:160px;font-weight:bolder;font-size:11;">תוצאות הבדיקה: </td>
            <td>' . $this->hebrewFix($form['checking_text']) . '</td></tr>';
        }
        if ($form['summary_text'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">סיכום</td>
            <td>' . $this->hebrewFix($form['summary_text']) . '</td></tr>';
        }
        if ($form['remarks_text'] != '') {
            $html .= '';
        }
        $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">הערות: </td>
            <td>' . $this->hebrewFix($form['remarks_text']) . '</td></tr>';

        if ($form['recommendations_text'] != '') {
            $html .= '<tr><td style="width:160px;font-weight:bolder;font-size:11;">המלצות: </td>
            <td>' . $this->hebrewFix($form['recommendations_text']) . '</td>
            </tr>';
        }
        $html .= '</table>';
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, 'R', true);

        if ($form['client_sign'] != '') {
            $html = '<b>חתימת לקוח:</b>';
            $pdf->writeHTMLCell('', '', 40, 250, $html, 0, 0, 0, true, 'R', true);
            //write sign border
            $pdf->writeHTMLCell(60, 25, 75, 240, '', 1, 0, 0, true, 'R', true);
            $pdf->SetXY(130, 245);
            $imgdata = base64_decode($form['client_sign']);
            if ($imgdata != '') {
                $pdf->Image('@' . $imgdata, '', '', '', 15, '', '', 'T', false, 150, '', false, false, 0, false, false, false);
            }
        }

        // ---------------------------------------------------------

        // Close and output PDF document

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
                if ($form['attachments'] != '') {
                    $form_att_arr = explode(',', $form['attachments']);
                    foreach ($form_att_arr as $att) {
                        array_push($attachments, $att);
                    }
                }
                $this->SendEmail($attachments, $file_name, $form['email_to']);
            } else {
                print_r('Could not trace file path');
            }
        } else {
            $pdf->Output($file_name . '.pdf', 'I');
        }
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

    function SendEmail($attachments, $file_name, $recipients)
    {
        $user =  $this->Users_model->getUser($this->session->userdata['logged_in']['id'])[0];
        $settings = $this->Admin_model->getSettings()[0];
        $sender = 'yossigorbov@garin.co.il';
        if ($user['email'] != '') {
            $recipients = $user['email'] . ',' . $recipients;
            $this->load->library('email');
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
            $Message = ''; //'Server: ' . $_SERVER['SERVER_NAME'];
            $this->email
                ->from($sender, 'דוח חדש - ' . $user['view_name'])
                ->to($recipients)
                ->subject($Subject)
                ->message($Message);
            foreach ($attachments as $att) {
                $this->email->attach($att);
            }

            if ($this->email->send()) {
                print_r('מייל נשלח ל:  ' . $recipients . " בהצלחה!");
            } else {
                print_r($this->email->print_debugger());
            }
        } else {
            print_r('לא יכול לשלוח מייל, דואר משתמש לא מוגדר או אין רשימת תפוצה. ');
        }
        $this->email->clear(TRUE);
    }

    public function export_doc($id = '')
    {
        global $CurrVal;
        if ($id != '') {
            $form = $this->Production_model->getForm($id);

            include_once APPPATH . 'third_party/OpenTBS/tbs_plugin_opentbs.php';
            include_once APPPATH . 'third_party/OpenTBS/tbs_class.php';

            $TBS = new clsTinyButStrong;
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            // -----------------
            // Load the template
            // -----------------

            $template = './Uploads/DOC/' . $form[0]['company'] . '.docx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

            // --------------------------------------------
            // Merging and other operations on the template
            // --------------------------------------------

            $list = array(
                array('date' => '2013-10-13', 'thin' => 156, 'havy' => 128, 'total' => 284)
            );
            $CurrVal = '</w:t></w:r><w:r><w:rPr><w:rFonts w:ascii="Arial" w:hAnsi="Arial" w:cs="Arial"/><w:rtl/></w:rPr><w:t>' . $CurrVal . '</w:t></w:r><w:r><w:t>';
            $TBS->MergeBlock('c', $form);
            // -----------------
            // Output the result
            // -----------------

            // Define the name of the output file
            $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
            $output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $template);
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
        $this->SetY($cur_y - 3);
        //Print page number
        $this->SetX($this->original_rMargin);
        $this->MultiCell(180, 15, $this->footer, 'T', 'C', 0, 1, '', '', true);

        $w_page = isset($this->l['w_page']) ? $this->l['w_page'] . ' ' : '';
        if (empty($this->pagegroups)) {
            $pagenumtxt =  $w_page . $this->getAliasNumPage() . '/' . $this->getAliasNbPages();
        } else {
            $pagenumtxt =  $w_page . $this->getPageNumGroupAlias() . '/' . $this->getPageGroupAlias();
        }
        //$this->SetX($this->k / 2);
        //$this->SetAlpha(1);
        $this->writeHTMLCell('', '', '', '', $pagenumtxt, 0, 0, 0, true, 'L', true);
    }
}
