<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");

$operator=($_GET['operator']);
$product ="glamour";
$capping_value=$_GET['capping_value'];
$campaign_id=$_GET['campaign_id'];


include("../includes/db.php");
	$sql_check="select * from ".$logdb.".capping_tbl where campaign_id= '".$campaign_id."'";
	$res_check=$conn->query($sql_check);
	$row_check=$res_check->fetch();
	
	if($row_check['campaign_id']== '' )
	{
		$insert_capping="insert into ".$logdb.".capping_tbl (campaign_id,capping_count) values ('".$campaign_id."','".$capping_value."') "; 
		$res_capping=$conn->query($insert_capping);
		
	}
	else
	{
		$update_capping="update ".$logdb.".capping_tbl set capping_count='".$capping_value."' where campaign_id= '".$campaign_id."'"; 
		$update_res_capping=$conn->query($update_capping);
	}
		
	
	


?>