<?php
if(isset($_GET['month'])){
	require('dist/fpdf/fpdf.php');
	require('dist/fpdf/connect.php');
	$pdf = new FPDF('P','mm',array(120,130));
	if(isset($_GET['client'])){
		$ra = "SELECT * FROM clients WHERE id = '".$_GET['client']."'"; $a = mysql_query($ra);
	}else{
		$ra = "SELECT * FROM clients"; $a = mysql_query($ra);
	}
	if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
			$rb = "SELECT * FROM billings WHERE client = '".$_GET['client']."' AND month_year = '".$_GET['month']."'"; $b = mysql_query($rb);
			if(mysql_num_rows($b)>0){
				while($br = mysql_fetch_array($b)){
					$extra = 0;
					$rc = "SELECT * FROM extra_billings WHERE billing = '".$br['month_year']."' AND client = '".$ar['id']."'"; $c = mysql_query($rc);
					if(mysql_num_rows($c)){
						while($cr = mysql_fetch_array($c)){
							$extra += $cr['total'];
						}
					}
					$final_total = $br['total']+ $extra;
					$pdf->AddPage();
					$pdf->SetMargins(5,5,5);  
					$pdf->SetDrawColor(8, 92, 19);
					$pdf->SetTextColor(8, 92, 19);
					$pdf->SetFont('Helvetica','b',11);
					$pdf->Cell('auto',-5,'LAPAZ WATER SERVICE and SANITATION COOPERATIVE',0,0,'C');
					$pdf->Ln(4.5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell('auto',-5,'   Bliss Lapaz, Bogo, Cebu Philippines ',0,0,1);
					$pdf->Ln(4);
					$pdf->Cell('auto',-5,'   CDA REG. No. 2676, NWRB Permit No. 329052',0,0,1);
					$pdf->Ln(-3.5);
					$pdf->SetTextColor(158, 38, 38);
					$pdf->SetFont('helvetica','bi',12);
					$pdf->Cell('auto',5,$br['id'],0,0,0);
					$pdf->Ln(6);
					$pdf->SetTextColor(8, 92, 19);
					$pdf->SetFont('Helvetica','b',11);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(75,5,'Date  : ',0,0,0);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(35,5,date("F d, Y",strtotime($br['updated_at'])),0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(75,5,'',0,0,1);
					$pdf->Cell(35,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,5,'RECIEVED from  : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(50,5,$ar['lastname'].', '.$ar['firstname'].' '.$ar['middlename'].'',0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(30,5,'',0,0,1);
					$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,5,'Address : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(80,5,$ar['address'],0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(30,5,'',0,0,1);
					$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,5,'the amount of : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(80,5,number_format($final_total + $br['penalty'],2,'.',',')." Pesos" ,0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(30,5,'',0,0,1);
					$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,5,'in payment of : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(80,5,date("F Y", strtotime($_GET['month'])). " Billing",0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(30,5,'',0,0,1);
					$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(3);
					$pdf->SetFont('Helvetica','bu',7);
					$pdf->Cell(30,5,' CONSUMPTION : ',0,0,1);
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'Reg. Bill : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,($br['consumption'] < $br['unit_normal'])?$br['consumption']:$br['unit_normal'].' Cub. M.',0,0,1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'Total : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,"PHP ".number_format($br['price_normal'],2,'.',','),0,0,1);
					$pdf->Ln(5);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',1,0,1);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',1,0,1);
					$pdf->Ln(2);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'Excess : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$test = ($br['consumption'] > $br['unit_normal'])?($br['consumption'] - $br['unit_normal']):0;
					$pdf->Cell(40,5,$test." Cub. M.",0,0,1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'Total : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5, "PHP ".number_format(($test > 0)? $test * ($br['price_excess'] / $br['unit_excess']):0  ,2,'.',',')."",0,0,1);
					$pdf->Ln(5);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',1,0,1);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',1,0,1);
					$pdf->Ln(2);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'Extra Bill : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,'',0,0,1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(15,5,'',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(40,5,"PHP ".number_format($extra,2,'.',',')." ",0,0,1);
					$pdf->Ln(5);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',0,0,1);
					$pdf->Cell(15,0,'',0,0,1);
					$pdf->Cell(40,0,'',1,0,1);
					if($br['penalty'] > 0){
						$pdf->Ln(2);
						$pdf->SetFont('Helvetica','b',7);
						$pdf->Cell(15,5,'Penalty : ',0,0,1);
						$pdf->SetFont('courier','',7);
						$pdf->Cell(40,5,'',0,0,1);
						$pdf->SetFont('Helvetica','b',7);
						$pdf->Cell(15,5,'',0,0,1);
						$pdf->SetFont('courier','',7);
						$pdf->Cell(40,5,"PHP ".number_format($br['penalty'],2,'.',',')." ",0,0,1);
						$pdf->Ln(5);
						$pdf->Cell(15,0,'',0,0,1);
						$pdf->Cell(40,0,'',0,0,1);
						$pdf->Cell(15,0,'',0,0,1);
						$pdf->Cell(40,0,'',1,0,1);
					}
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell('auto',5,'Payment in form of  ',0,0,1);
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(18,5,'  CASH : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(25,5,($br['payment_type']==1)?"PHP ".number_format($br['dynamic_number'],2,'.',',')." ":"",0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(18,5,'',0,0,1);
					$pdf->Cell(25,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(18,5,'  Change : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(25,5,"PHP ".number_format($br['dynamic_number'] - ($final_total + $br['penalty']),2,'.',',')." " ,0,0,1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(25,5,'PRINTED BY: ',0,0,0);
					$pdf->SetFont('courier','',7);
					$rc = "SELECT * FROM users WHERE id = '".$br['user']."'"; $c = mysql_query($rc); 
					$cr = mysql_fetch_row($c);
					$mname = (strlen($cr[3])>0)?$cr[3][0].'.':'';
					$pdf->Cell(42,5,$cr[1].', '.$cr[2].' '.$mname,0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(18,5,'',0,0,1);
					$pdf->Cell(25,0,'',1,0,1);
					$pdf->Cell(25,0,'',0,0,0);
					$pdf->Cell(42,0,' ',1,0,1);
					$pdf->Ln(1);

				}
			}
		}
	}





$pdf->Output();
}
?>
