<?php

include("includes/connection.php");

date_default_timezone_set("asia/kolkata");
error_reporting(0);
//$date=date("Y-m-d"); 
$date=$_GET['dt']; 
if($date == '')
{
	$date=date('Y-m-d');
}
$pubid=$_GET['p'];
$op=$_GET['op'];

$sql="select * from 
fashionbardb_sagamepub.advertcallback 
where date(advertdatetime) = date('".$date."')
and pubid = '".$pubid."' 
and operator = '".$op."'
and advertresponse = 'stop' order by advertcallbackid desc limit 1;";
$res=$conn->query($sql);
$row=$res->fetch();

$id=$row['advertcallbackid']; 
$cburl=$row['advertcallbackurl'];
echo $a=file_get_contents($cburl);
//$a="a";

echo $update="update fashionbardb_sagamepub.advertcallback set advertresponse = '".$a."' where advertcallbackid = '".$id."'"; 
$res1=$conn->query($update);
 



?>