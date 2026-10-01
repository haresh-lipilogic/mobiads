<?php 

include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);


$pro="glamour";
 $select_country="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id ;
	";
	
	
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res_country= $conn->query($select_country);
	$num=$res_country->rowCount();  
	//$country[]=array();
	
	
	while($row_country = $res_country->fetch())
	{
		$opid=$row_country['operator_id'];
		$operator=$row_country['operator'];

		
		if(strtolower($operator)=='vodafone' )
		{
			$db="voda_".$pro."db_cpi";
		}
		
		else
		{
			$db=$operator."_".$pro."db_cpi"; 
			
		}
		
		$sql_db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$db."'";
		$res_db=$conn->query($sql_db);
		$row_db=$res_db->rowCount();
		
		if($row_db > 0  )
		{
			
			 
		
			
				 $update="update  ".$db.".advertiser_callback_counter_tbl set spo_callback_counter='20',act_callback_counter='20' ;"; 
				$res_update=$conn->query($update);
			
			
		}
		else{
		//echo $operator;
			
		}
				

	}
	
?>