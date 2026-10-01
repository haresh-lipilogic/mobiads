<?php
//error_reporting(0);
include("includes/connection.php");

function update_running_campaign_tbl($logdb)
{	
$start_date = date('Y-m-d')." 00:00:00";
$end_date = date('Y-m-d')." 23:59:59";
//echo $logdb; exit;
include("includes/connection.php");
	$commondb="commondb";
	
	// badha campaign deactive karva mate. Je campaign nu activation count vadhi jase to e deactive thai jase.
		
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
							group by camp_id
					
					";    
		$res_count_act=$conn->query($sql_count_act) ;
		
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
		
		
	
  $sql="SELECT 
				camp_id,
				callback,
				(callback * campaign_price) price,
				operator
			FROM
				(SELECT 
					campaign_id camp_id,
						campaign_price,
						campaign_operator operator
				FROM
					".$logdb.".campaign_tbl
				WHERE
					campaign_live = 1
                    
				GROUP BY campaign_id
				ORDER BY camp_id) a
					LEFT JOIN
				(SELECT 
					COUNT(distinct clickid) callback, campaign_id
				FROM
					".$logdb.".advertiser_response_tbl
                    where ad_resp_datetime >= '".$start_date."'
                    and ad_resp_datetime <= '".$end_date."'
				GROUP BY campaign_id) b ON (a.camp_id = b.campaign_id)
			ORDER BY price DESC";     
	$res=$conn->query($sql); 

	$truncate="truncate table ".$logdb.".running_campaign_tbl"; 
	$res_truncate=$conn->query($truncate);
	
	$update_counter="update ".$logdb.".counter_tbl set counter_no=0  where counter_id=1 ";
	$res_counter=$conn->query($update_counter);
	
	$update_camp="update ".$logdb.".campaign_tracking_tbl set campaign_id=0 where camp_track_id=1 ";
	$res_camp=$conn->query($update_camp);
	
	$c=1;
	while($row=$res->fetch())
	{
	
		$update="insert into  ".$logdb.".running_campaign_tbl   (run_camp_id,campaign_id,run_camp_operator,run_camp_track)
		values ('".$c."','".$row['camp_id']."','".$row['operator']."','0')";
		$update_res=$conn->query($update);
		$c=$c+1;
	}
}

$pro='glamour';

	
	 
	$commondb= "commondb";

	$select_country="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  isactive=1 ;
	";
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res_country= $conn->query($select_country);
	$num=$res_country->rowCount();  
	//$country[]=array();
	while($row_country = $res_country->fetch())
	{
	
		$operator[]=array( $row_country['operator_id'] => $row_country['operator']);
	
	}

	foreach($operator as  $record)
	{
		foreach($record as $index => $value)
		{
			$operator= $value;
			
				if(strtolower($operator) == 'vodafone') 
						{
							
							$logdb="voda_".$pro."db_0617";	
						}
						elseif( strtolower($operator) == 'idea' || strtolower($operator) == 'airtel')
						{
							$logdb=$operator."_".$pro."db_0617";	
						}
						
						else
						{	
							$logdb=$operator."_".$pro."db";	
						}
					
			
			
			$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'"; 
			$res_db=$conn->query($db);
			
					
			
			$row_db=$res_db->rowCount();
			if($row_db > 0)
			{
				
			$db = update_running_campaign_tbl($logdb);
			}
			else
			{
				
			}
		
			
		}
	}

?>