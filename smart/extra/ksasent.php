<?php

include("includes/connection.php");

date_default_timezone_set("asia/kolkata");
error_reporting(0);
$date=date("Y-m-d"); 
$pubid=$_GET['p'];
if($pubid == 'daily')
{
	$db="fashionbardb_timwezain";
}
else
{
	$db="fashionbardb_saweekly";
}
$sql="SELECT * FROM ".$db.".advertcallback where advertresponse = '' and advertiserid=7  order by advertcallbackid desc limit 5;";
$res=$conn->query($sql);
$row=$res->fetch();

$id=$row['advertcallbackid']; 
$cburl=$row['advertcallbackurl'];
echo $a=file_get_contents($cburl);
//$a="a";

echo $update="update ".$db.".advertcallback set advertresponse = '".$a."' where advertcallbackid = '".$id."'"; 
$res1=$conn->query($update);
 



?>