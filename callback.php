<?php


	
	echo "ok";

include("includes/connection.php");
include("includes/functions.php");
include("includes/language.php");


error_reporting(0);

$clickid=$_GET['clickid'];
//$campaign_id=$_GET['campaign_id'];


if(strtolower($_GET['action']) == 'dct')
{
	$camp_action='dct';
}
else{
	$camp_action= 'act';
}

	$proid= substr($clickid,-4,2);
	

	if($proid == 'gl')
	{
		$pro="glamour";
		$spo="spo_stopcallback";
		$act="act_stopcallback";
		
	}
	elseif($proid== 'gm')
	{
		$pro="games";
		$spo="games_spo_stopcallback";
		$act="games_act_stopcallback";
	}
	
	else{}

	$operatorid= substr($clickid,-2);

	//$operator=get_db($operatorid);  // to find operator from ip_operator_tbl
	$operator=get_operator($operatorid); // to find operator from operator_tbl 
	$operator= strtolower($operator['operator']);  


	
	
	if($pro == 'games')
	{
		
	
	}
	else
	{
		if(strtolower($operator)=='vodafone' )
		{
			$logdb="voda_".$pro."db";
		}
		
		elseif(strtolower($operator)=='ais' )
		{
				$logdb=$operator."_".$pro."db_0118";  
		}
		
		else
		{
			$logdb=$operator."_".$pro."db"; 
			
		}
	
	}
		
	
	$logdb=strtolower($logdb);
	
	
	if(substr($clickid,-4,2) == $proid)
	{
		if(substr($clickid,-2) == $operatorid)
		{
			$clickid= substr($clickid,0,-4); 
		}
		else
		{
			
		}
	}
	else
	{
		if(substr($clickid,-2) == $operatorid)
		{
			$clickid= substr($clickid,0,-2); 
		}
		else
		{
			
		}
	}
	

	
	// If we could not get pubid then find from campaign_request_tbl by using clickid
	$select_pubid="select * from ".$logdb.".campaign_request_tbl where clickid='".$clickid."' ";  
	$res_pubid=$conn->query($select_pubid);
	$row_pubid=$res_pubid->fetch();	
	$pubid=$row_pubid['pubid'];
	



date_default_timezone_set("Asia/Kolkata");
$datetime=date('Y-m-d H:i:s');



// campaign id fetch karva
$select_campaign="select * from ".$logdb.".campaign_request_tbl where clickid='".$clickid."' and pubid='".$pubid."'";   
$res_campaign=$conn->query($select_campaign);
$row_campaign=$res_campaign->fetch();
$campaign_id= $row_campaign['campaign_id']; 


if($campaign_id == '')
{
	$campaign_id="0";
}



//Advertiser ni click id fetch karva
$sql_advertiser="select SUBSTRING_INDEX(SUBSTRING_INDEX(referrer_url,'clickid=',-1),'&',1) clickid,
SUBSTRING_INDEX(SUBSTRING_INDEX(referrer_url,'pubid=',-1),'&',1) pubid, advertiser_id from ".$logdb.".userlog_tbl where  clickid='".$clickid."' and pubid='".$pubid."' ";  
$res_advertiser=$conn->query($sql_advertiser);
$row_advertiser=$res_advertiser->fetch();
$ad_clickid=$row_advertiser['clickid'];
//$pubid=$row_advertiser['pubid'];
$advertiser_id=$row_advertiser['advertiser_id']; 

if($advertiser_id == '')
{
	$advertiser_id="0";
}


//Advertiser ni url fetch karva 
$sql_adv_url="select * from ".$commondb.".advertiser_tbl where advertiser_id = '".$advertiser_id."' ";
$res_adv_url=$conn->query($sql_adv_url);
$row_adv_url=$res_adv_url->fetch();
$url=$row_adv_url['advertiser_url'];
$main_url=$row_adv_url['advertiser_url'];

$dcturl=$row_adv_url['advertiser_dct_url'];
$maindcturl=$row_adv_url['advertiser_dct_url'];


