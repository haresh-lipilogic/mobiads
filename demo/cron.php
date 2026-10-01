<?php
include("includes/connection.php");
include("includes/language_cpi.php");

$commondb="commondb";
$product=array('glamour','music','games');

 $select_country="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  isactive=1 ;
	";
	
	
	$res_country= $conn->query($select_country);
	$num=$res_country->rowCount();  
	//$country[]=array();
	while($row_country = $res_country->fetch())
	{
		$country[]=array( "country" => $row_country['country_name']);
		$operator1[]=array( $row_country['operator_id'] => $row_country['operator']);
		
	}
	


$start_date1=date('Y-m-d');
$end_date1=date('Y-m-d');

$start_date = date('Y-m-d', strtotime($start_date1 . ' -1 day'))." 00:00:00";
$end_date = date('Y-m-d', strtotime($end_date1 . ' -1 day'))." 23:59:59";
//$start_date = "2017-05-11 00:00:00";
//$end_date = "2017-05-10 23:59:59";

foreach($product as $pro)
{
foreach($operator1 as  $record)
	{	
		foreach($record as $index2 => $value)
		{
				$operator1= $value;
				$operator_id1 = $index2; 

					if(strtolower($operator1) == 'vodafone') 
					{
						
						$logdb="voda_".$pro."db_cpi";	
					}
					
					else
					{	
						$logdb=$operator1."_".$pro."db_cpi";	
					}
					
				
	
			$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'";
			$res_db=$conn->query($db);
			$row_db=$res_db->rowCount();
			
			$sql = "SELECT 
				dt1 dt,
				CASE
					WHEN campaign_title IS NULL THEN 'OTHER'
					ELSE campaign_title
				END title,
				CASE 
					WHEN camp_id is null then '0'
					else camp_id
				END camp_id,
				SUM(clicks) clicks,
				
				SUM(act) act,
				SUM(dct) dct,
				
				SUM(cbr) cbr
			FROM
				(SELECT 
					COUNT(DISTINCT userlog_tbl.clickid) clicks,
						0 act,
						0 dct,
						0 cbr,
						DATE(userlog_datetime) dt1,
						campaign_tbl.campaign_id camp_id,
						campaign_title
				FROM
					".$logdb.".userlog_tbl
				LEFT JOIN ".$logdb.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
				WHERE
					userlog_datetime >= '".$start_date."'
						AND userlog_datetime <= '".$end_date."'
				GROUP BY dt1 , campaign_title UNION SELECT 
					0 clicks,
						COUNT(act_tbl1.clickid) act,
						COUNT(dct_tbl1.clickid) dct,
						0 cbr,
						act_tbl1.dt dt,
						act_tbl1.camp_id,
						act_tbl1.campaign_title
				FROM
					(SELECT DISTINCT
					clickid, DATE(camp_resp_datetime) dt, campaign_title, campaign_tbl.campaign_id camp_id
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						AND camp_action = 'act') act_tbl1
				LEFT JOIN (SELECT DISTINCT
					clickid, DATE(camp_resp_datetime) dt, campaign_title, campaign_tbl.campaign_id camp_id
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						AND camp_action = 'dct') dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.campaign_title = dct_tbl1.campaign_title
				GROUP BY act_tbl1.dt , act_tbl1.campaign_title UNION SELECT 
					0 click,
						0 act,
						0 dct,
						COUNT(clickid) cbr,
						dt,
						camp_id,
						campaign_title
				FROM
					(SELECT DISTINCT
					0 click,
						0 act,
						0 dct,
						clickid,
						DATE(camp_resp_datetime) dt,
						campaign_tbl.campaign_id camp_id,
						campaign_title
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						AND camp_action = 'act'
				GROUP BY clickid) bb
				GROUP BY dt , campaign_title) a
			GROUP BY dt1 , campaign_title"; 
			
		$res=$conn->query($sql);
		if($res)
			{
				echo $logdb;
			}
			else
			{ }
		while($row=$res->fetch())
		{
			$insert="insert into ".$logdb.".report (`dt`,`title`,`camp_id`,`clicks`,`act`,`dct`,`cbr`,`pubad`)
			values ('".$row['dt']."','".$row['title']."','".$row['camp_id']."','".$row['clicks']."','".$row['act']."','".$row['dct']."','".$row['cbr']."','1')"; 
			$res_insert=$conn->query($insert);
			if($res_insert)
			{
				echo $logdb;
			}
			else
			{ }
		}

		}
	}
}
?>
