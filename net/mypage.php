<?php 
include("includes/connection.php");

if(isset($_POST['submit']))
{
	$commondb="commondb";
	$operator=$_POST['operator'];
	$product=$_POST['product'];
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
<option value="glamour">glamour</option>
<option value="games">games</option>

</select>

Operator:
<select name="operator">
<option value="mtn">mtn</option>
<option value="vodafone">Vodafone</option>
<option value="airtel">Airtel</option>
<option value="idea">IDEA</option>
<option value="dtac">DTAC</option>
<option value="ais">AIS</option>
<option value="vodacom">vodacom</option>
<option value="du">du</option>
<option value="dialog">dialog</option>
<option value="truemove">truemove</option>
<option value="omanooredoo">omanooredoo</option>
<option value="celcom">celcom</option>
<option value="xl">xl</option>
<option value="indosat">indosat</option>
<option value="qatarvodafone">qatarvodafone</option>
<option value="argentinamovistar">argentinamovistar</option>
<option value="robi">robi</option>
<option value="telenor">myanmartelenor</option>
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