$aa=0;

while($aa <= 20)
{
	
		$first=strpos($url,'[');
		$last=strpos($url,']');
		
		$param_value=substr($url,strpos($url,'[')+1,(strpos($url,']')-strpos($url,'['))-1);	
		
		$sql_advertiser="select SUBSTRING_INDEX(SUBSTRING_INDEX(referrer_url,'".strtolower($param_value)."=',-1),'&',1) '".strtolower($param_value)."',
		advertiser_id from ".$logdb.".userlog_tbl where  clickid='".$clickid."' and pubid like '".$pubid."' "; 
		$res_advertiser=$conn->query($sql_advertiser);
		$row_advertiser=$res_advertiser->fetch();
		$replace_value= $row_advertiser["$param_value"]; 
		$edited_url=str_replace('['.$param_value.']',$replace_value,$main_url); 
		$main_url=$edited_url;
		
		$url= substr($url,$last+1); 

$aa=$aa	+1;
}


// advertiser ne deactivation na response na moklva mate.. 
//agar action = 'act' male to response moklva ma avse advertiser ne ..
// agar action='dct' male to by default 'DCT' response message insert thase
//Agar fully block karel hase to response ma 'stop'  insert karva ma avse


// query check karva mate ke advertiser fully block karel 6 ke nai...
$sql_advertiser_fullblock="select * from ".$commondb.".advertiser_tbl where advertiser_id = '".$advertiser_id."' and advertiser_isactive = 0
";
$res_advertiser_fullblock=$conn->query($sql_advertiser_fullblock);
$num_advertiser_fullblock=$res_advertiser_fullblock->rowCount();

