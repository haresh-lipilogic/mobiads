<?php

include("includes/connection.php");
include("includes/language_cpi.php");

 echo $sql="SELECT 
        clickid,
         
            
            0 cbr,
            act_tbl1.dt dt,
            act_tbl1.campaign_title
    FROM
        (SELECT DISTINCT
        clickid, DATE(ad_resp_datetime) dt, campaign_title
    FROM
        idea_glamourdb_0617.advertiser_response_tbl
    LEFT JOIN idea_glamourdb_0617.campaign_tbl ON campaign_tbl.campaign_id = advertiser_response_tbl.campaign_id
    WHERE
        ad_resp_datetime >= '2017-06-20 00:00:00'
            AND ad_resp_datetime <= '2017-06-20 23:59:59'
            AND action = 'act' and clickid != 0) act_tbl1 where campaign_title is null

    ";  exit;
$res=$conn->query($sql);

while($row=$res->fetch())
{
	$sql_id="select * from idea_glamourdb_0617.campaign_request_tbl where clickid like '%".$row['clickid']."%'"; 
	$res_id=$conn->query($sql_id);
	$row_id=$res_id->fetch();
	
	$update_ad="update idea_glamourdb_0617.advertiser_response_tbl set clickid = '".$row_id['clickid']."', advertiser_id='".$row_id['advertiser_id']."', campaign_id = '".$row_id['campaign_id']."' where clickid = '".$row['clickid']."' "; 
	$res_ad=$conn->query($update_ad);
	
	$update_camp="update idea_glamourdb_0617.campaign_response_tbl set clickid = '".$row_id['clickid']."', advertiser_id='".$row_id['advertiser_id']."', campaign_id = '".$row_id['campaign_id']."' where clickid = '".$row['clickid']."' "; 
	$res_camp=$conn->query($update_camp);
	
	
	
}



?>