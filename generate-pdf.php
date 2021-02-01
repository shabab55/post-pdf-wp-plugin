<?php
/*
 * Template Name: Set This To Generate pdf
 */

	//header("Content-Type: application/json;charset=UTF-8");
	require('fpdf/fpdf.php');
	//use $_GET for grab url parameter.  
	//$title=$_GET['title'];
	//$content=$_GET['content'];
	
	//$file=wp_remote_retrieve_body(data);
	//$file=file_get_contents(data);
	
	$_POST['title'];
	var_dump($_POST['title']);
	die();

	class PDF_receipt extends FPDF {
		public $blog_title;
		public $blog_content;
		function __construct ($orientation = 'P', $unit = 'pt', $format = 'A4', $margin = 40) {
			parent::__construct($orientation, $unit, $format);
			$this->SetTopMargin($margin);
			$this->SetLeftMargin($margin);
			$this->SetRightMargin($margin);
			$this->SetAutoPageBreak(true, $margin);
		}
	
		function Header(){
			$this->SetFont('Arial', 'B', 15);
			$this->SetFillColor(36, 96, 84);
			$this->SetTextColor(225);
			$this->Cell(0, 30, "{$this->blog_title}", 0, 1, 'C', true);
		}
	
		function Footer() {
			$this->SetFont('Arial', '', 12);
			$this->SetTextColor(0);
			$this->SetXY(0,-30);
			$this->Cell(0, 20, "Thank you for using our Plugin", 'T', 0, 'C');
		}
	}
	
	$pdf = new PDF_receipt();
	$pdf->blog_title=$title;
	//$pdf->blog_content=$content;
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 12);
	
	$pdf->SetY(100);

	$pdf->Cell(100, 13, "Posted By");
	$pdf->SetFont('Arial', '');
	$pdf->Cell(100, 13, "Shabab");
	
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(90, 13, 'Posted Date');
	$pdf->SetFont('Arial', '');
	$pdf->Cell(100, 13, date('F j, Y'), 0, 1);
	
	$pdf->SetX(140);
	$pdf->SetFont('Arial', 'I');
	$pdf->Cell(200, 15, "1426 South Donia,Dhaka", 0, 2);
	$pdf->Cell(200, 15, 'Dhaka' . ', ' . 'Soniakra', 0, 2);
	$pdf->Cell(200, 15, '1426' . ' ' . 'Bangladesh');
	$pdf->Ln(100);
	
	$pdf->Ln(50);
	$blog_content =$content;
	$pdf->MultiCell(0, 15, $blog_content);
	
	$pdf->SetFont('Arial', 'U', 12);
	$pdf->SetTextColor(1, 162, 232);
	 
	$pdf->Write(13, "shabab@devshabab.com", "mailto:shabab@devshabab.com");
	/*
	// Send Headers
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="myPDF.pdf');
	
	// Send Headers: Prevent Caching of File
	header('Cache-Control: private');
	header('Pragma: private');
	header('Content-type: application/force-download');
	*/
	//$pdf_name=str_replace(' ','-',$blog_title);
	//$pdf_name=$pdf_name.'.pdf';
	//$pdf->Output($pdf_name,'D');
	$pdf->Output('I');



?>