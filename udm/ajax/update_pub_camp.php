<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$pubid=$_GET['pubid'];
$advertiserid=$_GET['advertiserid'];
$campid=$_GET['campid'];
$c=$_GET['c'];





	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_".$product."db";	
	}
	else
	{
		$logdb=$operator."_".$product."db";	
	}
	
	$logdb=strtolower($logdb);
		
		
		echo $sql_pub="select * from ".$logdb.".pub_blocking_tbl where pub_blocking_id= '".$pubid."'"; exit;
		$res_pub=$conn->query($sql_pub);
		$row_pub=$res_pub->fetch();
		
		$pubid=$row_pub['pubid'];
			if($c == 'check')
			{
			 	$sql="insert  into ".$logdb.".pub_camp_blocking_tbl (pubid,campaign_id) values ('".$pubid."','".$campid."'); "; 
				$res=$conn->query($sql);
				
			
			}
			else
			{
				$sql="delete from  ".$logdb.".pub_camp_blocking_tbl where pubcampid = '".$pubid."' and campaign_id='".$campid."'"; 
				$res=$conn->query($sql);
	
				
			}	
				
	


?>