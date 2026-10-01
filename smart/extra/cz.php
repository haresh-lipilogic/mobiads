<?php

include("includes/connection.php");

date_default_timezone_set("asia/kolkata");
error_reporting(0);
$date=date("Y-m-d"); 
$pubid=$_GET['p'];
$pro=$_GET['pro'];

if($pro == 'gm')
{
	$db="fashionbardb_cz";
}
else
{
	$db="fashionbardb_czglam";
}

$sql="select * from 
".$db.".advertcallback 
where date(advertdatetime) = date('".$date."')
and pubid = '".$pubid."' and 
advertresponse = 'stop' order by advertcallbackid desc limit 1;";
$res=$conn->query($sql);
$row=$res->fetch();

$id=$row['advertcallbackid']; 
$cburl=$row['advertcallbackurl'];
echo $a=file_get_contents($cburl);
//$a="a";

echo $update="update ".$db.".advertcallback set advertresponse = '".$a."' where advertcallbackid = '".$id."'"; 
$res1=$conn->query($update);
 



?>