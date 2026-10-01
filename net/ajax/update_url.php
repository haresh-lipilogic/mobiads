<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$campaign_id=$_GET['campaign_id'];
$url=urldecode ($_GET['url']);


 



include("../includes/db.php");
		
		$update_campaign="update ".$logdb.".campaign_tbl set campaign_url = '".$url."'
						where campaign_id ='".$campaign_id."'"; 
		$res_campaign=$conn->query($update_campaign);


	
?>