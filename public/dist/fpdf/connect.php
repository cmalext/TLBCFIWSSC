<?php
$con = mysql_connect("localhost","root","");
$db = mysql_select_db("capstone_karla",$con);
function setVat(){
	$rc = "SELECT * FROM prices WHERE type = 'vat'"; $c = mysql_query($rc);
	if(mysql_num_rows($c)>0){
		$cr = mysql_fetch_row($c);
		return $cr[2];
	}else{
		return 0;
	}
}
function getDates(){
	$init = ['due' => date("F d, Y",strtotime($_GET['month'].'-10'.'+ 1 months')), 'cut' => date("F d, Y",strtotime($_GET['month'].'-15'.'+ 1 months'))];
	$rd = "SELECT * FROM dates"; $d = mysql_query($rd);
	if(mysql_num_rows($d)>0){
		while($dr = mysql_fetch_array($d)){
            if($dr['key']=='notice') { $init['due'] = date("F d, Y",strtotime($_GET['month'].'-'.$dr['value'].'+ 1 months'));}
            if($dr['key']=='cutoff') { $init['cut'] = date("F d, Y",strtotime($_GET['month'].'-'.$dr['value'].'+ 1 months'));}
		}
	}
	return $init;
}
function client_query(){
	$sql = "SELECT * FROM clients ";
	if(isset($_GET['status']) && $_GET['status'] != 3){
		$sql .= "WHERE status = ".$_GET['status'];
	}
	if(isset($_GET['type']) && $_GET['type'] != 3){
		if(isset($_GET['status']) && $_GET['status'] != 3){
			$sql .= " AND ";
		}else{
			$sql .= " WHERE ";
		}
		$sql .= "type = ".$_GET['type'];
	}
	return $sql." ORDER BY lastname ASC";
}
function income_query(){
	$sql = "SELECT * FROM billings WHERE ";
	if($_GET['type'] == 1){
		$sql .= "month_year = ".date("Y-m", strtotime($_GET['years']."-".$_GET['month']));
	}else{
		
	}
	return $sql;
}
function getPreviousMeterReadingTotal($id,$date){
	$result = 0;
	$a = mysql_query("SELECT * FROM billings WHERE client = '".$id."'");
	if(mysql_num_rows($a)){
		while($ar = mysql_fetch_array($a)){
			if(date("Y-m-d",strtotime($ar['month_year'].'-01')) < date("Y-m-d",strtotime($date.'-01'))){
				$result += $ar['consumption'];
			}
		}
	}
	return $result;
}
function getMemfee($type, $status, $date){
	$result = 0;
	//echo $date;
	if($type == 'monthly'){
		$a = mysql_query("SELECT * FROM clients");
		if(mysql_num_rows($a)>0){
			while($ar = mysql_fetch_array($a)){
				if(date("Y-m",strtotime($ar['created_at'])) == date("Y-m",strtotime($date))){
					$result += $ar['membership'];
				}
			}
		}
	}
	return $result;
}
function getPenalty(){
	$result = 100;
	$a = mysql_query("SELECT * FROM prices WHERE type = 'penalty'");
	if(mysql_num_rows($a)>0){
		while($ar = mysql_fetch_array($a)){
			$result = $ar['price'];
		}
	}
	return $result;
}
$vat = 0;
?>