<?php
include "dist/fpdf/connect.php";
$start = 20;
$b = mysql_query("SELECT * FROM dates");
if(mysql_num_rows($b)>0){
	while($br = mysql_fetch_array($b)){
		if($br['key'] == 'collect'){
			$start = $br['value'];		
		}
	}
}
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=".date("Y-M")."-template.csv");
header("Pragma: no-cache");
header("Expires: 0");

$today =  date("Y-m",strtotime("+ 8 hours"));
echo "METER #,CLIENT NAME,ADDRESS,PREVIOUS METER READING,METER READING\n";
$a = mysql_query("SELECT * FROM clients WHERE status = 0");

if(mysql_num_rows($a)>0){
	while($ar = mysql_fetch_array($a)){
		$prev = 0;
		$b = mysql_query("SELECT * FROM billings WHERE client = '".$ar['id']."'");
		if(mysql_num_rows($b)>0){
			while($br = mysql_fetch_array($b)){
				if(date("Y-m",strtotime($br['month_year'])) <= $today){
					$prev += $br['consumption'];
				}
			}
		}
		if($ar['start_billing'] <= $today){
			$address = str_replace(","," ", $ar['address']);
			echo $ar['meter_id'].",";
			echo $ar['lastname']." ";
			echo $ar['firstname']." ";
			echo $ar['middlename'].",";
			echo $address.",";
			echo $prev.",\n";

		}

	}
}

?>