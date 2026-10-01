<?php

include("includes/connection.php");
include("includes/language_cpi.php");

error_reporting(0);


$startdate='';
$enddate='';
$operator='';
$country='';
$product='';
$type='';
$count=0;
$cc=0; 
if(isset($_POST['submit']))
{

	$count=1; 

	
	
	$type=strtolower($_POST['type']);
	$product="glamour";
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
	include("actcron.php");
	$operator='';
	
	 $select_country="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  isactive=1;
	";
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res_country= $conn->query($select_country);
	$num=$res_country->rowCount();  
	//$country[]=array();
	while($row_country = $res_country->fetch())
	{
		$country[]=array( "country" => $row_country['country_name']);
		$operator[]=array( $row_country['operator_id'] => $row_country['operator']);
		$operator1[]=array( $row_country['operator_id'] => $row_country['operator']);
		$operator2[]=array( $row_country['operator_id'] => $row_country['operator']);
		$operator3[]=array( $row_country['operator_id'] => $row_country['operator']);
	}
	
	
	if($type == 'publisher')
	{
		//print_r($operator); exit;
	$sql="SELECT 
    publisher_name,";
	//$product = "games";
	
		$counter=0;
		
			foreach($operator1 as  $record)
			{	
				foreach($record as $index2 => $value)
				{
				$operator1= $value;
				$operator_id1 = $index2; 
				
				
					if($counter == ($num-1) )
					{
						$counter=$counter+1;
						$sql.="CASE
							WHEN operator = ".$operator_id1."  THEN SUM(c)
						END ".$operator1." from ("; 
					}
					else
					{
						$counter=$counter+1;
						$sql.="CASE
							WHEN operator = ".$operator_id1."  THEN SUM(c)
						END ".$operator1.", ";
					}
				
				
				
				}
				
			}
		
	
	
		$counter=0;
		
			foreach($operator2 as  $record)
			{
				foreach($record as $index3 => $value)
				{
					$operator2= $value;
					
					if($product == 'glamour' || $product == 'games')
					{
						if(strtolower($operator2) == 'vodafone') 
						{
							
							

							if(strtolower($product)  == 'games')
							{
								$logdb="voda_".$product."db_0817";
							}
							else
							{
								$logdb="voda_".$product."db";
							}							
						}
						elseif( strtolower($operator2) == 'idea')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0218_02";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0218_12";
							}
						}
						elseif(  strtolower($operator2) == 'airtel')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}	
						}
						elseif(  strtolower($operator2) == 'ais')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'dtac')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1017";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'truemove')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'indosat')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'xl')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'mtn')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'vodacom')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						else
						{	
							$logdb=$operator2."_".$product."db";	
						}
					}
					else
					{
						if(strtolower($operator2) == 'vodafone') 
						{
							
							if(strtolower($product)  == 'games')
							{
								$logdb="voda_".$product."db_0817";
							}
							else
							{
								$logdb="voda_".$product."db";
							}		
						}
						elseif( strtolower($operator2) == 'idea')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0218_02";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0218_12";
							}
						}
						elseif(  strtolower($operator2) == 'airtel')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}	
						}
						elseif(  strtolower($operator2) == 'ais')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_1117";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'dtac')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1017";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'truemove')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'xl')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'mtn')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'indosat')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'vodacom')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						else
						{	
							$logdb=$operator2."_".$product."db";	
						}
					}
					
					$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'";
					$res_db=$conn->query($db);
					$row_db=$res_db->rowCount(); 
					
					if($row_db > 0)
					{
						
						if($counter == 0 )
						{
							$counter=$counter+1; 
							
							$sql.="  SELECT 
							advertiser_name publisher_name,
								COUNT(distinct clickid) c,
								advertiser_tbl.advertiser_id,
								operator
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND action= 'act'
						GROUP BY advertiser_id, operator"; 
						}
						else
						{	
							$counter=$counter+1; 
							$sql.=" UNION SELECT 
							advertiser_name publisher_name,
								COUNT(distinct clickid) c,
								advertiser_tbl.advertiser_id,
								operator
								
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND action= 'act'
						GROUP BY advertiser_id, operator "; 
						}
				
					}
					else{
						//$counter=$counter+1;
					}
					
				}
			}
			

			$sql.=") a
		GROUP BY publisher_name , operator
		ORDER BY publisher_name;";
		
	
		
	}
	else
	{
		//print_r($operator); exit;
	$sql="SELECT 
    advertiser_name,";
	//$product = "games";
	
		$counter=0;
		
			foreach($operator1 as  $record)
			{	
				foreach($record as $index2 => $value)
				{
				$operator1= $value;
				$operator_id1 = $index2; 
				
				
					if($counter == ($num-1) )
					{
						$counter=$counter+1;
						$sql.="CASE
							WHEN operator = ".$operator_id1."  THEN SUM(c)
						END ".$operator1." from ("; 
					}
					else
					{
						$counter=$counter+1;
						$sql.="CASE
							WHEN operator = ".$operator_id1."  THEN SUM(c)
						END ".$operator1.", ";
					}
				
				
				
				}
				
			}
		
	
	
		$counter=0;
		
			foreach($operator2 as  $record)
			{
				foreach($record as $index3 => $value)
				{
					$operator2= $value;
					
					
					if($product == 'glamour' || $product == 'games')
					{
						if(strtolower($operator2) == 'vodafone') 
						{
							
							if(strtolower($product)  == 'games')
							{
								$logdb="voda_".$product."db_0817";
							}
							else
							{
								$logdb="voda_".$product."db";
							}		
						}
						elseif(strtolower($operator2) == 'idea' )
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0218_02";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0218_12";
							}
						}
						elseif(  strtolower($operator2) == 'airtel')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}	
						}
						elseif(  strtolower($operator2) == 'ais')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'dtac')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1017";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'truemove')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'indosat')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'mtn')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'xl')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'vodacom')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						else
						{	
							$logdb=$operator2."_".$product."db";	
						}
					}
					else
					{
						if(strtolower($operator2) == 'vodafone') 
						{
							
							if(strtolower($product)  == 'games')
							{
								$logdb="voda_".$product."db_0817";
							}
							else
							{
								$logdb="voda_".$product."db";
							}		
						}
						elseif(strtolower($operator2) == 'idea' )
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0218_02";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0218_12";
							}
						}
						elseif(  strtolower($operator2) == 'airtel')
						{
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}	
						}
						elseif(  strtolower($operator2) == 'ais')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'dtac')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1017";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0318";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'truemove')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db_0118";
							}
							
							
						}
						
						elseif(  strtolower($operator2) == 'indosat')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'mtn')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'xl')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db_1217";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						elseif(  strtolower($operator2) == 'vodacom')
						{
						
							if(strtolower($product)  == 'games')
							{
								$logdb=$operator2."_".$product."db";
							}
							else
							{
								$logdb=$operator2."_".$product."db";
							}
							
							
						}
						else
						{	
							$logdb=$operator2."_".$product."db";	
						}
					}
					
					
					$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'";
					$res_db=$conn->query($db);
					$row_db=$res_db->rowCount(); 
					if($row_db > 0)
					{
						if($counter == 0 )
						{$counter=$counter+1;
							
							$sql.="  SELECT 
								campaign_title advertiser_name,
								COUNT(DISTINCT clickid) c,
								campaign_tbl.campaign_id,
								operator
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						INNER JOIN ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND action= 'act'
						GROUP BY campaign_id, operator";
						}
						else
						{	
							$counter=$counter+1;
							$sql.=" UNION SELECT 
								campaign_title advertiser_name,
								COUNT(DISTINCT clickid) c,
								campaign_tbl.campaign_id,
								operator
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						INNER JOIN ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND action= 'act'
						GROUP BY campaign_id, operator ";
						}
				
					}
					else{
						//$counter=$counter+1;
					}
					
				}
			}
			

			$sql.=") a
		GROUP BY advertiser_name , operator
		ORDER BY advertiser_name;";
	}
	
	//echo $sql; exit;
 	$res=$conn->query($sql);
	
	

