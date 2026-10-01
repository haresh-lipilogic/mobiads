<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
$product=strtolower($_GET['product']);
date_default_timezone_set("Asia/Kolkata");
	$date=date("Y-m-d H:i:s");

$payout=$_GET['payout'];
$advertiserid=$_GET['advertiserid'];


$commondb="commondb";

			
	if(strtolower($product)  == 'glamour')
	{
		$insert_payout="insert into  ".strtolower($commondb).".glamour_payout_tbl (advertiser_id,payout,payoutdatetime)
		values ('".$advertiserid."','".$payout."','".$date."')"; 		
		$res_advertiser=$conn->query($insert_payout); 
	}
	else
	{
		$insert_payout="insert into  ".strtolower($commondb).".games_payout_tbl (advertiser_id,payout,payoutdatetime)
		values ('".$advertiserid."','".$payout."','".$date."')";
		$res_advertiser=$conn->query($insert_payout);
	}
		
		
	
	
	


?>