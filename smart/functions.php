<?php

include("includes/connection.php");

error_reporting(0);



function get_operator($ip)
{
	$sql="select * from ".$commondb.".ip_operator_tbl where ip = '".$ip."' limit 1"; // Find operator by IP Address
	$res=$conn->query($sql);
	$row=$res->fetch();

	$operator=$row['operator'];
	if(strtolower($operator) == 'vodafone')
	{
		$dbname="voda";
	}
	elseif(strtolower($operator) == 'idea')
	{
		$dbname="idea";
	}
	else
	{
		$dbname="";
	}
	
	return $dbname;
}

?>