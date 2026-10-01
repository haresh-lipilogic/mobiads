<?php
include("../includes/connection.php");

$operator=strtolower($_GET['operator']);
	$product=strtolower($_GET['product']);
$val=$_GET['val'];
$ad=$_GET['ad'];
$c=$_GET['c'];



	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_".$product."db";	
	}
	else
	{
		$logdb=$operator."_".$product."db";	
	}

if($product == 'Hotshots')
{
	
	if($operator == 'Vodafone')
	{
		if($ad == 'all')
		{
			
			if($c == 'check')
			{
				$sql="update hotshotsdb1.pub_approval set spillover = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb1.pub_approval set spillover = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb1.pub_approval set spillover = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb1.pub_approval set spillover = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		
	}
	else
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb_idea.pub_approval set spillover = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb_idea.pub_approval set spillover = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update hotshotsdb_idea.pub_approval set spillover = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update hotshotsdb_idea.pub_approval set spillover = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		
	}

}
else
{
	if($operator == 'Vodafone')
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update gamesdb_voda.pub_approval set spillover = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb_voda.pub_approval set spillover = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update gamesdb_voda.pub_approval set spillover = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb_voda.pub_approval set spillover = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
	}
	else
	{
		if($ad == 'all')
		{
			if($c == 'check')
			{
				$sql="update gamesdb.pub_approval set spillover = 1 where advertiserid = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb.pub_approval set spillover = 0 where advertiserid = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
		else
		{
			if($c == 'check')
			{
				$sql="update gamesdb.pub_approval set spillover = 1 where pub_approval_id = $val "; 
				$res=mysql_query($sql);		
			}
			else
			{
				$sql="update gamesdb.pub_approval set spillover = 0 where pub_approval_id = $val "; 
				$res=mysql_query($sql);
			}	
		
		}
	}	
}

?>