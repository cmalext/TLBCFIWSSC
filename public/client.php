<?php
require('dist/fpdf/fpdf.php');
require('dist/fpdf/connect.php');
$pdf = new FPDF("L","mm", array(250,150));
$pdf->AddPage();
$pdf->SetFont('Helvetica','b',10);
if($_GET['status'] == 1){
		$status = 'DELETED';
	}else if($_GET['status'] == 0){
		$status = 'ACTIVE';
	}else if($_GET['status'] == 2){
		$status = 'CUTTED OFF';
	}else{
		$status = 'ALL';
	}
$pdf->Cell(25,7,$status.' CLIENT LIST',0,0,1);
$pdf->Ln(5);
if($_GET['type'] == 1){
		$pdf->SetTextColor(73, 173, 80);
		$type = 'COMMERCIAL';
	}else if($_GET['type'] == 0){
		$pdf->SetTextColor(158, 38, 38);
		$type = 'RESIDENTIAL';
	}else{
		$pdf->SetTextColor(39, 138, 171);
		$type = 'ALL';
	}
$pdf->Cell(25,7,'TYPE : '.$type,0,0,1);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);
$pdf->SetFont('Helvetica','b',8);
$status = ['Active', 'Deleted', 'Cutted Off'];
$a = mysql_query(client_query());
if(mysql_num_rows($a)>0){
	$pdf->Cell(25,7,'METER #',1,0,'C');
	$pdf->Cell(50,7,'CLIENT',1,0,'C');
	$pdf->Cell(65,7,'ADDRESS',1,0,'C');
	$pdf->Cell(25,7,'TYPE',1,0,'C');
	$pdf->Cell(25,7,'STATUS',1,0,'C');
	$pdf->Cell(40,7,'DATE STARTED',1,0,'C');
	$pdf->Ln(7);
	while($ar = mysql_fetch_array($a)){
		$pdf->SetFont('courier','',7);
		$pdf->Cell(25,7,$ar['meter_id'],1,0,0);
		$pdf->Cell(50,7,$ar['lastname'].', '.$ar['firstname'].' '.$ar['middlename'].'',1,0,1);
		$pdf->Cell(65,7,$ar['address'],1,0,1);
		$pdf->Cell(25,7,($ar['type']==0)?'Residential':'Commercial',1,0,1);
		$pdf->Cell(25,7,$status[$ar['status']],1,0,1);
		$pdf->Cell(40,7,date("F d, Y", strtotime($ar['created_at'])),1,0,1);
		$pdf->Ln(7);	
	}
}
$pdf->output();
?>
