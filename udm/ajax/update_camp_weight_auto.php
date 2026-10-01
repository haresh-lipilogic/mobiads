<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower(($_GET['product']));
$capping_value=$_GET['capping_value'];
$campaign_id=$_GET['campaign_id'];

if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_".$product."db";	
	}
	else
	{
		$logdb=$operator."_".$product."db";	
	}
	$sql_check="select * from ".$logdb.".campaign_weightage_tbl where camp_weightage_operator='".$operator."' ";
	$res_check=$conn->query($sql_check);
	$row_check=$res_check->fetch();

	if($row_check['camp_weightage_id']== '' )
	{
		$insert_capping="insert into ".$logdb.".campaign_weightage_tbl (camp_weightage_type,camp_weightage_perc,camp_weightage_operator) values ('1','".$capping_value."','".$operator."') ";
		$res_capping=$conn->query($insert_capping);
		
	}
	else
	{
		$update_capping="update ".$logdb.".campaign_weightage_tbl set camp_weightage_perc='".$capping_value."' where camp_weightage_id= '".$row_check['camp_weightage_id']."'";
		$update_res_capping=$conn->query($update_capping) or die(mysql_error());
	}
		
		
	
?>