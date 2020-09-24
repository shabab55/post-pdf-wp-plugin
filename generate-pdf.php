<?php
	require('fpdf/fpdf.php');

	$file=file_get_contents('php://input');
	$arr = json_decode($file,true);
	$arr=json_decode($arr,true);
	//print_r($arr["title"]);
	//die();
	class PDF_receipt extends FPDF {
		public $blog_title;
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
	$pdf->blog_title=$arr["title"];
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 12);
	
	$pdf->SetY(100);
	//$blog_title=$arr["title"];
	//$pdf->Header($blog_title);
	
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
	$message =$arr["content"];
	$pdf->MultiCell(0, 15, $message);
	
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
	$pdf_name=str_replace(' ','-',$arr["title"]);
	$pdf_name=$pdf_name.'.pdf';
	$pdf->Output($pdf_name,'D');
	//$pdf->Output('I');


?>