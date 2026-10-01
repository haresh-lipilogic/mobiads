<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$check=$_GET['c'];




if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_".$product."db";	
	}
	else
	{
		$logdb=$operator."_".$product."db";	
	}


	$sql="select * from ".$logdb.".campaign_type_tbl where camp_operator='".$operator."'";
	$res=$conn->query($sql);
	$row=$res->fetch();
	if($check == 'check')
	{
		
		
		if($row['camp_type_id'] == '')
		{
			$insert="insert into ".$logdb.".campaign_type_tbl (camp_type,camp_operator) values ('1','".$operator."') ";
			$res_insert=$conn->query($insert);
			include("../../cron.php");
			
		}
		else
		{
			$update="update ".$logdb.".campaign_type_tbl set camp_type=1 where camp_type_id='".$row['camp_type_id']."' ";
			$res_update=$conn->query($update);
			include("../../cron.php");
		}
	}
	else
	{
			$update="update  ".$logdb.".campaign_type_tbl set camp_type=0 where camp_type_id='".$row['camp_type_id']."' ";
			$res_update=$conn->query($update);
			include("../../cron.php");
	}

		


?>