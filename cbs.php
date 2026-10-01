<?php

include("includes/connection.php");
include("includes/functions.php");
include("includes/language.php");
error_reporting(0);
//echo "ds"; exit;

$clickid=$_GET['clickid']; 
//$campaign_id=$_GET['campaign_id'];


if(strtolower($_GET['action']) == 'dct')
{
	$camp_action='dct';
}
else{
	$camp_action= 'act';
}


if($_GET['pro'] != '')
{
	$pro=strtolower($_GET['pro']);
}
else
{
	
	if($_GET['pubid'] == '')
	{
		$proid= substr($clickid,-4,2);
	}
	else
	{
		$pubid=$_GET['pubid'];
		$proid= substr($pubid,-4,2);
	}

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
	elseif($proid== 'ms')
	{
		$pro="music";
		$spo="music_spo_stopcallback";
		$act="music_act_stopcallback";
	}
	elseif($proid == 'ut')
	{
		$pro="utility";
	}
	else{}
}


//  If we could not get pubid then find from campaign_request_tbl by using clickid
if($_GET['pubid'] == '')
{
	
	$operatorid= substr($clickid,-2);

	//$operator=get_db($operatorid);  // to find operator from ip_operator_tbl
	$operator=get_operator($operatorid); // to find operator from operator_tbl 
	$operator= strtolower($operator['operator']);  


	
	
	if($pro == 'games')
	{
		if(strtolower($operator)=='vodafone' )
		{
			$logdb="voda_".$pro."db_2017";
		}
		elseif(strtolower($operator)=='idea')
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='airtel'  )
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='dtac'  )
		{
			$logdb=$operator."_".$pro."db_2017"; 
		}
		else
		{
			$logdb=$operator."_".$pro."db_2017"; 
			
		}
	
	}
	else
	{
		if(strtolower($operator)=='vodafone' )
		{
			$logdb="voda_".$pro."db_2017";
		}
		elseif(strtolower($operator)=='idea')
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='airtel'  )
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='dtac'  )
		{
			$logdb=$operator."_".$pro."db_2017"; 
		}
		else
		{
			$logdb=$operator."_".$pro."db_2017"; 
			
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
	
}
else
{
	$pubid=$_GET['pubid'];
	$operatorid= substr($pubid,-2); 

	//$operator=get_db($operatorid);  // to find operator from ip_operator_tbl
	$operator=get_operator($operatorid); // to find operator from operator_tbl 
	$operator= strtolower($operator['operator']); 

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
	
	
	
if($pro == 'games')
	{
		if(strtolower($operator)=='vodafone' )
		{
			$logdb="voda_".$pro."db_2017";
		}
		elseif(strtolower($operator)=='idea')
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='airtel'  )
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='dtac'  )
		{
			$logdb=$operator."_".$pro."db_2017"; 
		}
		else
		{
			$logdb=$operator."_".$pro."db_2017"; 
			
		}
	
	}
	else
	{
		if(strtolower($operator)=='vodafone' )
		{
			$logdb="voda_".$pro."db_2017";
		}
		elseif(strtolower($operator)=='idea')
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='airtel'  )
		{
			$logdb=$operator."_".$pro."db_0517"; 
		}
		elseif(strtolower($operator)=='dtac'  )
		{
			$logdb=$operator."_".$pro."db_2017"; 
		}
		else
		{
			$logdb=$operator."_".$pro."db_2017"; 
			
		}
	
	}
	
	$logdb=strtolower($logdb);
	$pubid=strtolower($_GET['pubid']);
}




date_default_timezone_set("Asia/Kolkata");
$datetime=date('Y-m-d H:i:s');



// campaign id fetch karva
$select_campaign="select * from ".$logdb.".campaign_request_tbl where clickid='".$clickid."' and pubid='".$pubid."'";   
$res_campaign=$conn->query($select_campaign);
$row_campaign=$res_campaign->fetch();
$campaign_id= $row_campaign['campaign_id']; 


if($campaign_id == '')
{
	$campaign_id = "0";
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
	$advertiser_id = "0";
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
		
		$sql_advertiser="select SUBSTRING_INDEX(SUBSTRING_INDEX(referrer_url,'".$param_value."=',-1),'&',1) '".$param_value."',
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
			// agar activation's clickid same day hase to 100% callback jase .. naitar je percentage decide karya hoy e rite jase callback .
			$sql_sameday="select * from ".$logdb.".userlog_tbl where clickid = '".$clickid."' and date(userlog_datetime) =  date(now())";
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
				$stopcallback_count=$row_callback_counter[$act]/10;
			
				if($callback_counter >= $stopcallback_count)
				{
					
					//$a=file_get_contents($edited_url); 
					$a="success";
					$callback_counter =$callback_counter-1;
					
					if($callback_counter == '-1')
					{
						$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '10' where advertiser_id ='".$advertiser_id."' ";
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
					if($callback_counter == '-1')
					{
						$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set act_callback_counter = '10' where advertiser_id ='".$advertiser_id."' ";
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
				$stopcallback_count=$row_callback_counter[$spo]/10;
			
				if($callback_counter >= $stopcallback_count)
				{
					
					//$a=file_get_contents($edited_url);
					$a="success";
					$callback_counter =$callback_counter-1;
					
					if($callback_counter == '-1')
					{
						$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '10' where advertiser_id ='".$advertiser_id."' ";
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
					if($callback_counter == '-1')
					{
						$update_counter="UPDATE ".$logdb.".advertiser_callback_counter_tbl set spo_callback_counter = '10' where advertiser_id ='".$advertiser_id."' ";
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



//  campaign callbackresponse ma entry padva .. je callback male apan ne ...
$insert_callback="insert into ".$logdb.".campaign_response_tbl (clickid,pubid,camp_resp_datetime,camp_action,campaign_id,advertiser_id) 
values ('".$clickid."','".$pubid."','".$datetime."','".$camp_action."','".$campaign_id."','".$advertiser_id."')"; 
$res_callback=$conn->query($insert_callback);


// Advertiser callbackresponse ma entry padva.. je callback apne advertiser ne mokaliye
$insert_ad_callback="insert into ".$logdb.".advertiser_response_tbl (advertiser_callbackurl,clickid,advertiser_clickid,pubid,ad_resp_datetime,action,campaign_id,advertiser_id,advertiser_response) values ('".$edited_url."','".$clickid."','".$ad_clickid."','".$pubid."','".$datetime."','".$camp_action."','".$campaign_id."','".$advertiser_id."','".$a."') "; 
$res_ad_callback=$conn->query($insert_ad_callback);


	echo "ok";
?>