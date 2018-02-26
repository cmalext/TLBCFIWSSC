<?php
if(isset($_GET['month'])){
	require('dist/fpdf/fpdf.php');
	require('dist/fpdf/connect.php');
	$dates = getDates();
	$pdf = new FPDF('P','mm',array(90,143));
	$pdf->SetMargins(5,5,5);  
	if(isset($_GET['client'])){
		$ra = "SELECT * FROM clients WHERE id = '".$_GET['client']."'";
	}else{
		$ra = "SELECT * FROM clients";
	}
	$a = mysql_query($ra);
	if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
			$rb = "SELECT * FROM billings WHERE client = '".$ar['id']."' AND month_year = '".$_GET['month']."' AND status = 0"; $b = mysql_query($rb);
			if(mysql_num_rows($b)>0){

				$period['from'] = date("F d, Y",strtotime($ar['created_at']));
				$period['to'] = date("F d, Y",strtotime($ar['created_at']));
				$meter['present'] = 0;
				$meter['previous'] = 0;
				$price['total'] = 0;
				while($br = mysql_fetch_array($b)){
					if($br['month_year'] == $_GET['month']){
						$period['to'] = date("F d, Y",strtotime($br['created_at']));
						$meter['present'] = $br['consumption'];
						$price['total'] += $br['total'];
						$penalty = $br['penalty'];
						$rc = "SELECT * FROM extra_billings WHERE client = '".$ar['id']."' AND billing = '".$br['month_year']."'"; $c = mysql_query($rc);
						if(mysql_num_rows($c)>0){
							while($cr = mysql_fetch_array($c)){
								$price['total'] += $cr['total'];
							}
						}


					}
					if($br['month_year'] == date("Y-m",strtotime($_GET['month']."- 1 months"))){
						$period['from'] = date("F d, Y",strtotime($br['created_at']));
						$meter['previous'] = $br['consumption'] * 1000;
					}
				}
				$pdf->AddPage();
				$pdf->SetFont('Helvetica','b',10);
				$pdf->Cell('auto',5,'TLBC - LWSSC',0,0,'C');
				$pdf->Ln(6);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell('auto',5,' BLISS LA PAZ, BOGO CITY ',0,0,'C');
				$pdf->Ln(8);
				$pdf->SetFont('Arial','bu',10);
				$pdf->Cell('auto',5,'DISCONNECTION NOTICE',0,0,'C');
				$pdf->Ln(8);
				$name = $ar['lastname'].', '.$ar['firstname'];
				$pdf->SetFont('helvetica','',8);
				$pdf->Write(5,'       Good day Sir/Ma\'am '.$name.' upon receiving this letter, we are here to notify you that your outstanding balance hasn\'t been paid thus having you a penalty of '.number_format($penalty,2,'.',',').' PHP Please pay your outstanding balance before disconnection.');
				$pdf->Ln(8);
				$pdf->Write(5,'       Below is your billing information so you will be able to check what your remaining balance is. Have a nice day');
				
				$pdf->Ln(8);

				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(30,5,'Billing  : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$period['to'],0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(30,5,'',0,0,1);
				$pdf->Cell(50,0,'',1,0,1);
				$pdf->Ln(3);
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(30,5,'Meter Reading : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,getPreviousMeterReadingTotal($ar['id'],$_GET['month']) + $meter['present'].' Cu. M.',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(30,5,'',0,0,1);
				$pdf->Cell(50,0,'',1,0,1);
				$pdf->Ln(8);	
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(50,5,'Cubic Meter Consumed : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$meter['present'].' Cu. M.' ,0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(50,5,'',0,0,1);
				$pdf->Cell(30,0,'',1,0,1);
				$pdf->Ln(0);
				if($penalty > 0){
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(50,5,'Penalty : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,number_format($penalty,2,'.',',').' PHP',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(50,5,'',0,0,1);
				$pdf->Cell(30,0,'',1,0,1);
				}
				$pdf->Ln(0);
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(50,5,'Amount : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,number_format($price['total'] + $penalty,2,'.',',').' PHP',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(50,5,'',0,0,1);
				$pdf->Cell(30,0,'',1,0,1);
				$pdf->Ln(0);
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(50,5,'Due Date : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$dates['due'],0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(50,5,'',0,0,1);
				$pdf->Cell(30,0,'',1,0,1);
				$pdf->Ln(0);
				$pdf->SetFont('Arial','b',9);
				$pdf->Cell(50,5,'Disconnection Date : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$dates['cut'],0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(50,5,'',0,0,1);
				$pdf->Cell(30,0,'',1,0,1);
			}
		}
	}
$pdf->Output();
}
?>