if($num_advertiser_fullblock != '0' || $num_advertiser_fullblock != 0)
{
	$a='stop'; // response ma 'stop' message inser karva  
}
else
{

	//query check karva mate ke advertiser campaign wise block karel 6 ke nai..
	$sql_advertiser_campaignblock="select * from ".$logdb.".advertiser_blocking_tbl where advertiser_id ='".$advertiser_id."' and campaign_id = '".$campaign_id."'";
	$res_advertiser_campaignblock=$conn->query($sql_advertiser_campaignblock);
	$num_advertiser_campaignblock=$res_advertiser_campaignblock->rowCount();
	
	if($num_advertiser_campaignblock != 0 || $num_advertiser_campaignblock != '0')
	{
			
		$a='stop';  // response ma 'stop' message insert karva  
	}
	else
	{
		
		if(strtolower($camp_action) == 'act' ) // agar activation hase to callback jase advertiser ne 
		{ 
		
			$sql_distinct="select count(clickid) c from ".$logdb.".advertiser_response_tbl where clickid = '".$clickid."' ";
			$res_distinct=$conn->query($sql_distinct);
			$row_distinct=$res_distinct->fetch();
			if($row_distinct['c'] > 0)
			{
				$a="stop";
			}
			else{
				
				
					// agar activation's clickid same day hase to 100% callback jase .. naitar je percentage decide karya hoy e rite jase callback .
					$sql_sameday="select * from ".$logdb.".userlog_tbl where clickid = '".$clickid."' and date(userlog_datetime) =  date('".$datetime."')";
					$res_sameday=$conn->query($sql_sameday);
					if( $res_sameday->rowCount() > 0 ) // same day activation's clickid.. 100% callback jase.. pure pura callback jase.. koi cut nai thay..
					{	
							$sql_callback_counter="SELECT 
											act_callback_counter, ".$act."
										FROM
											".$logdb.".advertiser_callback_counter_tbl
												INNER JOIN
											".$commondb.".advertiser_tbl ON advertiser_callback_counter_tbl.advertiser_id = advertiser_tbl.advertiser_id
										WHERE
											advertiser_tbl.advertiser_id = '".$advertiser_id."'";
						$res_callback_counter=$conn->query($sql_callback_counter);
						$row_callback_counter=$res_callback_counter->fetch();
						$callback_counter=$row_callback_counter['act_callback_counter']; 
						$stopcallback_count=($row_callback_counter[$act]/10)*2;
						

						$select_blockcounter="select * from ".$commondb.".callbacksent_counter where counter = '".$stopcallback_count."' ;"; 
						$res_blockcounter=$conn->query($select_blockcounter);
						$row_blockcounter=$res_blockcounter->fetch();

						if(strpos($row_blockcounter['blockcounter'],",$callback_counter,") === false)
						{
							
							$a=file_get_contents($edited_url);
						
							
							 
							//$a="success";
							$callback_counter =$callback_counter-1;
							
							if($callback_counter == '0')
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '20' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
							else
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '".$callback_counter."' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
						}
					
						else
						{
						
							$a='stop'; 
							$callback_counter =$callback_counter-1;
							if($callback_counter == '0')
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '20' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
							else
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '".$callback_counter."' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
						}
					}
					else // SPILL OVER mate..  activation's clickid aaj ni nai hoy etle callback percentage nakki karel hase e rite jase. 
					{
						
						$sql_callback_counter="SELECT 
											spo_callback_counter, ".$spo."
										FROM
											".$logdb.".advertiser_callback_counter_tbl
												INNER JOIN
											".$commondb.".advertiser_tbl ON advertiser_callback_counter_tbl.advertiser_id = advertiser_tbl.advertiser_id
										WHERE
											advertiser_tbl.advertiser_id = '".$advertiser_id."'";
						$res_callback_counter=$conn->query($sql_callback_counter);
						$row_callback_counter=$res_callback_counter->fetch();
						$callback_counter=$row_callback_counter['spo_callback_counter'];
						$stopcallback_count=($row_callback_counter[$spo]/10)*2;
					
						
						$select_blockcounter="select * from ".$commondb.".callbacksent_counter where counter = '".$stopcallback_count."' ;"; 
						$res_blockcounter=$conn->query($select_blockcounter);
						$row_blockcounter=$res_blockcounter->fetch();

						if(strpos($row_blockcounter['blockcounter'],",$callback_counter,") === false)
						{
							$a=file_get_contents($edited_url);
							//$a="success";
							$callback_counter =$callback_counter-1;
							
							if($callback_counter == '0')
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '20' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
							else
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '".$callback_counter."' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
						}
					
						else
						{
						
							$a='stop'; 
							$callback_counter =$callback_counter-1;
							if($callback_counter == '0')
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '20' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
							else
							{
								$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '".$callback_counter."' where advertiser_id ='".$advertiser_id."' ";
								$res_counter=$conn->query($update_counter);
							}
						}
					
					
					}

				
				
			}
			
		}
		else
		{
			
			if($dcturl != '')
			{
				$sql_advertiser1="select * from ".$logdb.".advertiser_response_tbl where  clickid='".$clickid."' and action='act' and pubid like '".$pubid."' and advertiser_response != 'stop' and DATE(ad_resp_datetime) = DATE(NOW()) "; 
				$res_advertiser1=$conn->query($sql_advertiser1);
				if($res_advertiser1->rowCount() > 0)
				{
					$aa=0;
					while($aa <= 20)
					{
		
							$first=strpos($dcturl,'['); 
							$last=strpos($dcturl,']');
							
							$param_value=substr($dcturl,strpos($dcturl,'[')+1,(strpos($dcturl,']')-strpos($dcturl,'['))-1);	
							
							$sql_advertiser="select SUBSTRING_INDEX(SUBSTRING_INDEX(referrer_url,'".$param_value."=',-1),'&',1) '".$param_value."',
							advertiser_id from ".$logdb.".userlog_tbl where  clickid='".$clickid."' and pubid like '".$pubid."'  "; 
							$res_advertiser=$conn->query($sql_advertiser);
							$row_advertiser=$res_advertiser->fetch();
							
							
								$replace_value= $row_advertiser["$param_value"]; 
								$dctedited_url=str_replace('['.$param_value.']',$replace_value,$maindcturl); 
								$maindcturl=$dctedited_url;
								
								$dcturl= substr($dcturl,$last+1);
							
							
							 

						$aa=$aa	+1;
					}
					$edited_url=$dctedited_url; 
					
					$a=file_get_contents($edited_url);
				}
				else
				{
					$a="stop";
				}
			
			}
			else
			{
				$a="stop";
			}
			
		}
	}
}


