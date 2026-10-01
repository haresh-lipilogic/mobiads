<?php
$servername="localhost";
$username="root";
$password="";
$mydb="jioadsco_jioads";
date_default_timezone_set('Asia/Calcutta');
$conn=new MySQLi($servername,$username,$password,$mydb);
if($conn->connect_error)
{
	die("connection failed".$conn->connect_errno.$conn->connect_error);
}
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$name1=$_POST["name-1"];
	$full_name=$name1." ".$_POST["name-2"];
	$Company_name=$_POST["company"];
	$companyurl=$_POST["companyurl"];
	$email=$_POST["email"];
	$mobile=$_POST["mobile"];
	$city=$_POST["city"];
	$country=$_POST["country"];
	$message=$_POST["message"];
	$date=date("Y-m-d H:i:s");
$sql = "INSERT INTO contact VALUES (NULL,'$full_name','$email','$mobile','$Company_name','$companyurl','$city','$country','$message','$date');";	

if ($conn->multi_query($sql) === TRUE)
 	{
    	//echo "New records created successfully<br>";
	} 
	else 
	{
    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	
	
	
}
header("location:contactus.html");