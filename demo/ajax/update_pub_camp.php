<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
$product=strtolower($_GET['product']);
$pubid=$_GET['pubid'];

$campid=$_GET['campid'];
$c=$_GET['c'];


include("../includes/db.php");
	$logdb=strtolower($logdb);
		
		
		$sql_pub="select * from ".$logdb.".pub_blocking_tbl where pub_blocking_id= '".$pubid."'"; 
		$res_pub=$conn->query($sql_pub);
		$row_pub=$res_pub->fetch();
		
		$pub=$row_pub['pubid'];
			if($c == 'check')
			{
			 $sql="insert  into ".$logdb.".pub_camp_blocking_tbl (pubid,pub,campaign_id) values ('".$pubid."','".$pub."','".$campid."'); ";  
				$res=$conn->query($sql);
				
			
			}
			else
			{
				$sql="delete from  ".$logdb.".pub_camp_blocking_tbl where pubid = '".$pubid."' and campaign_id='".$campid."'"; 
				$res=$conn->query($sql);
	
				
			}	
				
	


?>