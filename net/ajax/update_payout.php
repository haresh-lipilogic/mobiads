<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
$product=strtolower($_GET['product']);
date_default_timezone_set("Asia/Kolkata");
	$date=date("Y-m-d H:i:s");

$payout=$_GET['payout'];
$campaign_id=$_GET['campaign_id'];  
$commondb="commondb";


	include("../includes/db.php");
$sql="select * from ".strtolower($commondb).".operator_tbl where operator= '".$operator."'"; 
$res=$conn->query($sql);
$row=$res->fetch();


			
	if(strtolower($product)  == 'glamour')
	{
		$insert_payout="insert into  ".strtolower($commondb).".glamour_advertiser_payout_tbl (operatorid,campaign_id,payout,payout_datetime)
		values ('".$row['operator_id']."','".$campaign_id."','".$payout."','".$date."')";  		
		$res_advertiser=$conn->query($insert_payout); 
	}
	else
	{
		$insert_payout="insert into  ".strtolower($commondb).".games_advertiser_payout_tbl (operatorid,campaign_id,payout,payout_datetime)
		values ('".$row['operator_id']."','".$campaign_id."','".$payout."','".$date."')"; 		
		$res_advertiser=$conn->query($insert_payout); 
	}
		
		
	
	
	


?>