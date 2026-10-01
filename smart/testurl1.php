<?php


date_default_timezone_set("asia/kolkata");
$date=date("H:i:s"); 

$min=date("i");


	
		include("includes/connection.php");
		include("includes/functions.php");
		include("includes/language.php"); //aa file ma variable 6 jema  database name  6.. je badhe access thase
		error_reporting(0);
		$referrer=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // advertiser referrer url
		$advertiser_id=$_GET['ad_id'];  // advertiser id
		$commondb="commondb";
		// redirection code if operator is not be.
		
		$campaign_id=$_GET['cmpid'];
		
		if($_GET['opid'] != '') // operator id na male to Gaurav bhai ni API par work karse
		{	
			
			
			$opid=$_GET['opid'];

			$select_operator="select * from ".$commondb.".operator_tbl where operator_id = '".$opid."'";
			$res_operator=$conn->query($select_operator);
			$row_operator=$res_operator->fetch();
			$country=$row_operator['country_id'];
			$operatorcode=$row_operator['operator_code'];
			$operator=$row_operator['operator'];
			$pubid=$_GET['pubid'];
			
			if($opid == 1 || $opid == '1')
			{
				$logdb="voda_glamourdb_2017";	
			}
			elseif( $opid == '2' || $opid == 2)
			{
				$logdb=$operator."_glamourdb_2017";	
			}
			elseif($opid == 3 || $opid == '3')
			{
				$logdb=$operator."_glamourdb_2017";
					
			}
			elseif($opid == 12 || $opid == '12' || $opid == 11 || $opid == '11')
			{
				$logdb=$operator."_glamourdb_2017";
			}
			elseif($opid == '14' || $opid == 14)
			{
				$logdb=$operator."_glamourdb_2017";
			}
			elseif($opid=='24' || $opid==24 || $opid=='26' || $opid==26 )
			{
				$logdb=$operator."_glamourdb_2017";
			}
			else
			{
				$logdb=$operator."_glamourdb_2017";
			}


		}
		
		else{
			
			header("Location: http://bit.ly/28SN1Lw");
				exit;

		}
		
	
		// creating clickid
		$mt = microtime(true);
		$mt =  $mt*1000; //microsecs
		$clickid = ((string)$mt*10).rand(1, 999);   // Get lick Id

		$pubid=$pubid."gl".$operatorcode; // Get pubid, It is for campaign
		$clickid1=$clickid."gl".$operatorcode;

		// Get Operator IP Address
		if($_SERVER['HTTP_X_FORWARDED_FOR']== '')
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		else{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}   

		// Get Xforward IP Address
		if($_SERVER['REMOTE_ADDR'] == '')
		{
			$xforward = '';
		}
		else
		{
			$xforward = $_SERVER['REMOTE_ADDR'];
		}

		$useragent=strtolower($_SERVER['HTTP_USER_AGENT']);  // Get USerAgent

		date_default_timezone_set("asia/kolkata");
		$time = date("H:i:s");
		$date=date("Y-m-d H:i:s");

		$browser='';
		$os='';

		$browser_os=get_browser_os($useragent); // useragent pass karine browser and os fetch karva
		$browser=$browser_os['browser'];// browser name 
		$os=$browser_os['os']; // os name

		// userlog ma entry padva
		$sql_userlog="insert into ".$logdb.".userlog_tbl (userlog_datetime,country,operator,ip,xforward,browser,os,clickid,pubid,advertiser_id,referrer_url) values 
		('".$date."','".$country."','".$operator."','".$ip."','".$xforward."','".$browser."','".$os."','".$clickid."','".$pubid."','".$advertiser_id."','".$referrer."')"; 
		$res_userlog=$conn->query($sql_userlog);


					// aa query first campaign fetch karva.. eva ke je active hoy and time duration ma avta hoy
					$sql_camp="
										SELECT 
											* 
										FROM
											".$logdb.".campaign_tbl
										WHERE
											campaign_country='".$country."'
												AND ((time(campaign_startdatetime) <= '".$time."' 
												AND time(campaign_startdatetime) <= '23:59:59') or 
                                                (time(campaign_enddatetime) >= '".$time."' ))
												AND campaign_browser like '%".$browser."%' 
												AND campaign_os like '%".$os."%'
												AND campaign_id = '".$campaign_id."'
												
								ORDER BY  campaign_id 
								LIMIT 1";  // Fetch First Campaign of Operator Vodafone
								
						
					$res_camp=$conn->query($sql_camp) or die(print_r($conn->error));
					$row_camp=$res_camp->fetch();	
					$num_camp=$res_camp->rowCount(); 
					
				
					$res_camp = null;
					

				
								// This URL is used for insert in campaign_request_tbl						
								$url=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid1,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 
								// This is Url is used to redirect.
								//$url1=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid.$operatorcode,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 

								date_default_timezone_set("Asia/Kolkata");
								$date=date("Y-m-d H:i:s"); // Current date and time
								
								
								if($campaign_id == '')
								{
									$campaign_id="0";
								}
								
								if($advertiser_id == '')
								{
									$advertiser_id="0";
								}
								
								
								$update_tracking="update ".$logdb.".campaign_tracking_tbl set campaign_id=set_id where camp_track_id=1";
								$res_tracking=$conn->query($update_tracking);

								$insert_camp_req="insert into ".$logdb.".campaign_request_tbl (camp_req_url,clickid,pubid,camp_req_datetime,campaign_id,advertiser_id)
								values ('".$url."','".$clickid."','".$pubid."','".$date."','".$campaign_id."','".$advertiser_id."')";
								$res_camp_req=$conn->query($insert_camp_req); 
			
			
								
						
								header("Location: $url");
												

?>