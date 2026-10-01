<?php
include("includes/connection.php");

$product=array('glamour','music','games');

$start_date1=date('Y-m-d');
$end_date1=date('Y-m-d');

$start_date = date('Y-m-d', strtotime($start_date1 . ' -1 day'))." 00:00:00";
$end_date = date('Y-m-d', strtotime($end_date1 . ' -1 day'))." 23:59:59";
//$start_date = "2017-05-11 00:00:00";
//$end_date = "2017-05-10 23:59:59";

foreach($product as $p)
{

if($p == 'glamour')
{
	$operator=array('vodafone','airtel','idea','kuwaitooredoo','omanooredoo','ais','dtac'); 
}
elseif($p == 'games')
{
	$operator=array('vodafone','idea');
}
else
{
		$operator=array('kuwaitooredoo','omanooredoo');
}


foreach($operator as $o)
{
	if($o == 'vodafone')
	{
		$o='voda';
		$db=$o."_".$p."db_0617";
	}
	elseif($o == 'airtel' || $o == 'idea')
	{
		$db=$o."_".$p."db_0617";
	}
	else
	{
		$db=$o."_".$p."db";
	}
	$commondb="commondb";
	
	$sql = "SELECT 
    dt1 dt,
    CASE
        WHEN advertiser_name IS NULL THEN 'OTHER'
        ELSE advertiser_name
    END title,
    CASE
		WHEN ad_id is null then '0'
        ELSE ad_id
	END camp_id,
    SUM(clicks) clicks,
    SUM(act) act,
    SUM(dct) dct,
    
    SUM(cbr) cbr
FROM
    (SELECT 
        COUNT(userlog_tbl.clickid) clicks,
            0 act,
            0 dct,
            0 cbr,
            DATE(userlog_datetime) dt1,
            advertiser_tbl.advertiser_id ad_id,
            advertiser_name
    FROM
        ".$db.".userlog_tbl
    LEFT JOIN ".$db.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
    LEFT JOIN ".$commondb.".advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
    WHERE
        userlog_datetime >= '".$start_date."'
            AND userlog_datetime <= '".$end_date."'
    GROUP BY dt1 , advertiser_name UNION SELECT 
        0 clicks,
            COUNT(DISTINCT act_tbl1.clickid) act,
            COUNT(DISTINCT dct_tbl1.clickid) dct,
            0 cbr,
            act_tbl1.dt dt,
            act_tbl1.ad_id,
            act_tbl1.advertiser_name
    FROM
        (SELECT DISTINCT
        clickid, DATE(ad_resp_datetime) dt, advertiser_name, advertiser_tbl.advertiser_id ad_id
    FROM
        ".$db.".advertiser_response_tbl
    LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
    WHERE
        ad_resp_datetime >= '".$start_date."'
            AND ad_resp_datetime <= '".$end_date."'
            AND action = 'act'
    GROUP BY clickid) act_tbl1
    LEFT JOIN (SELECT DISTINCT
        clickid, DATE(ad_resp_datetime) dt, advertiser_name, advertiser_tbl.advertiser_id ad_id
    FROM
        ".$db.".advertiser_response_tbl
    LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
    WHERE
        ad_resp_datetime >= '".$start_date."'
            AND ad_resp_datetime <= '".$end_date."'
            AND action = 'dct'
    GROUP BY clickid) dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
        AND act_tbl1.dt = dct_tbl1.dt
        AND act_tbl1.advertiser_name = dct_tbl1.advertiser_name
    GROUP BY act_tbl1.dt , act_tbl1.advertiser_name UNION SELECT 
        0 clicks,
            0 act,
            0 dct,
            COUNT(clickid) cbr,
            dt,
            ad_id,
            advertiser_name
    FROM
        (SELECT DISTINCT
        0 clicks,
            0 act,
            0 dct,
            clickid,
            DATE(ad_resp_datetime) dt,
            advertiser_tbl.advertiser_id ad_id,
            advertiser_name
    FROM
        ".$db.".advertiser_response_tbl
    LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
    WHERE
        ad_resp_datetime >= '".$start_date."'
            AND ad_resp_datetime <= '".$end_date."'
            AND advertiser_response != 'stop'
            AND action = 'act'
    GROUP BY clickid) bb
    GROUP BY dt , advertiser_name) a
GROUP BY dt , title;"; 
			
		$res=$conn->query($sql);
		while($row=$res->fetch())
		{
			$insert="insert into ".$db.".report (`dt`,`title`,`camp_id`,`clicks`,`act`,`dct`,`cbr`,`pubad`)
			values ('".$row['dt']."','".$row['title']."','".$row['camp_id']."','".$row['clicks']."','".$row['act']."','".$row['dct']."','".$row['cbr']."','2')";
			$res_insert=$conn->query($insert);
		}
}
 
}

?>
