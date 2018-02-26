<?php
require('dist/fpdf/fpdf.php');
require('dist/fpdf/connect.php');

if($_GET['type'] == 1){
	$start = date("Y-m",strtotime($_GET['start']));
	$end = date("Y-m",strtotime($_GET['end']));
	$pdf = new FPDF("L","mm", array(260,150));
	while($start <= $end){
		$pdf->AddPage();
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Helvetica','b',8);
		$pdf->Cell('auto',7,'MONTHLY PROFIT REPORT',0,0,1);
		$pdf->Ln(5);
		$pdf->Cell('auto',7,'MONTH : '.strtoupper(date("F Y",strtotime($start))),0,0,1);
		$pdf->Ln(5);
		if($_GET['status'] == 1){
			$pdf->SetTextColor(73, 173, 80);
			$type = 'TOTAL MONTHLY PROFIT';
		}else if($_GET['status'] == 0){
			$pdf->SetTextColor(158, 38, 38);
			$type = 'REMAINING PAYMENTS';
		}else{
			$pdf->SetTextColor(39, 138, 171);
			$type = 'OVERALL PAYMENT - PAID & UNPAID';
		}
		$pdf->Cell('auto',7,$type,0,0,1);
		$pdf->Ln(10);
		$total = [0,0];
		$pdf->SetFont('Helvetica','b',8);
		$pdf->SetTextColor(158, 38, 38);
		$pdf->Cell(50,10,'Client',1,0,'C');
		$pdf->Cell(20,10,'Mtr. Rdg.',1,0,'C');
		$pdf->Cell(20,10,'Cu. M. Cons.',1,0,'C');
		$pdf->Cell(25,10,'Min. Bill',1,0,'C');
		$pdf->Cell(50,6,'Excess',1,0,'C');
		$pdf->Cell(25,10,'Extra',1,0,'C');
		$pdf->Cell(25,10,'Penalty',1,0,'C');
		$pdf->Cell(25,10,'TOTAL',1,0,'C');
		$pdf->Ln(6);
		$pdf->SetFont('Helvetica','b',7);
		$pdf->Cell(115,0,'',0,0,1);
		$pdf->Cell(20,4,'Cu. M',1,0,'C');
		$pdf->Cell(30,4,'Amt',1,0,'C');
		$pdf->Ln(4);
		$pdf->SetTextColor(0,0,0);
		$extension = '';
		if($_GET['status'] < 2){
			$extension = "AND status = ".$_GET['status'];
		}
		$ra = "SELECT * FROM billings WHERE month_year = '".$start."' ".$extension; $a = mysql_query($ra);
		if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
			$rb = "SELECT * FROM clients WHERE id = '".$ar['client']."'"; $b = mysql_query($rb);
			if(mysql_num_rows($b)){
				$extra = 0;
				$re = "SELECT * FROM extra_billings WHERE client = '".$ar['client']."' AND billing = '".$ar['month_year']."'"; $e = mysql_query($re);
				if(mysql_num_rows($e)>0){
					while($er = mysql_fetch_array($e)){
						$extra += $er['total'];
					}
				}
				$meter_reading = 0;
				$pdf->SetFont('Helvetica','b',7);
				$br = mysql_fetch_array($b);
				$total[0] += $ar['consumption'];
				$total[1] += $ar['total'] + $extra + $ar['penalty'];
				$name = $br['lastname'].', '.$br['firstname'].' ';
				$name .= (strlen($br['middlename'])>0)?$br['middlename'][0].'.':'';
				$pdf->Cell(50,7,$name,1,0,'C');
				$rd = "SELECT * FROM billings WHERE client = '".$br['id']."'"; $d = mysql_query($rd);
				if(mysql_num_rows($d)){
					while($dr = mysql_fetch_array($d)){
						if(date("Y-m",strtotime($dr['month_year'])) <= $start){
							$meter_reading += $dr['consumption'];
						}
					}
				}
				$pdf->SetFont('courier','',7);
				$pdf->Cell(20,7,$meter_reading,1,0,0);
				$pdf->Cell(20,7,$ar['consumption'],1,0,0);
				$pdf->Cell(25,7,'PHP '.number_format($ar['price_normal'],2,'.',',').' ',1,0,0);
				$excess = ($ar['consumption'] - $ar['unit_normal'])<0?0:$ar['consumption'] - $ar['unit_normal'];
				$pdf->Cell(20,7,$excess,1,0,0);
				$pdf->Cell(30,7,'PHP '.number_format($excess * $ar['price_excess'],2,'.',',').' ',1,0,0);
				$pdf->Cell(25,7,'PHP '.number_format($extra,2,'.',',').' ',1,0,0);
				$pdf->Cell(25,7,'PHP '.number_format($ar['penalty'],2,'.',',').' ',1,0,0);
				$pdf->Cell(25,7,'PHP '.number_format($ar['total'] + $extra + $ar['penalty'],2,'.',',').' ',1,0,0);
				$pdf->Ln(7);	
			}	
		}
		}
		$pdf->SetFont('courier','b',7);
		if($_GET['status'] != 0){
			$memfee =  getMemFee('monthly', $_GET['status'], date("Y-m",strtotime($start)));
			$pdf->Cell(175,8,' ',0,0,0);
			$pdf->Cell(25,8,'MEMBERSHIP FEE :',1,0,'C');
			$pdf->Cell(40,8,'PHP '.number_format($memfee,2,'.',',').' ',1,0,0);
			$pdf->Ln(8);
		}else{
			$memfee = 0;
		}
		$pdf->SetTextColor(73, 173, 80);
		$pdf->Cell(175,8,' ',0,0,0);
		$pdf->Cell(25,8,'TOTAL AMOUNT :',1,0,0);
		$pdf->Cell(40,8,'PHP '.number_format($total[1] + $memfee,2,'.',',').' ',1,0,0);
		$pdf->Ln(7);
		$start = date("Y-m",strtotime($start."+ 1 months"));
	}
	$pdf->output();
}else{
	$start = $_GET['syear'];
	$end2 = $_GET['eyear'];
	$pdf = new FPDF("L","mm", array(260,150));
	while($start <= $end2){
		$pdf->AddPage();
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Helvetica','b',8);
		$pdf->Cell('auto',7,'YEARLY PROFIT REPORT',0,0,1);
		$pdf->Ln(5);
		$pdf->Cell('auto',7,'YEAR : '.$start,0,0,1);
		$pdf->Ln(5);
		if($_GET['status'] == 1){
			$pdf->SetTextColor(73, 173, 80);
			$type = 'TOTAL MONTHLY PROFIT';
		}else if($_GET['status'] == 0){
			$pdf->SetTextColor(158, 38, 38);
			$type = 'REMAINING PAYMENTS';
		}else{
			$pdf->SetTextColor(39, 138, 171);
			$type = 'OVERALL PAYMENT - PAID & UNPAID';
		}	
		$pdf->Cell('auto',7,$type,0,0,1);
		$pdf->Ln(10);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(35,7,'MONTH',1,0,'C');
		$pdf->Cell(30,7,'CONSUMPTION',1,0,'C');
		$pdf->Cell(33,7,'TOTAL',1,0,'C');
		$pdf->Cell(33,7,'EXTRA BILL',1,0,'C');
		$pdf->Cell(33,7,'PENALTY',1,0,'C');
		if($_GET['status'] != 0){ $pdf->Cell(33,7,'MEMBERSHIP',1,0,'C'); }
		$pdf->Cell(40,7,'FINAL TOTAL',1,0,'C');
		$pdf->Ln(7);
		
		$fuck = 0;
		$arr = ['01','02','03','04','05','06','07','08','09','10','11','12'];
		$i = 0;
		$final = ['paid' => 0];
		
		
		for($i=0;$i<12;$i++){
			$total = [0,0,0,0,0,0];
			$penalty = 0;
			$append = ($_GET['status'] < 2)?' AND status = '.$_GET['status']:'';
			$ra = "SELECT * FROM billings WHERE month_year = '".date("Y-m",strtotime($start.'-'.$arr[$i]))."' $append"; $a = mysql_query($ra);
			if(mysql_num_rows($a)>0){
				while($ar = mysql_fetch_array($a)){
					$penalty += $ar['penalty'];
					$total[2] += $ar['consumption'];
					$total[3] += $ar['total'];
					$rb = "SELECT * FROM extra_billings WHERE billing = '".$ar['month_year']."' AND client = '".$ar['client']."'"; $b = mysql_query($rb);
					if(mysql_num_rows($b)>0){

						while($br = mysql_fetch_array($b)){
							$total[4] += $br['total'];
						}
					}
					$total[5] += $total[4] + $total[3];
				}
			
			}

			$pdf->SetFont('Helvetica','b',7);
			$pdf->Cell(35,7,date("F Y",strtotime($start.'-'.$arr[$i])),1,0,'C');
			$pdf->SetFont('courier','',7);
			$pdf->Cell(30,7,$total[2],1,0,0);
			$pdf->Cell(33,7,'PHP '.number_format($total[3],2,'.',','),1,0,0);
			$pdf->Cell(33,7,'PHP '.number_format($total[4],2,'.',',').' ',1,0,0);
			$pdf->Cell(33,7,'PHP '.number_format($penalty,2,'.',',').' ',1,0,0);
			
			$final['paid'] += $total[0];
			
			if($_GET['status'] != 0){
			$pdf->Cell(33,7,'PHP '.number_format(getMemFee('monthly', $_GET['status'], date("Y-m",strtotime($start.'-'.$arr[$i]))),2,'.',',').'',1,0,0);
				$end = $penalty + $total[3]+$total[4] + getMemFee('monthly', $_GET['status'], date("Y-m",strtotime($start.'-'.$arr[$i])));
			}else{
				$end = $penalty + $total[3]+$total[4];
			}
			$fuck += $end;
			
			$pdf->Cell(40,7,'PHP '.number_format($end,2,'.',',').'',1,0,0);
			$pdf->Ln(7);
		}
		$pdf->SetFont('courier','b',7);
		$pdf->SetTextColor(73, 173, 80);
		if($_GET['status'] != 0){
			$pdf->Cell(164,7,'',0,0,1);
		}else{
			$pdf->Cell(131,7,'',0,0,1);
		}
		$pdf->Cell(33,7,'TOTAL AMOUNT :',1,0,0);
		$pdf->Cell(40,7,'PHP '.number_format($fuck ,2,'.',',').' ',1,0,0);
		$start++;
	}
	
	
	$pdf->output();	
}


/*
	
	

	
	
		
	

*/

?>
