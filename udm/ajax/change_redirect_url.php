<?php 
include("../includes/connection.php");

$commondb="commondb";

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$campaignid=$_GET['campaignid'];
$advertiserid=$_GET['advertiserid'];
$url=$_GET['url'];


//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 


	
	$update_url="update ".$commondb.".advertiser_tbl set redirect_url = '".$url."' where advertiser_id='".$advertiserid."' ";
	$res_url=$conn->query($update_url);



?>
                          
  