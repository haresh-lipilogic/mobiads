<?php

include("includes/connection.php");

error_reporting(0);

//error_reporting(0);

$ip=$_SERVER["REMOTE_ADDR"];   // Get IP Address
$useragent=$_SERVER['HTTP_USER_AGENT']; // Get Useragent
$commondb="commondb";
$logdb="logdb";

$sql="select * from ".$commondb.".ip_operator_tbl where ip = '".$ip."' limit 1"; // Find operator by IP Address
$res=$conn->query($sql);
$row=$res->fetch();




if(lcfirst($row['operator']) == 'vodafone'  ) // for Vodafone operator
{
		
		// counter value fetch karva
		$sql_counter="select * from ".$commondb.".counter_tbl limit 1";
		$res_counter=$conn->query($sql_counter);
		$row_counter=$res_counter->fetch();
	
		if($row_counter['counter_voda_no'] == '10')
		{
			// counter value counter_voda_no zero
			$update_counter="update ".$commondb.".counter_tbl set counter_voda_no=0 where counter_id='1'";
			$update_res=$conn->query($update_counter);
			
			
			$sql_counter="select * from ".$commondb.".counter_tbl limit 1";
			$res_counter=$conn->query($sql_counter);
			$row_counter=$res_counter->fetch();
			
			 $counter_voda_no=$row_counter['counter_voda_no']+1; 
			$update_counter="update ".$commondb.".counter_tbl set counter_voda_no='".$counter_voda_no."' where counter_id='1'";
			$update_res=$conn->query($update_counter);
			
			// badha run_camp_track nereset ( means 0 ) karva mate.. khali run_camp_track=10 update nai thay.
			$update_track="update ".$logdb.".voda_running_campaign_tbl set run_camp_track=0  where run_camp_operator='vodafone' and run_camp_track not in (8,9,10) ";
			$res_track=$conn->query($update_track);	
			
			
			// jya run_camp_track 10 hoy tya -1 update karva..
			$update_track1="update ".$logdb.".voda_running_campaign_tbl set run_camp_track=101  where run_camp_operator='vodafone' and run_camp_track in (8,9,10) ";
			$res_track1=$conn->query($update_track1);	
			
		}
		
		else
		{
			$counter_voda_no=$row_counter['counter_voda_no']+1; 
			$update_counter="update ".$commondb.".counter_tbl set counter_voda_no='".$counter_voda_no."' where counter_id='1'";
			$update_res=$conn->query($update_counter);			
		}
		
		
		if($counter_voda_no < 8)
		{
		
		
			$sql_camp="SELECT 
							voda_running_campaign_tbl.run_camp_id as run_camp_id,
							campaign_url,
							voda_running_campaign_tbl.campaign_id
						FROM
							".$logdb.".voda_campaign_tbl
								INNER JOIN
							".$logdb.".voda_running_campaign_tbl ON voda_campaign_tbl.campaign_id = voda_running_campaign_tbl.campaign_id
						WHERE
							voda_campaign_tbl.campaign_operator = 'vodafone'
						ORDER BY  voda_running_campaign_tbl.run_camp_id 
						LIMIT 1"; // Fetch First Campaign of Operator Vodafone
			$res_camp=$conn->query($sql_camp) or die(print_r($conn->error));
			$row_camp=$res_camp->fetch();	
			$res_camp = null;
			//echo $row_camp['run_camp_id']; exit;	
			
			$sql_track="select * from ".$commondb.".campaign_tracking_tbl limit 1;"; 
			$res_track=$conn->query($sql_track) or die(print_r($conn->error));
			$row_track=$res_track->fetch();	
			$res_track = null;
			$row_track['vodafone_camp_id']; 
			
			
			
			if($counter_voda_no % 2 != 0)
			{
				
				$sql_last="select * from ".$logdb.".voda_running_campaign_tbl where run_camp_operator= 'vodafone' order by run_camp_id asc limit 1";
				$res_last=$conn->query($sql_last);
				$row_last=$res_last->fetch();
				$update_last="update ".$logdb.".voda_running_campaign_tbl set run_camp_track='".$counter_voda_no."' where run_camp_operator='vodafone' 
				and run_camp_id='".$row_last['run_camp_id']."'";
				$update_res_last=$conn->query($update_last);
				
				
			}
			else
			{
				
				$no=$counter_voda_no -1 ;
				$sql_last="select * from ".$logdb.".voda_running_campaign_tbl where run_camp_operator= 'vodafone' 
					and  run_camp_track < '".$no."' order by run_camp_id asc limit 1"; 
				$res_last=$conn->query($sql_last);
				$row_last=$res_last->fetch();
				$update_last="update ".$logdb.".voda_running_campaign_tbl set run_camp_track='".$counter_voda_no."' where run_camp_operator='vodafone' 
				and run_camp_id='".$row_last['run_camp_id']."'";
				$update_res_last=$conn->query($update_last);
				
			}
			
			
			
			if($row_track['vodafone_camp_id'] == '0') // If campaign_id is zero then Update with first Campaign_ID of Vodafone
			{
			
				$click_id=rand(111111111,999999999).rand(111111111,999999999).rand(111111111,999999999); ;// Get Click Id

				$url=$row_camp['campaign_url']."?clickid=".$click_id; // Concatenation with URL and Click_id

				date_default_timezone_set("Asia/Kolkata");
				$date=date("Y-m-d H:i:s"); // Current date and time
				
				$update_track="call ".$logdb.".update_campaign_and_insert_request('vodafone','".$row_camp['run_camp_id']."','".$row_track['vodafone_camp_id']."','".$date."','".$url."','".$click_id."','".$row_camp['campaign_id']."')"; 	
			
				$update_res=$conn->query($update_track);
				$update_res=null;
				$click_id=null;

			}
			else
			{	
				//$sql_camp="call ip_operator.fetch_campaign_id('vodafone','".$row_track['vodafone_camp_id']."')"; 
				$sql_camp="SELECT 
								voda_running_campaign_tbl.run_camp_id,
								campaign_url,
								voda_running_campaign_tbl.campaign_id
							FROM
								".$logdb.".voda_campaign_tbl
									INNER JOIN
								".$logdb.".voda_running_campaign_tbl ON voda_campaign_tbl.campaign_id = voda_running_campaign_tbl.campaign_id
							WHERE
								voda_campaign_tbl.campaign_operator = 'vodafone'
								AND run_camp_track = '".$counter_voda_no."'
							ORDER BY  voda_running_campaign_tbl.run_camp_id 
							LIMIT 1;
					"; 
				$res_camp=$conn->query($sql_camp);
				$row_camp=$res_camp->fetch();	
				
				$res_camp=null;
				
				
				
				$click_id=rand(111111111,999999999).rand(111111111,999999999).rand(111111111,999999999); // Get Click Id

				$url=$row_camp['campaign_url']."?clickid=".$click_id; // Concatenation with URL and Click_id

				date_default_timezone_set("Asia/Kolkata");
				$date=date("Y-m-d H:i:s"); // Current date and time
				
				$update_track="call ".$logdb.".update_campaign_and_insert_request('vodafone','".$row_camp['run_camp_id']."','".$row_track['vodafone_camp_id']."','".$date."','".$url."','".$click_id."','".$row_camp['campaign_id']."')"; 
				$update_res=$conn->query($update_track);
				$update_res=null;	
				$click_id=null;
			
			
		}
		
			
		}
		else
		{
			
				
			
				$sql_last="select * from ".$logdb.".voda_running_campaign_tbl where run_camp_operator= 'vodafone' and run_camp_track=0 order by run_camp_id  asc limit 1;"; 
				$res_last=$conn->query($sql_last);
				$row_last=$res_last->fetch();
				$res_last=null;
		
				if($row_last['run_camp_id'] == '')
				{
					 
					$select_last_track="select max(run_camp_track) as a from ".$logdb.".voda_running_campaign_tbl where run_camp_operator='vodafone' 
					and run_camp_track!=0";
					$res_last_track=$conn->query($select_last_track);
					$row_last_track=$res_last_track->fetch();
					$res_last_track=null;
					
					$update_101="update ".$logdb.".voda_running_campaign_tbl set run_camp_track=0 where run_camp_operator='vodafone' 
					and run_camp_track=101 or run_camp_track='".$row_last_track['a']."'";
					$res_101=$conn->query($update_101);
					
					
					$sql_last="select * from ".$logdb.".voda_running_campaign_tbl where run_camp_operator= 'vodafone' and run_camp_track=0 order by run_camp_id  asc limit 1"; 
					$res_last=$conn->query($sql_last);
					$row_last=$res_last->fetch();
					//$res_last=null;
					
					$update_last="update ".$logdb.".voda_running_campaign_tbl set run_camp_track='".$counter_voda_no."' where run_camp_operator='vodafone' 
					and run_camp_id='".$row_last['run_camp_id']."'";
					$update_res_last=$conn->query($update_last);
					
				}
				else
				{	
				
					$update_last="update ".$logdb.".voda_running_campaign_tbl set run_camp_track='".$counter_voda_no."' where run_camp_operator='vodafone' 
					and run_camp_id='".$row_last['run_camp_id']."'";
					$update_res_last=$conn->query($update_last);
				
				}
				
				
				$sql_camp="SELECT 
								voda_running_campaign_tbl.run_camp_id,
								campaign_url,
								voda_running_campaign_tbl.campaign_id
							FROM
								".$logdb.".voda_campaign_tbl
									INNER JOIN
								".$logdb.".voda_running_campaign_tbl ON voda_campaign_tbl.campaign_id = voda_running_campaign_tbl.campaign_id
							WHERE
								voda_campaign_tbl.campaign_operator = 'vodafone'
								AND run_camp_track = '".$counter_voda_no."'
							ORDER BY  voda_running_campaign_tbl.run_camp_id 
							LIMIT 1;
					"; 
				$res_camp=$conn->query($sql_camp);
				$row_camp=$res_camp->fetch();	
				
				$res_camp=null;
				
				$sql_track="select * from ".$commondb.".campaign_tracking_tbl limit 1;"; 
				$res_track=$conn->query($sql_track) or die(print_r($conn->error));
				$row_track=$res_track->fetch();	
				$res_track = null;
				
				$click_id=rand(111111111,999999999).rand(111111111,999999999).rand(111111111,999999999); // Get Click Id

				$url=$row_camp['campaign_url']."?clickid=".$click_id; // Concatenation with URL and Click_id

				date_default_timezone_set("Asia/Kolkata");
				$date=date("Y-m-d H:i:s"); // Current date and time
				
				$update_track="call ".$logdb.".update_campaign_and_insert_request('vodafone','".$row_camp['run_camp_id']."','".$row_track['vodafone_camp_id']."','".$date."','".$url."','".$click_id."','".$row_camp['campaign_id']."')"; 
				$update_res=$conn->query($update_track);
				$update_res=null;
				$click_id=null;
				
			}
			
		

		
	//	echo "<script>window.location='".$url."';</script>";
	

	
}
else
{
	

}





?>