//echo "<script>window.location='report.php';</script>";



}
?>

		<?php include("includes/header.php"); ?>
		<?php include("includes/sidebar.php"); ?>
		<?php include("includes/top_navigation.php"); ?>
            
			

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Report</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						
					<div class="x_content">
					
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser
						<select name="type" class="form-control select2_single" >
							<option value="advertiser" <?php if($type=='advertiser'){$selected='selected';}else{$selected='';} echo $selected; ?> >Advertiser</option>
							<option value="publisher" <?php if($type=='publisher'){$selected='selected';}else{$selected='';} echo $selected; ?> >Publisher</option>
							
							
						</select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($startdate!=''){echo date('d-m-Y',strtotime($startdate));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($enddate!=''){echo date('d-m-Y',strtotime($enddate));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						
						
					</div>
					<div class="x_content">
						
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      
					</div>
                 </form>
                  
                </div>
				   
              
              </div>
            </div>
			
			<div class="row">

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Output Records <small></small></h2>
							<ul class="nav navbar-right panel_toolbox">
							  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							  </li>
							  <li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
								<ul class="dropdown-menu" role="menu">
								  <li><a href="#">Settings 1</a>
								  </li>
								  <li><a href="#">Settings 2</a>
								  </li>
								</ul>
							  </li>
							  <li><a class="close-link"><i class="fa fa-close"></i></a>
							  </li>
							</ul>
							<div class="clearfix"></div>
						</div>
						
			<?php 	
			if($count==1)
			{
			?>	
			
					<div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							

								<thead>
									<tr>
										<?php
										$total_column = $res->columnCount();


											for ($counter = 0; $counter < $total_column; $counter ++) {
											$meta = $res->getColumnMeta($counter);
										   ?>
										   <td style="width:120px !important; border : 3px solid #afafaf;"><?php echo $column[] = $meta['name'];  ?></td>
											<?php
										   }
											
										?>
										<td  style="width:120px !important; border : 3px solid #afafaf;">Total</td>
									</tr>
								</thead>
								<tbody>
								<?php 
								
								
								
									while($row=$res->fetch())
									{
										
								?>
									<tr>
									
									<?php
									$total_column = $res->columnCount();
				
									$sum=0;
										for ($counter = 0; $counter < $total_column; $counter ++) {
											$meta = $res->getColumnMeta($counter);
											$a= $row[$column[] = $meta["name"]];
											if($counter == 0)
											{}
											else
											{
												${"check" . $counter}=${"check" . $counter}+$row[$column[] = $meta["name"]]; 
											}
											if($a == '')
											{
												?>
												<td style="width:120px !important;"><?php echo "0"; ?></td>
												<?php
											}
											else
											{
												?>

												<td style="width:120px !important; border : 3px solid #afafaf;font-weight:bold !important;"><?php echo $a; $sum=$sum+$a;
												?></td>
												<?php
											}
									 
									   }
									
									?>
										
									
											<td  style="width:120px !important; border : 3px solid #afafaf;"><?php echo $sum; $total=$total+$sum; ?></td>
										
										
									</tr>
								
								
								
								<?php
								 
									}
									
								?>
								
								
							</tbody>
							<tbody>
								<tr>
								<?php
								$total_column = $res->columnCount();

									$c=0;
									for ($counter = 0; $counter < $total_column; $counter ++) {
									$meta = $res->getColumnMeta($counter);
									
								   ?>
								   <td style="width:120px !important ; border : 3px solid #afafaf;"><?php if($counter== '0') {echo "Total"; } else{ echo ${"check" . $counter};} ?></td>
									<?php
								   }
									
								?>
								 <td style="width:120px !important; border : 3px solid #afafaf;"><?php echo $total;  ?></td>
								</tr>
								</tbody>
							
								
								
						</table>
					  </div>
			<?php
			}
			else
			{}
			?>
					</div>
                </div>
			</div>
			
		</div>
        <!-- /page content -->

       <?php
	   include("includes/footer.php");
		?>

<script type="text/javascript">
$(document).ready(function(){

    $("#country").change(function(){
		
		var country=$("#country").val();
		
			$("#operator").val('');
			$("#pubad").val('');
			$("#pubadid").val('');
			$("#temp").hide();
			 
			
		
		
        $.ajax({
            type: "GET",
            url: "ajax/find_operator1.php?country="+country       
			
        }).done(function(data){
            $("#response1").html(data);
			 
        });
    });
});
</script>	
		
		
		
		
<script type="text/javascript">
$(document).ready(function(){

    $("#pubad").change(function(){
		
		var check1=$("#check1").val();
		if(check1 == 0)
		{
			
		}
		else	
		{
			$(".sel").val('');
			$("#t").hide();
			$("#f").show();
						
		}
        var operator = $("#operator").val();
		var product = $("#product").val();
		var pubad = $("#pubad").val();
		
        $.ajax({
            type: "GET",
            url: "ajax/find_publisher_advertiser.php?operator="+operator+"&product="+product+"&pubad="+pubad       
			
        }).done(function(data){
            $("#response").html(data);
			 
        });
    });
});
</script>	