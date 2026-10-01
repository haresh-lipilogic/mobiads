<?php 
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$campaignid=$_GET['campaignid'];
$advertiserid=$_GET['advertiserid'];
$c=$_GET['c'];


//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 


if(strtolower($product) == 'glamour')
{
	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_glamourdb";	
	}
	else
	{
		$logdb=$operator."_glamourdb";	
	}
}
else
{
	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_gamesdb";	
	}
	else
	{
		$logdb=$operator."_gamesdb";	
	}
}
	
if($c == 'check')
{
	$select ="select * from ".$logdb.".advertiser_blocking_tbl where campaign_id = '".$campaignid."' and advertiser_id='".$advertiserid."' ";
	$res_select=$conn->query($select);
	$count=$res_select->rowCount();
		
	if($count == 0)
	{
	$insert_sql="insert into ".$logdb.".advertiser_blocking_tbl (campaign_id,advertiser_id) values ('".$campaignid."','".$advertiserid."') "; 
	$res=$conn->query($insert_sql);
	
	}
	else
	{
		
	}
	
	
}
else
{
	$select ="select * from ".$logdb.".advertiser_blocking_tbl where campaign_id = '".$campaignid."' and advertiser_id='".$advertiserid."' ";
	$res_select=$conn->query($select);
	$count=$res_select->rowCount();
		
	if($count == 0)
	{
	
	
	}
	else
	{
		$delete_sql="delete from ".$logdb.".advertiser_blocking_tbl where campaign_id='".$campaignid."' and advertiser_id = '".$advertiserid."' ";  
	$res=$conn->query($delete_sql);
		
	}
	
}	
	
	



?>
                          
  