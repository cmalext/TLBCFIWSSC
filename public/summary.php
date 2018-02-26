<?php
require('dist/fpdf/fpdf.php');
require('dist/fpdf/connect.php');
$ra = "SELECT * FROM clients WHERE id = '".$_GET['user']."'"; $a = mysql_query($ra);
if(mysql_num_rows($a)>0){
	while($ar = mysql_fetch_array($a)){
		//$pdf = new FPDF("P","mm", array(250,700));
		$pdf = new FPDF("P","mm", array(280,500));
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','b',9);
		$pdf->Cell('auto',4.5,strtoupper($ar['lastname'].', '.$ar['firstname'].' '.$ar['middlename']),0,0,1);
		$pdf->Ln(5);
		$pdf->Cell('auto',4.5,'# '.strtoupper($ar['meter_id']),0,0,1);
		$pdf->Ln(5);
		$pdf->SetTextColor(158, 38, 38);
		$pdf->Cell('auto',4.5,($ar['status']==0)?'RESIDENTIAL':'COMMERCIAL',0,0,1);
		$pdf->Ln(6);
		$pdf->SetFont('Helvetica','b',8);
		$pdf->Cell(30,10,'Billing',1,0,'C');
		$pdf->Cell(20,10,'Mtr. Rdg.',1,0,'C');
		$pdf->Cell(20,10,'Cu. M. Cons.',1,0,'C');
		$pdf->Cell(25,10,'Min. Bill',1,0,'C');
		$pdf->Cell(50,5,'Excess',1,0,'C');
		$pdf->Cell(25,10,'Extra',1,0,'C');
		$pdf->Cell(25,10,'Penalty',1,0,'C');
		$pdf->Cell(25,10,'TOTAL',1,0,'C');
		$pdf->Cell(20,10,'PAID',1,0,'C');
		$pdf->Cell(25,10,'REMARKS',1,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(95,5,'',0,0,1);
		$pdf->Cell(20,5,'Cu. M',1,0,'C');
		$pdf->Cell(30,5,'Amt',1,0,'C');
		$pdf->Ln(5);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Helvetica','b',7);
		$pdf->Cell(30,6,'MEMBERSHIP FEE',1,0,'C');
		$pdf->Cell(20,6,'',1,0,'C');
		$pdf->Cell(20,6,'',1,0,'C');
		$pdf->Cell(25,6,'',1,0,'C');
		$pdf->Cell(20,6,'',1,0,0);
		$pdf->Cell(30,6,'',1,0,0);
		$pdf->Cell(25,6,'',1,0,0);
		$pdf->Cell(25,6,'',1,0,0);
		$pdf->SetFont('courier','',7);
		$pdf->Cell(25,6,'PHP '.number_format($ar['membership'],2,'.',',').' ',1,0,0);
		$pdf->Cell(20,6,'YES',1,0,1);
		$pdf->Cell(25,6,'M-'.$ar['id'],1,0,1);
		$pdf->Ln(6);
		$total['billing'] = $ar['membership'];
		$total['consumption'] = 0;
		$total['unpaid'] = 0;
		$total['paid'] = $ar['membership'];

		$rb = "SELECT * FROM billings WHERE client = '".$_GET['user']."' ORDER BY month_year ASC"; $b = mysql_query($rb);
		if(mysql_num_rows($b)>0){
			while($br = mysql_fetch_array($b)){
				$show = 1;
				$extra = 0;
				$penalty = $br['penalty'];
				$rc = "SELECT * FROM extra_billings WHERE billing = '".$br['month_year']."' AND client = '".$_GET['user']."'"; $c = mysql_query($rc);
				if(mysql_num_rows($c)>0){
					while($cr = mysql_fetch_array($c)){
						$extra += $cr['total'];
					}
				}
				$final_total = $extra + $br['total'];
				if($vat >0 ){$final_total += ($final_total / 100)* $vat; }
				if($show == 1){
					$total['billing'] += $final_total + $penalty;
					if($br['status'] == 0){
						$total['unpaid'] += $final_total + $penalty;
					}else{
						$total['paid'] += $final_total + $penalty;
					}
					$total['consumption'] += $br['consumption'];
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,6,strtoupper(date("Y F",strtotime($br['month_year']))),1,0,'C');
					$meter_reading = 0;
					$rd = "SELECT * FROM billings WHERE client = '".$_GET['user']."'"; $d = mysql_query($rd);
					if(mysql_num_rows($d)>0){
						while($dr = mysql_fetch_array($d)){
							if(date("Y-m-d",strtotime($dr['month_year'])) <= date("Y-m-d",strtotime($br['month_year']))){
								$meter_reading += $dr['consumption'];
							}
						}
					}
					$excess = ($br['consumption'] - $br['unit_normal'] > 0)?$br['consumption'] - $br['unit_normal']:0;
					$pdf->SetFont('courier','',7);
					$pdf->Cell(20,6,$meter_reading,1,0,0);
					$pdf->Cell(20,6,$br['consumption'],1,0,0);
					$pdf->Cell(25,6,'PHP '.number_format($br['price_normal'],2,'.',',').' ',1,0,0);
					$pdf->Cell(20,6,$excess,1,0,0);
					$pdf->Cell(30,6,'PHP '.number_format($excess * $br['price_excess'],2,'.',',').' ',1,0,0);
					$pdf->Cell(25,6,'PHP '.number_format($extra,2,'.',',').' ',1,0,0);
					$pdf->Cell(25,6,'PHP '.number_format($penalty,2,'.',',').' ',1,0,0);
					//$pdf->Cell(40,6,number_format($br['total'],2,'.',',').' PHP',1,0,0);
					$pdf->Cell(25,6,'PHP '.number_format($final_total + $penalty,2,'.',',').' ',1,0,0);
					
					$pdf->Cell(20,6,($br['status']==0)?'NO':'YES',1,0,1);
					$pdf->Cell(25,6,($br['status']==0)?'':'#'.$br['id'],1,0,1);
					$pdf->Ln(6);	
				}			
			}
		}
		$pdf->Ln(0);
		$pdf->SetFont('Helvetica','b',7);
		$pdf->SetTextColor(158, 38, 38);
		$pdf->Cell(75,7,'',0,0,1);
		$pdf->Cell(95,7,'',0,0,0);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(45,7,'OVERALL CONSUMPTION : ',1,0,0);
		$pdf->Cell(50,7,' '.number_format($total['consumption'],1,'.','').' CUB. M.',1,0,0);
		$pdf->Ln(7);
		$pdf->Cell(75,7,'',0,0,1);
		$pdf->Cell(95,7,'',0,0,0);
		$pdf->SetTextColor(73, 173, 80);
		$pdf->Cell(45,7,'PAID AMOUNT : ',1,0,0);
		$pdf->Cell(50,7,'PHP '.number_format($total['paid'],2,'.',', ').' ',1,0,0);
		$pdf->Ln(7);
		$pdf->Cell(75,7,'',0,0,1);
		$pdf->Cell(95,7,'',0,0,0);
		$pdf->SetTextColor(158, 38, 38);
		$pdf->Cell(45,7,'UNPAID AMOUNT : ',1,0,0);
		$pdf->Cell(50,7,'PHP '.number_format($total['unpaid'],2,'.',', ').' ',1,0,0);
		$pdf->Ln(7);
		$pdf->Cell(75,7,'',0,0,1);
		$pdf->Cell(95,7,'',0,0,0);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(45,7,'OVERALL AMOUNT : ',1,0,0);
		$pdf->Cell(50,7,'PHP '.number_format($total['billing'],2,'.',', ').' ',1,0,0);
		$pdf->Ln(7);
	}
}
$pdf->Output();
?>
