<?php 
include("includes/connection.php");

if(isset($_POST['submit']))
{
	$commondb="commondbthailand"; 
	
	$product=$_POST['product'];
	$operator=$_POST['operator'];
	if($_POST['capping'] == 0)
	{
		$capping=100;
	}
	else
	{
		$capping=$_POST['capping'];
	}
	
	$isactive=$_POST['isactive'];
	
	
	
$tbl=$operator."_".$product."_counter_tbl"; 
		
	

	$select="select * from ".$commondb.".".$tbl."";  
	$res=$conn->query($select);
	$num=$res->rowCount(); 
	if($num > 0)
	{
		$update="update ".$commondb.".".$tbl." set isactive = '".$isactive."',capping='".$capping."' where cntid = 1 ";
		$res=$conn->query($update);
	}
	else
	{}
	
	

	
}

?>
<form method = "post">
product:
<select name="product">
<option value="svmobi">svmobi</option>
<option value="newsvmobi">newsvmobi</option>
<option value="hungama">hungama</option>
<option value="saregama">saregama</option>
<option value="adsmedia">adsmedia</option>
<option value="mobilart">mobilart</option>
<option value="newadsmedia">newadsmedia</option>
<option value="rgk">rgk</option>
<option value="jmvas">jmvas</option>
<option value="xillaxmob">xillaxmob</option>
<option value="glamxillaxmob">glamxillaxmob</option>
<option value="nereidi">nereidi</option>
<option value="ekenaide">ekenaide</option>
<option value="wapleads">wapleads</option>
<option value="shemaroo">shemaroo</option>
<option value="paytm">paytm</option>
<option value="shotformat">shotformat</option>


</select>



operator:
<select name="operator">
<option value="dtac">dtac</option>
<option value="ais">ais</option>
<option value="truemove">truemove</option>


</select>

<br/>
<br/>
Capping:
<input type="text" name="capping" >

<br/>
<br/>

Blocking:
<select name="isactive">
<option value="0">Block</option>
<option value="1">Unblock</option>
</select>
<br/>
<br/>
<input type="submit" name="submit" value="submit">
</form>