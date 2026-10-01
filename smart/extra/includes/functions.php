<?php

function get_operatorcode_country_dbname($operator)
{
	
	include("connection.php");
	include("language.php");
	
	$sql="select * from ".$commondb.".operator_tbl where operator = '".$operator."' limit 1";  // Find operator by IP Address
	$res=$conn->query($sql);
	$row=$res->fetch();
	$num= $res->rowCount(); 
	if($num == '0')
	{
		echo "IP does not match"; exit;
	}
	
	
	$operator_code=$row['operator_code'];
	$country=$row['country_id'];
	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_glamourdb";
	}
	else
	{
		$logdb=$operator."_glamourdb";
	}
	
	
	$operatordb['dbname']=$logdb;
	$operatordb['operatorcode']=$operator_code;
	$operatordb['country']=$country;
	
	return $operatordb;
	
}

function get_db($operatorid)
{
	include("connection.php");
	include("language.php");
	$sql_operator="select operator from ".$commondb.".ip_operator_tbl where operator_id='".$operatorid."' limit 1 ";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	 
	$operator['operator']=$row_operator['operator']; 
	
	return $operator;
}


function get_operator($operatorid)
{
	include("connection.php");
	include("language.php");
	$sql_operator="select operator from ".$commondb.".operator_tbl where operator_code='".$operatorid."' limit 1 ";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	 
	$operator['operator']=$row_operator['operator']; 
	
	return $operator;
}

function get_browser_os($useragent)
{
	// get Browser
	if(strpos($useragent,"opera") > -1)
	{
		$browser="opera";
	}
	elseif(strpos($useragent,"ucb") > -1 )
	{
		$browser="ucb";
	}
	elseif(strpos($useragent,"chrome") > -1 )
	{
		$browser="chrome";
	}
	else
	{
		$browser="other";
		
	}
	
	// get OS
	if(strpos($useragent,"android") > -1)
	{
		$os="android";
	}
	elseif(strpos($useragent,"iphone") > -1)
	{
		$os="iphone";
	}
	elseif(strpos($useragent,"windows") > -1)
	{
		$os="windows";
	}
	elseif(strpos($useragent,"linux") > -1)
	{
		$os="linux";
	}
	else
	{
		$os="other";
	}
	
	$browser_os['browser']=$browser;
	$browser_os['os']=$os;
	
	return $browser_os;
}

?>