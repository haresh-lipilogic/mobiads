<?php

$product ="glamour";

if(strtolower($operator)  == 'vodafone')
{
		$logdb="voda_".$product."db_cpi";
}
else
{
		$logdb=$operator."_".$product."db_cpi";	
}


	
?>