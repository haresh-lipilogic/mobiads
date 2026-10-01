<?php

exit;
date_default_timezone_set("asia/kolkata");
$date=date("H:i:s"); 

$min=date("i");


	
		include("includes/connection.php");
		include("includes/functions.php");
		include("includes/language.php"); //aa file ma variable 6 jema  database name  6.. je badhe access thase
		error_reporting(0);
		$referrer=$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // advertiser referrer url
		if($_GET['ad_id'] =='')
		{
			$advertiser_id=$_GET['adid'];  // advertiser id
		}
		else{
			$advertiser_id=$_GET['ad_id'];  // advertiser id
		}
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
				/*$tbl="vodafone_glamour_counter_tbl";
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				
				$isactive=$rowmycount['isactive'];
		
			//if(($pubid != '10065' && $advertiser_id == '2025' )  ||  ($pubid != '81' && $advertiser_id == '18485' )   )
				if(( substr($pubid,0,2) == '41' && $advertiser_id == '2025' )  ||  ($pubid == '2' && $advertiser_id == '18485' )   )
			//if($advertiser_id == '21446' )
		//	if(($advertiser_id == '21446' || $advertiser_id == '2025' || $advertiser_id == '17406' ) && $pubid !='10065'  && $pubid !='81'   && $pubid !='81glvf' )
		//if($advertiser_id == '2025'  && $pubid !='10065'   && $pubid !='81'  )
		
		
				{
					
					
				if($cnt > $rowmycount['capping'] && $isactive == 1)
					{
						
						$cnt=$cnt+1;
							
							if($cnt == 101)
							{
								$cnt = 1;
							}
							$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
							$resupdatemycount=$conn->query($updatemycount);
							$clickid=$_GET['clickid']; 
							$pubid=$_GET['pubid'];
							$advertiser_id=$_GET['ad_id']; 
					
							$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid.""; 
							
							header("Location: ".$url.""); 
							exit;
						
					}
					else
					{
						
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);
						$logdb="voda_glamourdb";
					}
				}
				else
				{
					$logdb="voda_glamourdb";
				} */
				
				$logdb="voda_glamourdb";
					
			}
			elseif( $opid == '2' || $opid == 2)
			{
				
				/*
				$tbl="idea_glamour_counter_tbl";
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				$isactive=$rowmycount['isactive'];
				
		
			if($pubid == '124126' || $pubid == '82704' || $pubid == '121177' ||  strtolower($pubid) == 'a269934s19315' )
			{
				if($cnt > $rowmycount['capping'] && $isactive == 1)
					{
						$cnt=$cnt+1;
							
							if($cnt == 101)
							{
								$cnt = 1;
							}
							$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
							$resupdatemycount=$conn->query($updatemycount);
							$clickid=$_GET['clickid']; 
							$pubid=$_GET['pubid'];
							$advertiser_id=$_GET['ad_id']; 
					
							$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid.""; 
							header("Location: ".$url.""); 
							exit;
						
					}
					else
					{
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);
						$logdb=$operator."_glamourdb_0218_12";
					}
			}
			else
			{
				$logdb=$operator."_glamourdb_0218_12";
			}*/
			
				$logdb=$operator."_glamourdb_0218_12";	
				
			}
			
			elseif( $opid == '42' || $opid == 42)
			{
				
				
			
					$logdb=$operator."_glamourdb";
				
			}
			elseif($opid == 3 || $opid == '3')
			{
				
							$logdb=$operator."_glamourdb_0318";
						
			}
			elseif($opid == 12 || $opid == '12')
			{
					
				$tbl="dtac_glamour_counter_tbl";
						
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				$isactive=$rowmycount['isactive'];
				
				
		if($advertiser_id == '279' || $advertiser_id == '350'  )
		//if($pubid != '1' )
		
		{ 
				if($cnt > $rowmycount['capping'] && $isactive == 1)
					{
						$cnt=$cnt+1;
							
							if($cnt == 101)
							{
								$cnt = 1;
							}
							$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
							$resupdatemycount=$conn->query($updatemycount);
							$clickid=$_GET['clickid']; 
							$pubid=$_GET['pubid'];
							$advertiser_id=$_GET['ad_id']; 
					
							$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid.""; 
							header("Location: ".$url.""); 
							exit;
						
					}
					else
					{
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);
						
						
						$logdb=$operator."_glamourdb";
						
						
					}
				
				}
				else{
					$logdb=$operator."_glamourdb";
				}
					
				
			}
			
			elseif($opid == 11 || $opid == '11')
			{
				
				$tbl="ais_glamour_counter_tbl"; 
				
				
				
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				$isactive=$rowmycount['isactive'];
				
				//if(  $pubid != '97' &&  $pubid != '1383_'  && $pubid != '230'  && $pubid != '1110001' )
				if(  $advertiser_id == '30929' ||  $advertiser_id == '25107' ||  $advertiser_id == '31262'   ||  $advertiser_id == '31607'  ||  $advertiser_id == '30354'  ||  $advertiser_id == '17159' ||  $advertiser_id == '31721'  )
				{
				if($cnt > $rowmycount['capping'] && $isactive == 1)
					{
						$cnt=$cnt+1;
							
							if($cnt == 101)
							{
								$cnt = 1;
							}
							$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
							$resupdatemycount=$conn->query($updatemycount);
							$clickid=$_GET['clickid']; 
							$pubid=$_GET['pubid'];
							$advertiser_id=$_GET['ad_id']; 
					
							$url = "http://mobiads.me/smart/testurl1.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid."&cmpid=22";  
							
							header("Location: ".$url.""); 
							exit;
						
					}
					else
					{
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);					
						$logdb=$operator."_glamourdb_0118";										
					}
				}
				else
				{
						$logdb=$operator."_glamourdb_0118";
				} 
				
				
				
			}
			
			
			elseif($opid=='136' || $opid==136  )
			{
				
				$tbl="peruclaro_glamour_counter_tbl";
				
				
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				$isactive=$rowmycount['isactive'];
				
				if( $pubid != '97'	 )
				{
					if($cnt > $rowmycount['capping'] && $isactive == 1)
						{
							$cnt=$cnt+1;
								
								if($cnt == 101)
								{
									$cnt = 1;
								}
								$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
								$resupdatemycount=$conn->query($updatemycount);
								$clickid=$_GET['clickid']; 
								$pubid=$_GET['pubid'];
								$advertiser_id=$_GET['ad_id']; 
						
								$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=136"; 
								//$conn=null;
  
								header("Location: ".$url.""); 
								exit;
							
						}
						else
						{
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);
						$logdb=$operator."_glamourdb";
					}
				}
				else{
					$logdb=$operator."_glamourdb";
				}
				
				//$logdb=$operator."_glamourdb";
			}
			
			elseif($opid == '14' || $opid == 14)
			{
				
					$logdb=$operator."_glamourdb";
					
			}
			elseif($opid=='24' || $opid==24   )
			{
				
						$logdb=$operator."_glamourdb";
					
			}
			
			elseif($opid=='92' || $opid==92  )
			{
		
				$logdb=$operator."_glamourdb";
				
			}
			
			
				elseif( $opid=='82' || $opid==82 )
			{
				
					$tbl="zain_glamour_counter_tbl";
				
				
				$sqlmycount="select * from commondb.".$tbl." "; 
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt']; 
				$isactive=$rowmycount['isactive'];
			
				
				
				if( $pubid =='211' ||  $pubid == '273' || $pubid =='1184_' || $pubid =='13' || $pubid == '88_sf198' || substr($pubid,0,3) == '88_'   )	
				//if( $pubid !='1383_')	
				{
					
					if($cnt > $rowmycount['capping'] && $isactive == '1')
						{
							
							
							$cnt=$cnt+1;
								
								if($cnt == 101)
								{
									$cnt = 1;
								}
								$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
								$resupdatemycount=$conn->query($updatemycount);
								$clickid=$_GET['clickid']; 
								$pubid=$_GET['pubid'];
								$advertiser_id=$_GET['ad_id']; 
						
								$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid.""; 
								$conn=null;
	  
								header("Location: ".$url.""); 
								exit;
							
						}
						else
						{
							$cnt=$cnt+1;
							if($cnt == 101)
							{
									$cnt = 1;
							}
					
							$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
							$resupdatemycount=$conn->query($updatemycount);
							$logdb=$operator."_glamourdb";
						}
					
					}
					else{
						$logdb=$operator."_glamourdb";
					}
					
				
			}
			
			
			elseif($opid=='26' || $opid==26 )
			{
				
							
					$logdb=$operator."_glamourdb";
				
			}
			
			elseif($opid=='27' || $opid==27  )
			{
				
					$tbl="cellc_glamour_counter_tbl";
				
				
				$sqlmycount="select * from commondb.".$tbl." ";
				$resmycount=$conn->query($sqlmycount);
				$rowmycount=$resmycount->fetch();
				$cnt=$rowmycount['cnt'];
				
				$isactive=$rowmycount['isactive'];
				//if($pubid == '8283' || $pubid == '1411' || $pubid == '30590' || $pubid == '4556' || $pubid == '6414' || $pubid == '7156' || $pubid == '86621' || $pubid == '88714')
				//if(($pubid != '43' && $pubid != '510' && $pubid != '87405_Unknown' && $pubid != '1246') && $advertiser_id != '16410' && $advertiser_id != '17207' )
					
				if($advertiser_id ==  '19713' || ($advertiser_id == '13420' && $pubid != '69') || $advertiser_id == '29989' || $advertiser_id == '28827' || $advertiser_id == '17484' || $advertiser_id == '30090' || $advertiser_id == '19934'	) 
				//if( $advertiser_id == '19934' )
				{
					if($cnt > $rowmycount['capping'] && $isactive == 1)
						{
							$cnt=$cnt+1;
								
								if($cnt == 101)
								{
									$cnt = 1;
								}
								$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
								$resupdatemycount=$conn->query($updatemycount);
								$clickid=$_GET['clickid']; 
								$pubid=$_GET['pubid'];
								$advertiser_id=$_GET['ad_id']; 
						
								$url = "http://mobiads.me/smart/my.php?clickid=".$clickid."&pubid=".$pubid."&ad_id=".$advertiser_id."&opid=".$opid.""; 
								//$conn=null;
  
								header("Location: ".$url.""); 
								exit;
							
						}
						else
						{
						$cnt=$cnt+1;
						if($cnt == 101)
						{
								$cnt = 1;
						}
				
						$updatemycount="update commondb.".$tbl." set cnt='".$cnt."' where cntid = '1'";
						$resupdatemycount=$conn->query($updatemycount);
						$logdb=$operator."_glamourdb";
					}
				}
				else{
					$logdb=$operator."_glamourdb";
				}
			}
			
			
			elseif($opid=='33' || $opid==33  )
			{	
				$logdb=$operator."_glamourdb";
	
			}
			
			elseif( $opid=='53' || $opid==53 )
			{
				
						$logdb=$operator."_glamourdb";

			}
			
			elseif($opid=='7' || $opid==7)
			{
				
				$logdb=$operator."_glamourdb";
				
			}
			else
			{
				$logdb=$operator."_glamourdb";
			}


		}
		
		else{
			
			header("Location: http://bit.ly/28SN1Lw");
				exit;

		}
		
			
		if($opid == '11' || $opid == '27' )
		{ 
					
			
				if($opid=='11')
				{
					
					$pubid=rand(9,13)."_".date("H")."_".$advertiser_id;

				}
				else{
						
					// Declare an associative array 
					$arr = array( "a"=>"15", "b"=>"74", "c"=>"25", "d"=>"14", "e"=>"65", "f"=>"63", "g"=>"49", "h"=>"56", "i"=>"5", "j"=>"88" ); 
					  
					// Use shiffle function to randomly assign numeric 
					// key to all elements of array. 
					shuffle($arr); 
					
					
						//$pubid="11_".date('h')."".date('d')."".date('m');
					$pubid=$arr[0];
				
						
				}
				
			
		}
		else
		{
			$pubid=$pubid;
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
					
					//if($num_camp == '' || $num_camp == 0 || $num_camp == '0')
					//{
					//	header("Location: http://bit.ly/28SN1Lw");
					//	break;
					//}
					$res_camp = null;
					
					//echo $row_camp['run_camp_id']; exit;	
										

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
								
									//echo "<script>window.location='".$url."';</script>";
									
								header("Location: $url");
												
?>