<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$val=$_GET['val'];
$ad=$_GET['ad'];
$c=$_GET['c'];



$commondb="commondb";

	if($operator == 'Vodafone' || $operator == 'vodafone')
	{
		
			if($c == 'check')
			{
				$sql="update ".$commondb.".advertiser_tbl set advertiser_isactive = 0 where advertiser_id = $val "; 
				$res=$conn->query($sql);
			}
			else
			{
				$sql="update ".$commondb.".advertiser_tbl set advertiser_isactive = 1 where advertiser_id = $val "; 
				$res=$conn->query($sql);
			}	
	}
	else
	{
			if($c == 'check')
			{
				$sql="update ".$commondb.".advertiser_tbl set advertiser_isactive = 0 where advertiser_id = $val "; 
				$res=$conn->query($sql);	
			}
			else
			{
				$sql="update ".$commondb.".advertiser_tbl set advertiser_isactive = 1 where advertiser_id = $val "; 
				$res=$conn->query($sql);
			}		
	}


?>