<?php
if(isset($_GET['month'])){
	require('dist/fpdf/fpdf.php');
	require('dist/fpdf/connect.php');
	$dates = getDates();
	$pdf = new FPDF('P','mm',array(130,200));
	$pdf->SetMargins(5,0,5);  

	if(isset($_GET['client'])){
		$ra = "SELECT * FROM clients WHERE id = '".$_GET['client']."'";
	}else{
		$ra = "SELECT * FROM clients";
	}
	$a = mysql_query($ra);
	if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
			$rb = "SELECT * FROM billings WHERE client = '".$ar['id']."' AND month_year = '".$_GET['month']."'"; $b = mysql_query($rb);
			if(mysql_num_rows($b)>0){
				$rc = "SELECT * FROM billings WHERE month_year = '".date("Y-m",strtotime($_GET['month']."- 1 months"))."' AND client = '".$ar['id']."'"; $c = mysql_query($rc);
				if(mysql_num_rows($c)>0){
					$cr = mysql_fetch_array($c);
					$period['from'] = date("F d, Y",strtotime($cr['created_at']));
					$meter['previous'] = $cr['consumption'];
				}else{
					$period['from'] = date("F d, Y",strtotime($ar['created_at']));
					$meter['previous'] = 0;
				}
				$new = getPreviousMeterReadingTotal($ar['id'], $_GET['month']);
				$period['to'] = date("F d, Y",strtotime($ar['created_at']));
				$meter['present'] = 0;
				$price['total'] = 0;
				while($br = mysql_fetch_array($b)){
					if($br['month_year'] == $_GET['month']){
						$penalty = $br['penalty'];
						$period['to'] = date("F d, Y",strtotime($br['created_at']));
						$meter['present'] = $br['consumption'];
						$price['total'] = $br['total'];
						$extra = 0;
						$consumable['reg']['consume'] = ($br['consumption'] < $br['unit_normal'])?$br['consumption']:$br['unit_normal'];
						$consumable['reg']['price'] = $br['price_normal'];
						$consumable['ext']['consume'] = ($br['consumption'] > $br['unit_normal'])?($br['consumption'] - $br['unit_normal']):0;
						$consumable['ext']['price'] = ($br['consumption'] > $br['unit_normal'])?($br['consumption'] - $br['unit_normal'])*($br['price_excess'] / $br['unit_excess']):0;
						$rc = "SELECT * FROM extra_billings WHERE billing = '".$_GET['month']."' and client = '".$ar['id']."'"; $c = mysql_query($rc);
						if(mysql_num_rows($c)>0){
							while($cr = mysql_fetch_array($c)){
								$extra += $cr['total'];
							}
						}	
					}
				}
				$final_total = $extra + $price['total'];
				$pdf->AddPage();
				$pdf->SetFont('Helvetica','b',10);
				$pdf->Ln(5);
				$pdf->Cell('auto',5,'TLBC - LWSSC',0,0,'C');
				$pdf->Ln(5);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell('auto',5,'BLISS LAPAZ, BOGO CITY ',0,0,'C');
				$pdf->Ln(5);
				$pdf->SetFont('Helvetica','bu',10);
				$pdf->Cell('auto',5,'WATER BILL',0,0,'C');
				$pdf->Ln(7);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(35,5,'CLIENT NAME            ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$ar['lastname'].', '.$ar['firstname'].' '.$ar['middlename'].'',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(35,5,'',0,0,1);
				$pdf->Cell(83,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(35,5,'METER SERIAL NO.  ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$ar['meter_id'],0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(35,5,'',0,0,1);
				$pdf->Cell(83,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(35,5,'CLASSIFICATION      ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,($ar['type']==0)?'Residential':'Commercial',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(35,5,'',0,0,1);
				$pdf->Cell(83,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(35,5,'PERIOD COVERED   ',0,0,1);
				$pdf->SetFont('Helvetica','b',6);
				$pdf->Cell(14,5,'FROM : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(28,5,date("M d, Y",strtotime($period['from'])),0,0,1);
				$pdf->SetFont('Helvetica','b',6);
				$pdf->Cell(14,5,'TO : ',0,0,'C');
				$pdf->SetFont('courier','',7);
				$pdf->Cell(28,5,date("M d, Y",strtotime($period['to'])),0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(35,5,' ',0,0,1);
				$pdf->Cell(14,5,'',0,0,1);
				$pdf->Cell(28,0,'',1,0,1);
				$pdf->Cell(14,5,'',0,0,1);
				$pdf->Cell(27,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(35,5,'METER READING      ',0,0,1);
				$pdf->SetFont('Helvetica','b',6);
				$pdf->Cell(14,5,'PRESENT : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(28,5,$consumable['reg']['consume'] + $consumable['ext']['consume'] + $new .' Cu. M.',0,0,1);
				$pdf->SetFont('Helvetica','b',6);
				$pdf->Cell(14,5,'PREVIOUS : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,$new.' Cu. M.' ,0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(35,5,'',0,0,1);
				$pdf->Cell(14,5,'',0,0,1);
				$pdf->Cell(27,0,'',1,0,1);
				$pdf->Cell(15,5,'',0,0,1);
				$pdf->Cell(27,0,'',1,0,1);
				$pdf->Ln(7);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell('auto',5,'EXTRA BILLING ',1,0,'C');
				$pdf->Ln(5);
				$pdf->Cell(80,5,'DETAILS',1,0,'C');
				$pdf->Cell(40,5,'AMOUNT ',1,0,'C');
				$rc = "SELECT * FROM extra_billings WHERE client = '".$ar['id']."' AND billing = '".$_GET['month']."'"; $c = mysql_query($rc);
				if(mysql_num_rows($c)>0){
					$pdf->SetFont('courier','',7);
					while($cr = mysql_fetch_array($c)){
						$pdf->Ln(5);
						$pdf->Cell(80,5,$cr['description'],1,0,1);
						$pdf->Cell(40,5,number_format($cr['total'],2,'.',',').' PHP',1,0,0);	
					}
				}
				$pdf->Ln(10);
				$pdf->SetFont('Helvetica','bu',7);
				$pdf->Cell(50,5,'CUBIC METER CONSUMED : ',0,0,1);
				$pdf->Ln(7);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'MIN. BILL  ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,$consumable['reg']['consume'].' CUB. M.',0,0,1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'PRICE : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,number_format($consumable['reg']['price'],2,'.',',').' PHP',0,0,0);
				$pdf->Ln(4.5);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'EXCESS BILL',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,$consumable['ext']['consume'].' CUB. M.',0,0,1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'PRICE : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,number_format($consumable['ext']['price'],2,'.',',').' PHP',0,0,0);
				$pdf->Ln(4.5);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'EXTRA BILL ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,'',0,0,1);
				$pdf->SetFont('Helvetica','b',8);
				$pdf->Cell(20,5,' ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,number_format($extra,2,'.',',')  .' PHP',0,0,0);
				//$pdf->Cell(40,5,number_format($price['total'] + (($price['total'] / 100)*$vat),2,'.',',')  .' PHP',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',0,0,1);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				if($penalty > 0){
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(20,5,'PENALTY ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,'',0,0,1);
					$pdf->SetFont('Helvetica','b',8);
					$pdf->Cell(20,5,' ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,number_format($penalty,2,'.',',')  .' PHP',0,0,0);
					//$pdf->Cell(40,5,number_format($price['total'] + (($price['total'] / 100)*$vat),2,'.',',')  .' PHP',0,0,1);
					$pdf->Ln(4.5);
					$pdf->Cell(20,5,'',0,0,1);
					$pdf->Cell(39,0,'',0,0,1);
					$pdf->Cell(20,5,'',0,0,1);
					$pdf->Cell(39,0,'',1,0,1);
				}
				$pdf->Ln(2);
				if($vat > 0){
				$pdf->SetFont('Helvetica','b',8);
				$pdf->Cell(20,5,'VAT : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,'',0,0,1);
				$pdf->SetFont('Helvetica','b',8);
				$pdf->Cell(20,5,' ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,number_format($final_total+$penalty,2,'.',',')  .' PHP',0,0,0);
				//$pdf->Cell(40,5,number_format($price['total'] + (($price['total'] / 100)*$vat),2,'.',',')  .' PHP',0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',0,0,1);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Ln(1);
				}

				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(20,5,'TOTAL  ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(40,5,'',0,0,1);
				$pdf->SetFont('Helvetica','b',8);
				$pdf->Cell(20,5,' ',0,0,1);
				$pdf->SetFont('courier','b',7);
				$pdf->Cell(40,5,number_format($final_total + $penalty,2,'.',',')  .' PHP',0,0,0);
				$pdf->Ln(4);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',0,0,1);
				$pdf->Cell(20,5,'',0,0,1);
				$pdf->Cell(39,0,'',1,0,1);
				$pdf->Ln(2);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(45,5,'DUE DATE : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(100,5,$dates['due'],0,0,1);
				$pdf->Ln(4.5);
				$pdf->Cell(45,5,'',0,0,1);
				$pdf->Cell(73,0,'',1,0,1);
				$pdf->Ln(1);
				$pdf->SetFont('Helvetica','b',7);
				$pdf->Cell(45,5,'DISCONNECTION DATE : ',0,0,1);
				$pdf->SetFont('courier','',7);
				$pdf->Cell(73,5,$dates['cut'],0,0,1);
				$pdf->Ln(4);
				$pdf->Cell(45,5,'',0,0,1);
				$pdf->Cell(73,0,'',1,0,1);
			}
		}
	}
$pdf->Output();
}
?>
