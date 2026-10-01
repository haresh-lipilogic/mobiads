<?php

include("includes/connection.php");

date_default_timezone_set("asia/kolkata");
error_reporting(0);
$date=date("Y-m-d"); 

$pubid=$_GET['p']."glpe";
$sql="select * from 
peruclaro_glamourdb.advertiser_response_tbl 
where date(ad_resp_datetime) = date('".$date."')
and pubid = '".$pubid."' and 
action = 'act' and
advertiser_response = 'stop' order by ad_resp_id desc limit 1;";
$res=$conn->query($sql);
$row=$res->fetch();

$id=$row['ad_resp_id']; 
$cburl=$row['advertiser_callbackurl'];
echo $a=file_get_contents($cburl);
//$a="a";

echo $update="update peruclaro_glamourdb.advertiser_response_tbl set advertiser_response = '".$a."' where ad_resp_id = '".$id."'"; 
$res1=$conn->query($update);
 



?>