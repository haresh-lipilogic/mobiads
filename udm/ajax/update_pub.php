<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$pubid=$_GET['pubid'];
$advertiserid=$_GET['advertiserid'];
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
		
			if($c == 'check')
			{
			 	$sql="update ".$logdb.".pub_blocking_tbl set pubid_isactive = '0' where pub_blocking_id = '".$pubid."'  "; 
				$res=$conn->query($sql);
				
			
			}
			else
			{
				$sql="update ".$logdb.".pub_blocking_tbl set pubid_isactive = '1' where pub_blocking_id = '".$pubid."' "; 
				$res=$conn->query($sql);
	
				
			}	
				
	


?>