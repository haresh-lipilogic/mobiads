<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");


$val=$_GET['val'];

$c=$_GET['c'];



	
			if($c == 'check')
			{
				$update="update ".$commondb.".operator_tbl set isactive = '1' where operator_id in (".$val.") "; 
				$res=$conn->query($update);
				
			}
			else
			{
					$update="update ".$commondb.".operator_tbl set isactive = '0' where operator_id in (".$val.") "; 
					$res=$conn->query($update);
			}	
				
	


?>