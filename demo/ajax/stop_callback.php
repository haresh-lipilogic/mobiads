<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");

$operator=strtolower($_GET['operator']);
$product=strtolower($_GET['product']);
$callbackstop_perc=$_GET['callbackstop_perc'];

$callbackstop_perc1=round($_GET['callbackstop_perc']/10);
$advertiserid=$_GET['advertiserid'];
$type=$_GET['type'];


if($product == 'glamour')
{
	$spo="spo_stopcallback";

	$act="act_stopcallback";

	
}
elseif($product == 'games')
{
	$spo="games_spo_stopcallback";
	
	$act="games_act_stopcallback";
	
	
}
elseif($product == 'music')
{
	$spo="music_spo_stopcallback";

	$act="music_act_stopcallback";
	
}
else{}

	include("../includes/db.php");
	if($type == 'spo')
	{
		$update_advertiser="update ".strtolower($commondb).".advertiser_tbl set ".$spo." ='".$callbackstop_perc."' where advertiser_id = '".$advertiserid."'";
		$res_advertiser=$conn->query($update_advertiser);
		
		$sql_response_counter="select * from ".strtolower($logdb).".advertiser_callback_counter_tbl where advertiser_id = '".$advertiserid."'";
		$res_response_counter=$conn->query($sql_response_counter);
		$num_response_counter=$res_response_counter->rowCount();
		if($num_response_counter > 0)
		{
			$update_callback="update ".strtolower($logdb).".advertiser_callback_counter_tbl set spo_callback_counter= '".$callbackstop_perc1."' where advertiser_id = '".$advertiserid."' ";
			$res_callback=$conn->query($update_callback);
		}
		else
		{
			$insert_callback_counter="insert into ".strtolower($logdb).".advertiser_callback_counter_tbl  (advertiser_id,spo_callback_counter) values ('".$advertiserid."',".$callbackstop_perc1."') ";
			$res_callback_counter=$conn->query($insert_callback_counter);
		}
	}
	else
	{
		
		$update_advertiser="update ".strtolower($commondb).".advertiser_tbl set ".$act." ='".$callbackstop_perc."' where advertiser_id = '".$advertiserid."'";
		$res_advertiser=$conn->query($update_advertiser);
		
		$sql_response_counter="select * from ".strtolower($logdb).".advertiser_callback_counter_tbl where advertiser_id = '".$advertiserid."'"; 
		$res_response_counter=$conn->query($sql_response_counter);
		$num_response_counter=$res_response_counter->rowCount();
		if($num_response_counter > 0)
		{
		$update_callback="update ".strtolower($logdb).".advertiser_callback_counter_tbl set act_callback_counter= '".$callbackstop_perc1."' where advertiser_id = '".$advertiserid."' "; 
			$res_callback=$conn->query($update_callback);
		}
		else
		{
			$insert_callback_counter="insert into ".strtolower($logdb).".advertiser_callback_counter_tbl  (advertiser_id,act_callback_counter) values ('".$advertiserid."','".$callbackstop_perc1."') ";
			$res_callback_counter=$conn->query($insert_callback_counter);
		}
		
	}
	
	


?>