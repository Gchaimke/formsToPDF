<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fpdf_master {
		
	public function __construct() {
		require_once APPPATH.'third_party/tcPDF/tcpdf.php';
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$CI =& get_instance();
		$CI->tcpdf = $pdf;
		
	}
	
}