$sql_distinct="select count(clickid) c from ".$logdb.".advertiser_response_tbl where clickid = '".$clickid."' ";
$res_distinct=$conn->query($sql_distinct);
$row_distinct=$res_distinct->fetch();
if($row_distinct['c'] > 0)
{
	$a="stop";
}
else{
	//  campaign callbackresponse ma entry padva .. je callback male apan ne ...
	$insert_callback="insert into ".$logdb.".campaign_response_tbl (clickid,pubid,camp_resp_datetime,camp_action,campaign_id,advertiser_id) 
	values ('".$clickid."','".$pubid."','".$datetime."','".$camp_action."','".$campaign_id."','".$advertiser_id."')"; 
	$res_callback=$conn->query($insert_callback);


	// Advertiser callbackresponse ma entry padva.. je callback apne advertiser ne mokaliye
	$insert_ad_callback="insert into ".$logdb.".advertiser_response_tbl (advertiser_callbackurl,clickid,advertiser_clickid,pubid,ad_resp_datetime,action,campaign_id,advertiser_id,advertiser_response) values ('".$edited_url."','".$clickid."','".$ad_clickid."','".$pubid."','".$datetime."','".$camp_action."','".$campaign_id."','".$advertiser_id."','".$a."') "; 
	$res_ad_callback=$conn->query($insert_ad_callback);

}


if($camp_action=='act')
{

	$sql_payout="select * from commondb.".$pro."_payout_tbl where advertiser_id='".$advertiser_id."' order by payoutid desc limit 1 "; 
	$res_payout=$conn->query($sql_payout);
	$row_payout=$res_payout->fetch();

	$sql_operator="select * from commondb.operator_tbl where operator = '".$operator."' ";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	$operator_id=$row_operator['operator_id'];
	
	$sql_advertiser_payout="select * from commondb.".$pro."_advertiser_payout_tbl where operatorid = '".$operator_id."'
	 and campaign_id = '".$campaign_id."'  order by adpayoutid desc limit 1 ";
	$res_advertiser_payout=$conn->query($sql_advertiser_payout);
	$row_advertiser_payout=$res_advertiser_payout->fetch();
	$campaign_payout=$row_advertiser_payout['payout'];
	
	
	if($row_advertiser_payout['payout'] == '')
	{
		$campaign_payout='0';
	}
	else
	{
		$campaign_payout=$row_advertiser_payout['payout']; 
	}
	
	if($row_payout['payout'] == '')
	{
		$payout='0';
	}
	else
	{
		$payout=$row_payout['payout']; 
	}
	$insert_payout="insert into ".$logdb.".payout_tbl (clickid,advertiser_id,payout,campaign_id,camp_payout) 
	values ('".$clickid."','".$advertiser_id."','".$payout."','".$campaign_id."','".$campaign_payout."')"; 
	$res_insert_payout=$conn->query($insert_payout);
}
else{}

	function SendResponse($response="ok")
	{
		set_time_limit(0);

		ob_end_clean();
		// Buffer all upcoming output...
		ob_start();
		// Send your response.
		echo $response;
		// Get the size of the output.
		$size = ob_get_length();
		// Disable compression (in case content length is compressed).
		header("Content-Encoding: none");
		// Set the content length of the response.
		header("Content-Length: {$size}");
		// Close the connection.
		header("Connection: close");
		// Flush all output.
		ob_end_flush();
		ob_flush();
		flush();
		// Close current session (if it exists).
		if(session_id()) session_write_close();
		
	}
	echo SendResponse();
	
	echo "ok";
?>