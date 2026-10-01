<?php
error_reporting(0);
include("includes/connection.php");

 $csv = array();
    $lines = file('ip_voda.csv', FILE_IGNORE_NEW_LINES);

    foreach ($lines as $key => $value)
    {
		//echo $key;
		//echo $value;
       $csv[$key] = str_getcsv($value); 
	   //print_r($csv[$key][1]);
	   
	   
    } 
//print_r($csv);

for($a=0;$a<=1;$a++)
{
	
		  $arr=$csv[$a];
		
		
		 $a1=explode('.',$arr['0']);  

		 $b1=explode('.',$arr['1']);  
		 
		// print_r($b1); exit;
		$c1=$arr['2']; 
		if(strtolower($c1) == 'vodafone' )
		{
			$operator_id='vf';
		}
		else
		{
			$operator_id='id';
		}
		
		
		for($i=$a1['0']; $i<=$b1['0']; $i++)
		{
			for($j=$a1['1']; $j<=$b1['1']; $j++)
			{	
				for($k=$a1['2']; $k<=$b1['2']; $k++)
				{	
					for($l=$a1['3']; $l<=$b1['3']; $l++)
					{		
							$arr1=$i.".".$j.".".$k.".".$l;
						 	
							
								
							$sql="insert into commondb.ip_operator_tbl (ip,operator,operator_id,country) values ('".$arr1."','".$c1."','".$operator_id."','77') "; 
							$res=$conn->query($sql);
							
							if($l == 255)
							{
								$a1['3']=0;
							}
						
						 
					}
					if($k == 255)
					{
						$a1['2']=0;
					}
					
				}
				if($j == 255)
				{
					$a1['1']=0;
				}
			}
			if($i == 255)
				{
					$a1['0']=0;
				}
		}
		
	
}
?>