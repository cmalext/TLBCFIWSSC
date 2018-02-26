<?php
if(isset($_GET['id'])){
	require('dist/fpdf/fpdf.php');
	require('dist/fpdf/connect.php');
	$pdf = new FPDF('L','mm',array(95,120));
	$ra = "SELECT * FROM clients WHERE id = '".$_GET['id']."'"; $a = mysql_query($ra);
	if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
		$pdf->AddPage();
		$pdf->SetMargins(5,5,5,5);  
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
		$pdf->Cell('auto',5,'M-'.$ar['id'],0,0,0);
		$pdf->Ln(6);
		$pdf->SetTextColor(8, 92, 19);
		$pdf->SetFont('Helvetica','b',11);
		$pdf->SetFont('Helvetica','b',7);
		$pdf->Cell(75,5,'Date  : ',0,0,0);
		$pdf->SetFont('courier','',7);
		$pdf->Cell(35,5,date("F d, Y",strtotime($ar['created_at'])),0,0,1);
		$pdf->Ln(4.1);
		$pdf->Cell(75,5,'',0,0,1);
		$pdf->Cell(35,0,'',1,0,1);
		$pdf->Ln(1);
		$pdf->SetFont('Helvetica','b',7);
		$pdf->Cell(30,5,'RECIEVED from  : ',0,0,1);
		$pdf->SetFont('courier','',7);
		$cname = $ar['lastname'].', '.$ar['firstname'];
		strlen($ar['middlename'])>0?$cname.=' '.$ar['middlename'][0].'.':'';
		$pdf->Cell(50,5,$cname,0,0,1);
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
		$pdf->Cell(80,5,"PHP ".number_format($ar['membership'],2,'.',',')."" ,0,0,1);
		$pdf->Ln(4.1);
		$pdf->Cell(30,5,'',0,0,1);
		$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(30,5,'in payment of : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(80,5,"Membership Fee",0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(30,5,'',0,0,1);
					$pdf->Cell(80,0,'',1,0,1);
					$pdf->Ln(3);
					
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell('auto',5,'Payment Recieved: ',0,0,1);
					$pdf->Ln(5);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(18,5,'  CASH : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(25,5,"PHP ".number_format($ar['membership'],2,'.',',')." ",0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(18,5,'',0,0,1);
					$pdf->Cell(25,0,'',1,0,1);
					$pdf->Ln(1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(18,5,'  Change : ',0,0,1);
					$pdf->SetFont('courier','',7);
					$pdf->Cell(25,5,"PHP ".number_format($ar['amount_paid'] - $ar['membership'],2,'.',',')." ",0,0,1);
					$pdf->SetFont('Helvetica','b',7);
					$pdf->Cell(25,5,'PRINTED BY: ',0,0,0);
					$pdf->SetFont('courier','',7);
					$rc = "SELECT * FROM users WHERE id = '".$ar['user']."'"; $c = mysql_query($rc); 
					$cr = mysql_fetch_array($c);
					$uname = $cr['lastname'].', '.$cr['firstname'];
					strlen($cr['middlename'])>0?$uname.=' '.$cr['middlename'][0].'.':'';
					$pdf->Cell(42,5,$uname,0,0,1);
					$pdf->Ln(4.1);
					$pdf->Cell(18,5,'',0,0,1);
					$pdf->Cell(25,0,'',1,0,1);
					$pdf->Cell(25,0,'',0,0,0);
					$pdf->Cell(42,0,' ',1,0,1);
					$pdf->Ln(1);

				
			
		}
	}





$pdf->Output();
}
?>
