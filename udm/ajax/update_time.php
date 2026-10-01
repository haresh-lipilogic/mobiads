<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$campaign_id=$_GET['campaign_id'];
$datetime=$_GET['datetime'];

$a=explode("-",$datetime);
 




	if(strtolower($product) == 'glamour')
	{
		if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_glamourdb";	
		}
		else
		{
			$logdb=$operator."_glamourdb";	
		}
	}
	else
	{
		if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_gamesdb";	
		}
		else
		{
			$logdb=$operator."_gamesdb";	
		}
	}	

	 
	if($a == '')
	{
		
	}
	else
	{
		echo $update_campaign="update ".$logdb.".campaign_tbl set campaign_startdatetime = CONCAT(DATE(campaign_startdatetime),' ".$a[0]."') ,
							campaign_enddatetime = CONCAT(DATE(campaign_enddatetime),' ".$a[1]."')
						where campaign_id ='".$campaign_id."'"; 
		$res_campaign=$conn->query($update_campaign);
	}

	
?>