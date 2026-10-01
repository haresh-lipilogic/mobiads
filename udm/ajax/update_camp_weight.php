<?php
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
	$product=strtolower(($_GET['product']));
$weight_value=$_GET['weight_value'];
$campaign_id=$_GET['campaign_id'];


	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_".$product."db";	
	}
	else
	{
		$logdb=$operator."_".$product."db";	
	}

		
	$update_capping="update ".$logdb.".campaign_tbl set campaign_weight='".$weight_value."' where campaign_id= '".$campaign_id."'";
	$update_res_capping=$conn->query($update_capping);
		
		
		
	

?>