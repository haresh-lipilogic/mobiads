<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");
$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$val=$_GET['val'];

$c=$_GET['c'];





include("../includes/db.php");


	if($operator == 'Vodafone' || $operator == 'vodafone')
	{
		
			if($c == 'check')
			{
				$sql="update ".$logdb.".campaign_tbl set campaign_live = 0 where campaign_id = $val "; 
				$res=$conn->query($sql);
				
				$delete= "delete from ".$logdb.".running_campaign_tbl where campaign_id= $val ";
				$res_delete=$conn->query($delete);
				
			}
			else
			{
				$sql="update ".$logdb.".campaign_tbl set campaign_live = 1 where campaign_id = $val "; 
				$res=$conn->query($sql);
	
				$select="select * from ".$logdb.".running_campaign_tbl order by run_camp_id desc limit 1";
				$res_select=$conn->query($select);
				$row_select=$res_select->fetch();
				$row1=$row_select['run_camp_id']+1;
				
				$insert="insert into ".$logdb.".running_campaign_tbl (run_camp_id,campaign_id,run_camp_operator,run_camp_track) values ('".$row1."','$val','".$operator."','0')";		
				$res_insert=$conn->query($insert);
			}	
				
	}
	else
	{ 
			if($c == 'check')
			{
				$sql="update ".$logdb.".campaign_tbl set campaign_live = 0 where campaign_id = $val "; 
				$res=$conn->query($sql);
				
				$delete= "delete from ".$logdb.".running_campaign_tbl where campaign_id= $val ";
				$res_delete=$conn->query($delete);
				
			}
			else
			{
				$sql="update ".$logdb.".campaign_tbl set campaign_live = 1 where campaign_id = $val "; 
				$res=$conn->query($sql);
	
				$select="select * from ".$logdb.".running_campaign_tbl order by run_camp_id desc limit 1";
				$res_select=$conn->query($select);
				$row_select=$res_select->fetch();
				$row1=$row_select['run_camp_id']+1;
				
				$insert="insert into ".$logdb.".running_campaign_tbl (run_camp_id,campaign_id,run_camp_operator,run_camp_track) values ('".$row1."','$val','".$operator."','0')";		
				$res_insert=$conn->query($insert);
			}			
	}


?>