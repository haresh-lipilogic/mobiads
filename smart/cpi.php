<?php
include("includes/connection.php");
$commondb="commondb";
date_default_timezone_set("asia/kolkata");
error_reporting(0);
$date=date("H:i:s"); 

$min=date("i");


	
		$referrer=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // advertiser referrer url
		$referrerurl= $_SERVER['HTTP_REFERER']; //  Referrer URL
		
		if($_GET['ad_id'] =='')
		{
			$advertiser_id=$_GET['adid'];  // advertiser id
		}
		else{
			$advertiser_id=$_GET['ad_id'];  // advertiser id
		}
		

		
		// redirection code if operator is not be.
		

		if($_GET['opid'] != '') // operator id na male to Gaurav bhai ni API par work karse
		{	
			//echo "n"; exit;
			
			$opid=$_GET['opid'];
 
			$select_operator="select * from ".$commondb.".operator_tbl where operator_id = '".$opid."'";
			$res_operator=$conn->query($select_operator);
			$row_operator=$res_operator->fetch();
			$country=$row_operator['country_id'];
			$operatorcode=$row_operator['operator_code'];
			$operator=$row_operator['operator'];
			
			$pubid=$_GET['pubid'];
			
			
			$logdb=$operator."_glamourdb_cpi";

		}
		else{
			
			

		}
		
	// BLOCKED APP TRAFFIC LOGIC START
	/*
	$xforwardwith=strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);		
	if($opid == '7' || $opid == '42' )
	{
		$xforwardwith=strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
		//$xforwardwith='com.nemo.vidmate';



		if($xforwardwith != '')
			{
			
			//app data fetching
			 $sql23 = "SELECT * from commondb.appblock  where apps like '%".$xforwardwith."%'";
				$me=$conn->query($sql23);
				
				 $rowcount22=$me->fetch();  
				
				if ($rowcount22['apps']==  $xforwardwith)
				{
					
					$clickid=$_GET['clickid']; 
					$pubid=$_GET['pubid'];
					$advertiser_id=$_GET['ad_id']; 
					
					$newdate=date("Y-m-d H:i:s");
					$flag=1;
					$insert="INSERT INTO `commondb`.`blockedtraffic`
							(
							`app`,
							`clickid`,
							`opid`,
							`advertiserid`,
							`blockdate`)
							VALUES
							(
							'".$xforwardwith."',
							'".$clickid."',
							'".$opid."',
							'".$advertiser_id."',
							'".$newdate."');
							";
					$res=$conn->query($insert);
					
					
						
					
					//$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid."";
					//if block
					$url="http://hlobald.com/PL74K/raTK/o6Da/--yNId625B2skxN9sqehY30FzGF0NoDCR34VhC0U9s1zhvdUM4wF?qa0=Adult";
					header("location:".$url); 
					exit;
				}
				else
				{
					$clickid=$_GET['clickid']; 
					$pubid=$_GET['pubid'];
					$advertiser_id=$_GET['ad_id']; 
					
					$newdate=date("Y-m-d H:i:s");
					$flag=1;
					$insert="INSERT INTO `commondb`.`unblockedtraffic`
							(
							`app`,
							`clickid`,
							`opid`,
							`advertiserid`,
							`blockdate`)
							VALUES
							(
							'".$xforwardwith."',
							'".$clickid."',
							'".$opid."',
							'".$advertiser_id."',
							'".$newdate."');
							";
					$res=$conn->query($insert);
					
				
						
					
				}
			
			}
	}
	else{}
	*/
	// BLOCKED APP TRAFFIC LOGIC END
		
		
		
	// PUBID BLOCKING LOGIC START	
	/*
		$sql_pub="select * from ".$logdb.".pub_blocking_tbl where pubid = '".$pubid."' and advertiser_id='".$advertiser_id."' limit 1 "; 
		$res_pub=$conn->query($sql_pub);
		$row_pub=$res_pub->fetch();
		$res_pub->rowCount(); 
		if($res_pub->rowCount() > 0)
		{
			if($row_pub['pubid_isactive'] == '1')
			{
			}
			else{
				
				
			}
		}
		else
		{
				
		}	
		*/
		// PUBID BLOCKING LOGIC STOP
		
		
		
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

		// get Browser
		if(strpos($useragent,"opera") > -1)
		{
			$browser="opera";
		}
		elseif(strpos($useragent,"ucb") > -1 )
		{
			$browser="ucb";
		}
		elseif(strpos($useragent,"chrome") > -1 )
		{
			$browser="chrome";
		}
		else
		{
			$browser="other";
		}
		
		// get OS
		if(strpos($useragent,"android") > -1)
		{
			$os="android";
		}
		elseif(strpos($useragent,"iphone") > -1)
		{
			$os="iphone";
		}
		elseif(strpos($useragent,"windows") > -1)
		{
			$os="windows";
		}
		elseif(strpos($useragent,"linux") > -1)
		{
			$os="linux";
		}
		else
		{
			$os="other";
		}

		date_default_timezone_set("asia/kolkata");
		$time = date("H:i:s");
		$date=date("Y-m-d H:i:s");





		// advertiser active 6 ke nai e check karva
		$sql_advertiser="select * from ".$commondb.".advertiser_tbl where advertiser_id = '".$advertiser_id."' "; 
		$res_advertiser=$conn->query($sql_advertiser);
		$row_advertiser=$res_advertiser->fetch();
		$isactive=$row_advertiser['advertiser_isactive']; 
		if($isactive != '0')
		{

		// check karva campaign automatic chalu karva 6 ke manually
		$sql_auto="select * from ".$logdb.".campaign_type_tbl where camp_operator='".$operator."'"; 
		$res_auto=$conn->query($sql_auto);
		$row_auto=$res_auto->fetch();

		// userlog ma entry padva
		$sql_userlog="insert into ".$logdb.".userlog_tbl (userlog_datetime,country,operator,ip,xforward,browser,os,clickid,pubid,advertiser_id,referrer_url,pageurl) values 
		('".$date."','".$country."','".$operator."','".$ip."','".$xforward."','".$browser."','".$os."','".$clickid."','".$pubid."','".$advertiser_id."','".$referrer."','".$referrerurl."')"; 
		$res_userlog=$conn->query($sql_userlog);

	
		if($row_auto['camp_type'] == '1')
		{
			
			$sql_weight="select * from ".$logdb.".campaign_weightage_tbl where camp_weightage_operator='".$operator."' limit 1";  
			$res_weight=$conn->query($sql_weight);
			$row_weight=$res_weight->fetch();
			
			$a=explode(",",$row_weight['camp_weightage_perc']);
			
			$a1= round($a[0]/10); 
			$b1=round($a[1]/10); 
			
			for($i=$a1+1;$i<=10;$i++)
			{
				$number.=$i.",";
			}
			$number = trim($number,',');
			// badha campaign deactive karva mate. Je campaign nu activation count vadhi jase to e deactive thai jase.
			
			// CAPPING LOGIC START
				
			/*		$sql_count_act="
							SELECT 
								COUNT(capping_tbl.campaign_id) total_capping, capping_count, capping_tbl.campaign_id camp_id
							FROM
								".$logdb.".campaign_response_tbl
									INNER JOIN
								".$logdb.".capping_tbl ON capping_tbl.campaign_id = campaign_response_tbl.campaign_id
									INNER JOIN 
									".$logdb.".campaign_tbl on campaign_tbl.campaign_id=campaign_response_tbl.campaign_id
								WHERE
									camp_resp_datetime>='".$date." 00:00:00' and camp_resp_datetime <= '".$date." 23:59:59'
									and camp_action='act'
							group by camp_id,capping_count
							
							";    
				$res_count_act=$conn->query($sql_count_act);
				$cap_num=$res_count_act->rowCount();
				
				if($cap_num > 0)
				{
					while($row_count_act=$res_count_act->fetch())
					{
					
						if($row_count_act['capping_count'] == 0 || $row_count_act['capping_count'] == '0')
						{
							$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=1 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
						}
						else{
							if($row_count_act['total_capping'] > $row_count_act['capping_count'])
							{
								$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=0 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
					
							}
							else
							{
								$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=1 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
							}
						}
							
						

					}
				}
				else
				{
					$sql_capping="select * from ".$logdb.".capping_tbl;";
					$res_capping=$conn->query($sql_capping);
					while($row_capping=$res_capping->fetch())
					{
						$update_camp_cap="update ".$logdb.".campaign_tbl set campaign_live =1 where campaign_id ='".$row_capping['campaign_id']."'";
						$res_camp_cap=$conn->query($update_camp_cap);
						
							$select="select * from ".$logdb.".running_campaign_tbl order by run_camp_id desc limit 1";
							$res_select=$conn->query($select);
							$row_select=$res_select->fetch();
							$row1=$row_select['run_camp_id']+1;
						
						$insert_run_camp="insert into ".$logdb.".running_campaign_tbl (run_camp_id,campaign_id,run_camp_operator,run_camp_track) values ('".$row1."','".$row_capping['campaign_id']."','".$operator."','0')";		
						$res_insert=$conn->query($insert_run_camp);
					}
				}
				
				*/
				// CAPPING LOGIC END
				
				// Counter logic
				// counter value fetch karva
				$sql_counter="select * from ".$logdb.".counter_tbl limit 1";
				$res_counter=$conn->query($sql_counter);
				$row_counter=$res_counter->fetch();
				
				
			
				if($row_counter['counter_no'] == '10')
				{
					
					// counter value counter_no  zero
					if($row_counter['counter_id'] == '')
					{
						$insert_counter="insert into  ".$logdb.".counter_tbl (counter_id,counter_no) values ('1','0')";
						$insert_res=$conn->query($insert_counter);

					}
					else
					{
						$update_counter="update ".$logdb.".counter_tbl set counter_no=0 where counter_id='".$row_counter['counter_id']."'";
						$update_res=$conn->query($update_counter);
					}
					
					
					$sql_counter="select * from ".$logdb.".counter_tbl limit 1";
					$res_counter=$conn->query($sql_counter);
					$row_counter=$res_counter->fetch();
					
					$counter_no =$row_counter['counter_no']+1; 
					$update_counter="update ".$logdb.".counter_tbl set counter_no='".$counter_no ."' where counter_id='1'";
					$update_res=$conn->query($update_counter);
					
					// counter 10 thai jay pa6i badha campaign 0 thai jay.
					$update_track="update ".$logdb.".running_campaign_tbl set run_camp_track=0  where run_camp_operator='".$operator."' and run_camp_track not in (".$number.") ";
					$res_track=$conn->query($update_track);	
					
					
					// jya run_camp_track 10 hoy tya 101 update karva..
					$update_track1="update ".$logdb.".running_campaign_tbl set run_camp_track=101  where run_camp_operator='".$operator."' and run_camp_track in (".$number.") ";
					$res_track1=$conn->query($update_track1);	
				}
				
				else
				{
					$counter_no=$row_counter['counter_no']+1; 
					$update_counter="update ".$logdb.".counter_tbl set counter_no='".$counter_no."' where counter_id='1'";
					$update_res=$conn->query($update_counter);			
				}
				// percentage count condition
				if($counter_no  <= $a1)
				{

					// aa query first campaign fetch karva.. eva ke je active hoy and time duration ma avta hoy
				$sql_camp="SELECT 
									running_campaign_tbl.run_camp_id as run_camp_id,
									campaign_url,
									running_campaign_tbl.campaign_id,
									campaign_startdatetime startdatetime,
									campaign_enddatetime enddatetime
								FROM
									".$logdb.".campaign_tbl
										INNER JOIN
									".$logdb.".running_campaign_tbl ON campaign_tbl.campaign_id =running_campaign_tbl.campaign_id
								WHERE
									campaign_tbl.campaign_operator = '".$operator."'
									AND campaign_tbl.campaign_id  IN (
										SELECT 
											campaign_id 
										FROM
											".$logdb.".campaign_tbl
										WHERE
											campaign_live=1 
												AND campaign_country='".$country."'
												AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end)
												AND campaign_browser like '%".$browser."%' 
												AND campaign_os like '%".$os."%'
												AND campaign_id NOT IN (SELECT 
													campaign_id
												FROM
													".$logdb.".advertiser_blocking_tbl
												WHERE
													advertiser_id = '".$advertiser_id."' )
												)
								ORDER BY  running_campaign_tbl.run_camp_id 
								LIMIT 1";  // Fetch First Campaign of Operator Vodafone
								
							
					$res_camp=$conn->query($sql_camp) or die(print_r($conn->error));
					$row_camp=$res_camp->fetch();	
					$num_camp=$res_camp->rowCount(); 
					
					//if($num_camp == '' || $num_camp == 0 || $num_camp == '0')
					//{
					//	header("Location: http://hlobald.com/PL74K/raTK/o6Da/--yNId625B2skxN9sqehY30FzGF0NoDCR34VhC0U9s1zhvdUM4wF?qa0=Adult");
					//	break;
					//}
					$res_camp = null;
					
					//echo $row_camp['run_camp_id']; exit;	
					

							$sql_track="select * from ".$logdb.".campaign_tracking_tbl limit 1";   
							$res_track=$conn->query($sql_track) or die(print_r($conn->error));
							$row_track=$res_track->fetch();	
							$res_track = null;
						 
					/*		if($counter_no % 2 != 0)
							{
								
								$sql_last="select * from ".$logdb.".running_campaign_tbl where run_camp_operator= '".$operator."'  and
								campaign_id in (SELECT 
									campaign_id
								FROM
									".$logdb.".campaign_tbl
								WHERE
									campaign_live=1 
										AND campaign_country='".$country."'
										AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end) 
										AND campaign_browser like '%".$browser."%' 
										AND campaign_os like '%".$os."%' 
										AND campaign_tbl.campaign_id NOT IN (SELECT 
											campaign_id
										FROM
											".$logdb.".advertiser_blocking_tbl
										WHERE
											advertiser_id = '".$advertiser_id."' ))order by run_camp_id asc limit 1";
								$res_last=$conn->query($sql_last);
								$row_last=$res_last->fetch();
								
								$update_last="update ".$logdb.".running_campaign_tbl set run_camp_track='".$counter_no."' where run_camp_operator='".$operator."' 
								and run_camp_id='".$row_last['run_camp_id']."'";
								$update_res_last=$conn->query($update_last);
								
								
							}
							else
							{
								
								$no=$counter_no -1 ;
								$sql_last="select * from ".$logdb.".running_campaign_tbl where run_camp_operator= '".$operator."' 
								and  run_camp_track < '".$no."' and campaign_id in (SELECT 
										campaign_id
									FROM
										".$logdb.".campaign_tbl
									WHERE
										campaign_live=1 
											AND campaign_country='".$country."'
											AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end)
											AND campaign_browser like '%".$browser."%' 
											AND campaign_os like '%".$os."%'
											AND campaign_tbl.campaign_id NOT IN (SELECT 
												campaign_id
											FROM
												".$logdb.".advertiser_blocking_tbl
											WHERE
												advertiser_id = '".$advertiser_id."' )) order by run_camp_id asc limit 1"; 
											
								$res_last=$conn->query($sql_last);
								$row_last=$res_last->fetch();
								
								
							
							
								
								
							}
			
						*/	
						
						
						$update_last="update ".$logdb.".running_campaign_tbl set run_camp_track='".$counter_no."' where run_camp_operator='".$operator."' 
								and run_camp_id='".$row_camp['run_camp_id']."'";
								$update_res_last=$conn->query($update_last);
								
							if($row_track['campaign_id'] == '0') // If campaign_id is zero then Update with first Campaign_ID of Vodafone
							{
								

							// This URL is used for insert in campaign_request_tbl						
							$url=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid1,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 
						// This is Url is used to redirect.
						//$url1=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid.$operatorcode,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 

								date_default_timezone_set("Asia/Kolkata");
								$date=date("Y-m-d H:i:s"); // Current date and time
								
								if($row_camp['campaign_id'] == '0' || $row_camp['campaign_id'] == 0)
								{
									$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
															
													WHERE
														campaign_live = 1 
													LIMIT 1";
									$res_camp_id=$conn->query($select_camp_id);
									$row_camp_id=$res_camp_id->fetch();
									$campaign_id=$row_camp_id['campaign_id'];
								}
								else
								{
									
									$campaign_id=$row_camp['campaign_id'];
									
									$sql_isblock="select * from ".$logdb.".advertiser_blocking_tbl 
									where campaign_id='".$campaign_id."' and advertiser_id = '".$advertiser_id."' ";
									$res_isblock=$conn->query($sql_isblock);
									$row_isblock=$res_isblock->fetch();
									if($row_isblock['campaign_id'] == '')
									{
										$campaign_id=$row_camp['campaign_id'];
									}
									else
									{
										$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
															
													WHERE
														campaign_live = 1 
													LIMIT 1";
										$res_camp_id=$conn->query($select_camp_id);
										$row_camp_id=$res_camp_id->fetch();
										$campaign_id=$row_camp_id['campaign_id'];
									}
									
									
								}
								
								if($campaign_id == '')
								{
									$campaign_id="0";
								}
								
								if($advertiser_id == '')
								{
									$advertiser_id="0";
								}
								
								$update_track="call ".$logdb.".update_campaign_and_insert_request
								('".$operator."','".$row_camp['run_camp_id']."','".$row_track['campaign_id']."','".$pubid."','".$date."','".$url."','".$clickid."','".$campaign_id."','".$advertiser_id."')"; 	
							
								$update_res=$conn->query($update_track);
								$update_res=null;
								$clickid=null;
								
							//	echo "<script>window.location='".$url."';</script>";
							
								header("Location: $url");

							}
							else
							{	
											//$sql_camp="call ip_operator.fetch_campaign_id('vodafone','".$row_track['vodafone_camp_id']."')"; 
								$sql_camp="SELECT 
												running_campaign_tbl.run_camp_id,
												campaign_url,
												running_campaign_tbl.campaign_id
											FROM
												".$logdb.".campaign_tbl
													INNER JOIN
												".$logdb.".running_campaign_tbl ON campaign_tbl.campaign_id = running_campaign_tbl.campaign_id
											WHERE
												campaign_tbl.campaign_live=1 
												AND campaign_tbl.campaign_operator = '".$operator."'
												AND campaign_tbl.campaign_country='".$country."'
												AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end)
												AND campaign_tbl.campaign_browser like '%".$browser."%' 
												AND campaign_tbl.campaign_os like '%".$os."%'
												AND run_camp_track = '".$counter_no."'
												AND campaign_tbl.campaign_id NOT IN (SELECT 
													campaign_id
												FROM
													".$logdb.".advertiser_blocking_tbl
												WHERE
													advertiser_id = '".$advertiser_id."' )
											ORDER BY  running_campaign_tbl.run_camp_id 
											LIMIT 1;
									"; 
								$res_camp=$conn->query($sql_camp);
								$row_camp=$res_camp->fetch();	
								
								$res_camp=null;
								
										
								

								// This URL is used for insert in campaign_request_tbl						
								$url=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid1,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 
								// This is Url is used to redirect.
								//$url1=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid.$operatorcode,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 

								date_default_timezone_set("Asia/Kolkata");
								$date=date("Y-m-d H:i:s"); // Current date and time
								
								
								if($row_camp['campaign_id'] == '0' || $row_camp['campaign_id'] == 0)
								{
									$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
															
													WHERE
														campaign_live = 1 
													LIMIT 1";
									$res_camp_id=$conn->query($select_camp_id);
									$row_camp_id=$res_camp_id->fetch();
									$campaign_id=$row_camp_id['campaign_id'];
								}
								else
								{
									
									$campaign_id=$row_camp['campaign_id'];
									
									$sql_isblock="select * from ".$logdb.".advertiser_blocking_tbl 
									where campaign_id='".$campaign_id."' and advertiser_id = '".$advertiser_id."' ";
									$res_isblock=$conn->query($sql_isblock);
									$row_isblock=$res_isblock->fetch();
									if($row_isblock['campaign_id'] == '')
									{
										$campaign_id=$row_camp['campaign_id'];
									}
									else
									{
										$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
														
													WHERE
														campaign_live = 1
													LIMIT 1";
										$res_camp_id=$conn->query($select_camp_id);
										$row_camp_id=$res_camp_id->fetch();
										$campaign_id=$row_camp_id['campaign_id'];
									}
									
									
								}
								
								if($campaign_id == '')
								{
									$campaign_id="0";
								}
								
								if($advertiser_id == '')
								{
									$advertiser_id="0";
								}
								
								
								$update_track="call ".$logdb.".update_campaign_and_insert_request
								('".$operator."','".$row_camp['run_camp_id']."','".$row_track['campaign_id']."','".$pubid."','".$date."','".$url."','".$clickid."','".$campaign_id."','".$advertiser_id."')";  
								$update_res=$conn->query($update_track);
								$update_res=null;	
								$clickid=null;
								
									//echo "<script>window.location='".$url."';</script>";
									//$conn=null;
  
								header("Location: $url");
												
							}
						
			
				}
				else
				{

					
					 $sql_camp="SELECT 
									running_campaign_tbl.run_camp_id as run_camp_id,
									campaign_url,
									running_campaign_tbl.campaign_id,
									campaign_startdatetime startdatetime,
									campaign_enddatetime enddatetime
								FROM
									".$logdb.".campaign_tbl
										INNER JOIN
									".$logdb.".running_campaign_tbl ON campaign_tbl.campaign_id = running_campaign_tbl.campaign_id
								WHERE
									campaign_tbl.campaign_operator = '".$operator."'
									AND run_camp_track=0
									AND campaign_tbl.campaign_id  IN (
										SELECT 
											campaign_id 
										FROM
											".$logdb.".campaign_tbl
										WHERE
											campaign_live=1 
												AND campaign_country='".$country."'
												AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end)
												AND campaign_browser like '%".$browser."%' 
												AND campaign_os like '%".$os."%'
												AND campaign_tbl.campaign_id NOT IN (SELECT 
													campaign_id
												FROM
													".$logdb.".advertiser_blocking_tbl
												WHERE
													advertiser_id = '".$advertiser_id."' ))
								ORDER BY  running_campaign_tbl.run_camp_id 
								LIMIT 1";    // Fetch First Campaign of Operator Vodafone
							
					$res_camp=$conn->query($sql_camp) or die(print_r($conn->error));
					$row_camp=$res_camp->fetch();	
					$res_camp = null;
					
					
					// jya sudhi 0 track walu campaign na male tya sudhi 101 update nai thay. agar jo badhi track value 0 sivay hoy to update karse 101 ne 0 thi.
					
					if($row_camp['run_camp_id']== '' )
					{
						
						// Badha 101 wala campaign ne 0 banavi deva. 
						//$update_101="update ".$logdb.".voda_running_campaign_tbl set run_camp_track=0 where run_camp_operator='vodafone' 
						//and run_camp_track=101 or run_camp_track='".$row_last_track['a']."'"; 
						//$res_101=$conn->query($update_101);
						
						
						$sql_camp="SELECT 
									running_campaign_tbl.run_camp_id as run_camp_id,
									campaign_url,
									running_campaign_tbl.campaign_id,
									campaign_startdatetime startdatetime,
									campaign_enddatetime enddatetime, run_camp_track
								FROM
									".$logdb.".campaign_tbl
										INNER JOIN
									".$logdb.".running_campaign_tbl ON campaign_tbl.campaign_id = running_campaign_tbl.campaign_id
								WHERE
									campaign_tbl.campaign_operator = '".$operator."'
									
									AND campaign_tbl.campaign_id  IN (
										SELECT 
											campaign_id 
										FROM
											".$logdb.".campaign_tbl
										WHERE
											campaign_live=1 
												AND campaign_country='".$country."'
												AND (case when day(campaign_startdatetime) = day(campaign_enddatetime) then 
        (HOUR(campaign_startdatetime) <= HOUR('".$time."') AND HOUR(campaign_enddatetime)>= HOUR('".$time."')) else 
        HOUR(campaign_startdatetime)  <= HOUR('".$time."') or HOUR(campaign_enddatetime)>= HOUR('".$time."') end)
												AND campaign_browser like '%".$browser."%' 
												AND campaign_os like '%".$os."%' )
												AND campaign_tbl.campaign_id NOT IN (SELECT 
													campaign_id
												FROM
													".$logdb.".advertiser_blocking_tbl
												WHERE
													advertiser_blocking_tbl.advertiser_id = '".$advertiser_id."' )
								ORDER BY  run_camp_track desc
								LIMIT 1";   // Fetch First Campaign of Operator Vodafone
								
						$res_camp=$conn->query($sql_camp) or die(print_r($conn->error));
						$row_camp=$res_camp->fetch();	
						$res_camp = null;
						
					}
					
					$update_last="update ".$logdb.".running_campaign_tbl set run_camp_track='".$counter_no."' where run_camp_operator='".$operator."' 
					and run_camp_id='".$row_camp['run_camp_id']."'";
					$update_res_last=$conn->query($update_last);
				
					$update_camp_weight="update ".$logdb.".campaign_tbl set campaign_weight_track='".$update_weight."' where campaign_id=
					'".$row_camp['campaign_id']."'";
					$res_camp_weight=$conn->query($update_camp_weight);
				
				
					

					// This URL is used for insert in campaign_request_tbl						
					$url=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid1,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url']))); 
					// This is Url is used to redirect.
					//$url1=str_replace('[pubid]',$pubid,str_replace('[clickid]',$clickid.$operatorcode,str_replace('[advid]',$advertiser_id,$row_camp['campaign_url'])));  

					date_default_timezone_set("Asia/Kolkata");
					$date=date("Y-m-d H:i:s"); // Current date and time
					
					
					if($row_camp['campaign_id'] == '0' || $row_camp['campaign_id'] == 0)
								{
									$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
															
													WHERE
														campaign_live = 1 
													LIMIT 1";
									$res_camp_id=$conn->query($select_camp_id);
									$row_camp_id=$res_camp_id->fetch();
									$campaign_id=$row_camp_id['campaign_id'];
								}
								else
								{
									
									$campaign_id=$row_camp['campaign_id'];
									
									$sql_isblock="select * from ".$logdb.".advertiser_blocking_tbl 
									where campaign_id='".$campaign_id."' and advertiser_id = '".$advertiser_id."' ";
									$res_isblock=$conn->query($sql_isblock);
									$row_isblock=$res_isblock->fetch();
									if($row_isblock['campaign_id'] == '')
									{
										$campaign_id=$row_camp['campaign_id'];
									}
									else
									{
										$select_camp_id = "SELECT 
														*
													FROM
														".$logdb.".campaign_tbl
														
													WHERE
														campaign_live = 1
													LIMIT 1";
										$res_camp_id=$conn->query($select_camp_id);
										$row_camp_id=$res_camp_id->fetch();
										$campaign_id=$row_camp_id['campaign_id'];
									}
									
									
								}
								
								if($campaign_id == '')
								{
									$campaign_id="0";
								}
								
								if($advertiser_id == '')
								{
									$advertiser_id="0";
								}
					
					$update_track="call ".$logdb.".update_campaign_and_insert_request
								('".$operator."','".$row_camp['run_camp_id']."','".$row_track['campaign_id']."','".$pubid."','".$date."','".$url."','".$clickid."','".$campaign_id."','".$advertiser_id."')"; 
					$update_res=$conn->query($update_track);
					$update_res=null;
					$clickid=null;
				
				
				}
					
			
					//echo "<script>window.location='".$url."';</script>";
					//$conn=null;
  
					header("Location: $url");
			
			
		}
		else // Manually 
		{
			
					// counter value fetch karva
					$sql_counter="select * from ".$logdb.".counter_tbl limit 1";
					$res_counter=$conn->query($sql_counter);
					$row_counter=$res_counter->fetch();
				
			
					
					
					$sql_last_track="
					select * 
						from 
							".$logdb.".campaign_tbl 
						where  
							((time(campaign_startdatetime) <= '".$time."' 
												AND time(campaign_startdatetime) <= '23:59:59') or 
                                                (time(campaign_enddatetime) >= '".$time."' ))
							AND campaign_weight_track != 0
							and campaign_live=1
							AND campaign_country='".$country."'			 
							AND campaign_browser like '%".$browser."%' 
							AND campaign_os like '%".$os."%'								
							AND campaign_tbl.campaign_id NOT IN (SELECT 
									campaign_id
								FROM
									".$logdb.".advertiser_blocking_tbl
								WHERE
									advertiser_id = ".$advertiser_id." )";
									
					$res_last_track=$conn->query($sql_last_track);
					$row_last_track=$res_last_track->fetch();
				
					if($row_last_track['campaign_id'] == '')
					{
						// counter value counter_no zero
						$update_counter="update ".$logdb.".counter_tbl set counter_no=1 where counter_id='1'";
						$update_res=$conn->query($update_counter);
						
						$sql_weight="select * from ".$logdb.".campaign_tbl";
						$res_weight=$conn->query($sql_weight);
						while($row_weight=$res_weight->fetch())
						{
							$update_all_weight="update ".$logdb.".campaign_tbl set campaign_weight_track='".$row_weight['campaign_weight']."'
							where campaign_id='".$row_weight['campaign_id']."'";
							$res_all_weight=$conn->query($update_all_weight);
						}
								
						$update_counter="update ".$logdb.".running_campaign_tbl set run_camp_track=0 ";
						$update_res=$conn->query($update_counter);
						
						$counter_no=1;
						
						
					}
					else{
				
						$counter_no=$row_counter['counter_no']+1; 
						$update_counter="update ".$logdb.".counter_tbl set counter_no='".$counter_no ."' where counter_id='1'";
						$update_res=$conn->query($update_counter);
					
					
					}
				
				
				
				$sql_count_act="
							SELECT 
								COUNT(capping_tbl.campaign_id) total_capping, capping_count, capping_tbl.campaign_id camp_id
							FROM
								".$logdb.".campaign_response_tbl
									INNER JOIN
								".$logdb.".capping_tbl ON capping_tbl.campaign_id = campaign_response_tbl.campaign_id
									INNER JOIN 
									".$logdb.".campaign_tbl on campaign_tbl.campaign_id=campaign_response_tbl.campaign_id
								WHERE
									camp_resp_datetime>='".date('Y-m-d')." 00:00:00' and camp_resp_datetime <= '".date('Y-m-d')." 23:59:59'
									and camp_action='act'
							group by camp_id,capping_count
							
							";    
				$res_count_act=$conn->query($sql_count_act);
				
				$cap_num=$res_count_act->rowCount();
				if($cap_num > 0)
				{
					while($row_count_act=$res_count_act->fetch())
					{
					
						if($row_count_act['capping_count'] == 0 || $row_count_act['capping_count'] == '0')
						{
							$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=1 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
						}
						else{
							if($row_count_act['total_capping'] > $row_count_act['capping_count'])
							{
								$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=0 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
					
							}
							else
							{
								$update_act_camp="update ".$logdb.".campaign_tbl set campaign_live=1 where campaign_id='".$row_count_act['camp_id']."'";
								$res_act_camp=$conn->query($update_act_camp);
							}
						}
							
						

					}
				}
				else{
					$sql_capping="select * from ".$logdb.".capping_tbl;";
					$res_capping=$conn->query($sql_capping);
					while($row_capping=$res_capping->fetch())
					{
						$update_camp_cap="update ".$logdb.".campaign_tbl set campaign_live =1 where campaign_id ='".$row_capping['campaign_id']."'";
						$res_camp_cap=$conn->query($update_camp_cap);
						
							$select="select * from ".$logdb.".running_campaign_tbl order by run_camp_id desc limit 1";
							$res_select=$conn->query($select);
							$row_select=$res_select->fetch();
							$row1=$row_select['run_camp_id']+1;
						
						$insert_run_camp="insert into ".$logdb.".running_campaign_tbl (run_camp_id,campaign_id,run_camp_operator,run_camp_track) values ('".$row1."','".$row_capping['campaign_id']."','".$operator."','0')";		
						$res_insert=$conn->query($insert_run_camp);
					}
				}
				
				
				$sql_camp="
							SELECT 
								*
							FROM
								".$logdb.".campaign_tbl
									INNER JOIN
								".$logdb.".running_campaign_tbl ON campaign_tbl.campaign_id = running_campaign_tbl.campaign_id 
							WHERE 
								campaign_weight_track != 0 
										AND campaign_live=1 
										AND campaign_country='".$country."'
										AND ((time(campaign_startdatetime) <= '".$time."' 
												AND time(campaign_startdatetime) <= '23:59:59') or 
                                                (time(campaign_enddatetime) >= '".$time."' ))
										AND campaign_browser like '%".$browser."%' 
										AND campaign_os like '%".$os."%'								
										AND campaign_tbl.campaign_id NOT IN (SELECT 
										campaign_id
									FROM
										".$logdb.".advertiser_blocking_tbl
									WHERE
										advertiser_id = ".$advertiser_id." )
							LIMIT 1;
							";  
						$res_camp=$conn->query($sql_camp);
						$row_camp=$res_camp->fetch();
						$res_camp=null;
						
						/* $sql_pub="select * from ".$logdb.".pub_camp_blocking_tbl where pub = '".$pubid1."' 
						and campaign_id= '".$row_camp['campaign_id']."'"; 
						$res_pub=$conn->query($sql_pub);
						$row_pub=$res_pub->rowCount();
						
						if($row_pub > 0)
						{
							header("Location: http://hlobald.com/PL74K/raTK/o6Da/--yNId625B2skxN9sqehY30FzGF0NoDCR34VhC0U9s1zhvdUM4wF?qa0=Adult");
							exit;
						}
						
						*/
					
				
				
				$update_weight=$row_camp['campaign_weight_track']-1;	
				
				$sql_track="select * from ".$logdb.".campaign_tracking_tbl limit 1;";  
				$res_track=$conn->query($sql_track) or die(print_r($conn->error));
				$row_track=$res_track->fetch();	
				$res_track = null;
				
				if($row_camp['campaign_weight_track'] != 0)
				{
					
					$update_last="update ".$logdb.".running_campaign_tbl set run_camp_track='".$counter_no."' where run_camp_operator='".$operator."' 
					and run_camp_id='".$row_camp['run_camp_id']."'";
					$update_res_last=$conn->query($update_last);
					
					$update_camp_weight="update ".$logdb.".campaign_tbl set campaign_weight_track='".$update_weight."' where campaign_id=
					'".$row_camp['campaign_id']."'"; 
					$res_camp_weight=$conn->query($update_camp_weight);
					
					//$sql_pub="select * from ".$logdb.".pub_camp_blocking_tbl where pub = '".$pubid1."' 
					//	and campaign_id= '".$row_camp['campaign_id']."'"; exit; 
					//	$res_pub=$conn->query($sql_pub);
					//	$row_pub=$res_pub->rowCount(); 
						
					//if($row_pub > 0)
					//	{
					//		header("Location: http://hlobald.com/PL74K/raTK/o6Da/--yNId625B2skxN9sqehY30FzGF0NoDCR34VhC0U9s1zhvdUM4wF?qa0=Adult");
					//		exit;
					//	}
					

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
					
					$update_track="call ".$logdb.".update_campaign_and_insert_request
								('".$operator."','".$row_camp['run_camp_id']."','".$row_track['campaign_id']."','".$pubid."','".$date."','".$url."','".$clickid."','".$row_camp['campaign_id']."','".$advertiser_id."')"; 
				
					$update_res=$conn->query($update_track);
					$update_res=null;
					$clickid=null;
					 
					//echo "<script>window.location='".$url."';</script>";
					
					//$conn=null;
  
					header("Location: $url");
				}
				else{
					
				}
			
			
		}



		}
		else
		{
			header("Location: http://hlobald.com/PL74K/raTK/o6Da/--yNId625B2skxN9sqehY30FzGF0NoDCR34VhC0U9s1zhvdUM4wF?qa0=Adult");
				exit;
		}
	



?>