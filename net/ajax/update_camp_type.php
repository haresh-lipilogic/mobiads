<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$check=$_GET['c'];




include("../includes/db.php");
	$sql="select * from ".$logdb.".campaign_type_tbl where camp_operator='".$operator."'";
	$res=$conn->query($sql);
	$row=$res->fetch();
	
	$sql_campaign_weightage_tbl="select * from ".$logdb.".campaign_weightage_tbl where camp_weightage_operator='".$operator."'";
	$res_campaign_weightage_tbl=$conn->query($sql_campaign_weightage_tbl);
	$row_campaign_weightage_tbl=$res_campaign_weightage_tbl->fetch();
	
	
	if($check == 'check')
	{
		if($row_campaign_weightage_tbl['camp_weightage_id'] == '')
		{
			$insert1="insert into ".$logdb.".campaign_weightage_tbl (camp_weightage_type,camp_weightage_perc,camp_weightage_operator) 
			values ('1','70,30','".$operator."') ";
			$res_insert1=$conn->query($insert1);
			include("../../cron.php");
		}
		else
		{
			$update1="update ".$logdb.".campaign_weightage_tbl set camp_weightage_type=1 where camp_weightage_id='".$row_campaign_weightage_tbl['camp_weightage_id']."' ";
			$res_update1=$conn->query($update1);
			include("../../cron.php");
		}
		
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
			$update1="update ".$logdb.".campaign_weightage_tbl set camp_weightage_type=0 where camp_weightage_id='".$row_campaign_weightage_tbl['camp_weightage_id']."' ";
			$res_update1=$conn->query($update1);
			include("../../cron.php");
		
			$update="update  ".$logdb.".campaign_type_tbl set camp_type=0 where camp_type_id='".$row['camp_type_id']."' ";
			$res_update=$conn->query($update);
			include("../../cron.php");
	}

		


?>