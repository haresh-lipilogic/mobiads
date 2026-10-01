<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$campaign_id=$_GET['campaign_id'];
$datetime=$_GET['datetime'];

$a=explode("/",$datetime);
 

include("../includes/db.php");
	if($a == '')
	{
		
	}
	else
	{
		 $update_campaign="update ".$logdb.".campaign_tbl set campaign_startdatetime = '".$a[0]."',
							campaign_enddatetime = ' ".$a[1]."'
						where campaign_id ='".$campaign_id."'"; 
		$res_campaign=$conn->query($update_campaign);
	}

	
?>