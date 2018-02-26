<?php
require('dist/fpdf/fpdf.php');
require('dist/fpdf/connect.php');
function getExtraBilling($client,$bill){
	$return = 0;
	$rd = "SELECT * FROM extra_billings WHERE client = '".$client."' AND billing = '".$bill."'"; $d = mysql_query($rd);
	if(mysql_num_rows($d)>0){
		while($dr = mysql_fetch_array($d)){
			$result += $dr['total'];
		}
	}
}
$year = date("Y-m",strtotime('+8 hours'));
$date = date("Y-m-d",strtotime("+ 8 hours"));
$ra = "SELECT * FROM dates"; $a = mysql_query($ra);
if(mysql_num_rows($a)>0){
	while($ar = mysql_fetch_array($a)){
		if($ar['key'] == 'collect'){
			$collect = $ar['value'];	
		}
	}
}else{
	$collect = 20;
}
$collection = date("Y-m-d",strtotime($year."-".$collect));
if($date < $collection){
	$current = date("Y-m",strotime($collection."- 1 month") );
}else{
	$current = date("Y-m",strtotime($collection));
}
$rb = "SELECT * FROM billings WHERE month_year = '".$current."'"; $b = mysql_query($rb);
if(mysql_num_rows($b)>0){
	$pdf = new FPDF();
	$pdf->AddPage('P');
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Helvetica','b',9);
	$pdf->Cell(70,7,"CLIENTS' BILLING STATUS",0,0,1);
	$pdf->Ln(5);
	$pdf->Cell(70,7,strtoupper(date("F Y",strtotime($current))),0,0,1);
	$pdf->Ln(10);
	$pdf->SetFont('Helvetica','b',8);
	$pdf->Cell(70,7,'CLIENT',1,0,'C');
	$pdf->Cell(40,7,'TYPE',1,0,'C');
	$pdf->Cell(40,7,'TOTAL',1,0,'C');
	$pdf->Cell(40,7,'STATUS',1,0,'C');	
	while($br = mysql_fetch_array($b)){
		$rc = "SELECT * FROM clients WHERE id = '".$br['client']."'"; $c = mysql_query($rc);
		if(mysql_num_rows($c)>0){
			while($cr = mysql_fetch_array($c)){
				$show = 0;
				if($_GET['type'] > 1){
					$show =1 ;
				}else{
					if($_GET['type'] == $br['status']){
						$show = 1;
					} 
				}	

				if($show == 1){
					$pdf->Ln(7);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(70,7,$cr['lastname'].', '.$cr['firstname'].' '.$cr['middlename'],1,0,'C');
					$pdf->Cell(40,7,($cr['type']==0)?'Residential':'Commercial',1,0,'C');
					$pdf->Cell(40,7,'PHP '.number_format($br['total'] + $br['penalty'] + getExtraBilling($br['client'],$br['month_year']),2,'.',','),1,0,0);
					$pdf->Cell(40,7,($br['status'] == 0)?'Unpaid':'Paid',1,0,'C');		
				}
			}
		}
		
	}
	$pdf->output();	
}else{
	"You need to import or manually add billing for the month before we can proceed";
}
?>
