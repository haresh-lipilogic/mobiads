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
$hour="24";
if(isset($_POST['submit']))
{

	$count=1; 

	
	
	$type=strtolower($_POST['type']);
	$product="glamour";
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	$hour=$_POST['hour'];
	
	include("actcron.php");
	$operator='';
	
	$select_country="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  operator_tbl.isactive=1;
	"; 
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res_country= $conn->query($select_country);
	$num=$res_country->rowCount();  
	
	if($type == 'publisher')
	{
	
			$sql="SELECT 
			publisher_name,";
			
			$counter=0;
			
			//$country[]=array();
			while($row_country = $res_country->fetch())
			{
					$country=$row_country['country_name'];
					$operator1=$row_country['operator'];
					$operator2=$row_country['operator'];
					$operator_id1=$row_country['operator_id'];
					
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

			$select_country1="
			SELECT 
				operator_id,country_name, operator_tbl.country_id,operator
			FROM
				".$commondb.".country_tbl
					INNER JOIN
			".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  operator_tbl.isactive=1;
			";
			
			//77,11,90,128,104,171,163,182,111,118,53
			$res_country1= $conn->query($select_country1);
			$counter=0;
			
			while($row_country1 = $res_country1->fetch())
			{
				
					$country=$row_country1['country_name']; 
					$operator1=$row_country1['operator'];
					$operator2=$row_country1['operator'];
					$operator_id1=$row_country1['operator_id'];
						
							
								if(strtolower($operator2) == 'vodafone') 
								{							
									$logdb="voda_".$product."db_cpi";								
								}												
								
								else
								{	
									$logdb=$operator2."_".$product."db_cpi";	
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
											AND HOUR(ad_resp_datetime) <= '".$hour."'
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
											AND HOUR(ad_resp_datetime) <= '".$hour."'
											AND action= 'act'
									GROUP BY advertiser_id, operator "; 
									}
							
								}
								else{
									//$counter=$counter+1;
								}
			}
			
			$sql.=") a
				GROUP BY publisher_name , operator
				ORDER BY publisher_name;";

	}
	elseif($type=='advertiser')
	{
	
		$sql="SELECT 
		advertiser_name,";
		//$product = "games";
	
		$counter=0;
		
		while($row_country = $res_country->fetch())
		{
			$country=$row_country['country_name'];
			$operator1=$row_country['operator'];
			$operator2=$row_country['operator'];
			$operator_id1=$row_country['operator_id'];
			
			if($counter == ($num-1) )
			{
				$counter=$counter+1;
				$sql.="CASE
					WHEN operator = ".$operator_id1."  THEN SUM(s)
				END ".$operator1."_amt ,
				CASE
					WHEN operator = ".$operator_id1."  THEN SUM(c)
				END ".$operator1."
				from ("; 
			}
			else
			{
				$counter=$counter+1;
				$sql.="CASE
					WHEN operator = ".$operator_id1."  THEN SUM(s)
				END ".$operator1."_amt,
				CASE
					WHEN operator = ".$operator_id1."  THEN SUM(c)
				END ".$operator1.",
				";
			}				
					
		}
		
			
		$select_country1="
		SELECT 
			operator_id,country_name, operator_tbl.country_id,operator
		FROM
			".$commondb.".country_tbl
				INNER JOIN
		".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  operator_tbl.isactive=1;
		";
		
		//77,11,90,128,104,171,163,182,111,118,53
		$res_country1= $conn->query($select_country1);
		$counter=0;
		
		while($row_country1 = $res_country1->fetch())
		{
				
					$country=$row_country1['country_name']; 
					$operator1=$row_country1['operator'];
					$operator2=$row_country1['operator'];
					$operator_id1=$row_country1['operator_id'];
						
						
					if(strtolower($operator2) == 'vodafone') 
						{							
							$logdb="voda_".$product."db_cpi";								
						}												
						
						else
						{	
							$logdb=$operator2."_".$product."db_cpi";	
						}
					
					$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'";
					$res_db=$conn->query($db);
					$row_db=$res_db->rowCount(); 
					if($row_db > 0)
					{
						if($counter == 0 )
						{$counter=$counter+1;
							
							$sql.="  SELECT 
									COUNT(clickid) c,
									advertiser_name,
									campaign_id,
									operator,
									SUM(campaign_price) s
								FROM
									(SELECT DISTINCT
										clickid,
											campaign_title advertiser_name,
											campaign_tbl.campaign_id campaign_id,
											operator,
											campaign_price
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						INNER JOIN ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND HOUR(ad_resp_datetime) <= '".$hour."'
								AND action= 'act' ) a".$counter."
						GROUP BY campaign_id, operator";
						}
						else
						{	
							$counter=$counter+1;
							$sql.=" UNION SELECT 
									COUNT(clickid) c,
									advertiser_name,
									campaign_id,
									operator,
									SUM(campaign_price) s
								FROM
									(SELECT DISTINCT
										clickid,
											campaign_title advertiser_name,
											campaign_tbl.campaign_id campaign_id,
											operator,
											campaign_price
						FROM
							".$logdb.".advertiser_response_tbl
						INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
						INNER JOIN ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
						WHERE
							ad_resp_datetime >= '".$startdate."'
								AND ad_resp_datetime <= '".$enddate."'
								AND HOUR(ad_resp_datetime) <= '".$hour."'
								AND action= 'act' ) a".$counter."
						GROUP BY campaign_id, operator ";
						}
				
					}
					else{
						//$counter=$counter+1;
					}	
						
		}
		


			$sql.=") a
		GROUP BY advertiser_name , operator
		ORDER BY advertiser_name;";
	}
	else{
		$sql="SELECT 
    partner,
    sa,
    CASE
        WHEN partner = 'airgsa' THEN sa * 2.3
        WHEN partner = 'linkitsa' THEN sa * 2.2
        WHEN partner = 'svmobisa' THEN sa * 0
        WHEN partner = 'multiroutingsa' THEN sa * 2.3
        WHEN partner = 'amusedigisa' THEN sa * 2.5
        WHEN partner = 'jovialsa' THEN sa * 1.5
        WHEN partner = '100sportssa' THEN sa * 2.5
        ELSE sa
    END saamount,
    om,
    CASE
        WHEN partner = 'airgom' THEN om * 2.2
        WHEN partner = 'svmobiom' THEN om * 0
        WHEN partner = 'multiroutingom' THEN om * 2.5
        WHEN partner = 'shemarooom' THEN om * 2.5
        WHEN partner = 'in10mediaom' THEN om * 2.2
  
        ELSE om
    END omamount,
    ae,
    CASE
        WHEN partner = 'airgae' THEN ae * 3.4
        WHEN partner = 'svmobiae' THEN ae * 0
        WHEN partner = 'multiroutingae' THEN ae * 4
        WHEN partner = 'hungamaae' THEN ae * 3.5
        WHEN partner = 'jovialae' THEN ae * 3.4
        WHEN partner = 'netmarbleae' THEN ae * 3.5
        WHEN partner = 'in10mediaae' THEN ae * 4
        ELSE ae
    END aeamount,
    ps,
	CASE
        WHEN partner = 'linkitps' THEN ps * 0.7
        WHEN partner = 'airgps' THEN ps * 2
        ELSE ps
    END psamount,
    0 iq
FROM
    (SELECT 
        CONCAT(partner, 'sa') partner,
            COUNT(distinct msisdn) sa,
            0 om,
            0 ae,
            0 ps,
            0 iq
    FROM
        fashionbardb_airg_sa.pinverify
    WHERE
        ( status = 'success' or status = 'pending')
            AND pindatetime >= '".$startdate."'
            AND pindatetime <= '".$enddate."'
			AND partner != 'svmobi'
    GROUP BY partner UNION ALL SELECT 
        CONCAT(partner, 'om') partner,
            0 sa,
            COUNT(*) om,
            0 ae,
            0 ps,
            0 iq
    FROM
        fashionbardb_airg_om.pinverify
    WHERE
       ( status = 'success' or status = 'pending')
            AND pindatetime >= '".$startdate."'
            AND pindatetime <= '".$enddate."'
			AND partner != 'svmobi'
    GROUP BY partner UNION ALL SELECT 
        CONCAT(partner, 'ae') partner,
            0 sa,
            0 om,
            count(*) ae,
            0 ps,
            0 iq
    FROM
        fashionbardb_airg_ae.pinverify
    WHERE
        ( status = 'success' or status = 'pending')
          AND pindatetime >= '".$startdate."'
            AND pindatetime <= '".$enddate."'
			AND partner != 'svmobi'
    GROUP BY partner
	
	UNION ALL SELECT 
        CONCAT(partner, 'ps') partner,
            0 sa,
            0 om,
            0 ae,
            COUNT(*) ps,
            0 iq
    FROM
        fashionbardb_airg_ps.pinverify
    WHERE
        ( status = 'success' or status = 'pending')
            AND pindatetime >= '".$startdate."'
            AND pindatetime <= '".$enddate."'
			AND partner != 'svmobi'
    GROUP BY partner) a;";
	}
		//echo $sql; exit;
 	$res=$conn->query($sql);
	
	


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
						<!--	<option value="api" <?php if($type=='api'){$selected='selected';}else{$selected='';} echo $selected; ?> >API</option> -->
							
							
						</select>
						</div>
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($startdate!=''){echo date('d-m-Y',strtotime($startdate));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($enddate!=''){echo date('d-m-Y',strtotime($enddate));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Hour
						<select class="form-control select2_single 1_24" name="hour" >
							<?php
							
								for ($i=24; $i>0; $i--)
								{
									if($i-1 == $hour)
									{
										$selected="selected";
									}
									else{
										$selected = "";
									}
									?>
										<option value="<?php echo $i-1;?>" <?php echo $selected; ?> ><?php echo $i;?></option>
									<?php
								}
							?>
						</select>
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
				if($type=='advertiser')
				{
			?>	
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							

								<tbody>
								<tr>
								<?php
								$total_column = $res->columnCount();


									for ($counter = 0; $counter < $total_column; $counter ++) {
									$meta = $res->getColumnMeta($counter);
									if(substr($meta["name"],-4) == '_amt')
									{
									}
									else{
								   ?>
								   <td style="width:120px !important; border : 3px solid #afafaf;"><?php echo $column[] = $meta['name'];  ?></td>
									<?php
									}
								   }
									
								?>
								<td  style="width:120px !important; border : 3px solid #afafaf;">Total</td>
								</tr>
								</tbody>
								<tbody>
								<?php 
								
								
								
									while($row=$res->fetch())
									{
										
								?>
									<tr>
									
									<?php
									$total_column = $res->columnCount();
				
									$sum1=0;
									$sum2=0;
										for ($counter = 0; $counter < $total_column; $counter ++) 
										{
											$meta = $res->getColumnMeta($counter);
											//$a= $row[$column[] = $meta["name"]]; 
											
											if(substr($meta["name"],-4) == '_amt')
											{
												$a1= $row[$column[] = $meta["name"]];
												if($counter == 0)
												{
													
												}
												else
												{ 
													${"check2" . $counter}=${"check2" . $counter}+$row[$column[] = $meta["name"]];  
												}
											}
											else
											{
												 $b1= $row[$column[] = $meta["name"]];
											
											
												if($counter == 0)
												{
													
												}
												else
												{
													${"check1" . $counter}=${"check1" . $counter}+$row[$column[] = $meta["name"]]; 
												}
											
												if($b1 == '')
												{
													?>
													<td style="width:120px !important;"><?php echo "0"; ?></td>
													<?php
												}
												else
												{
													if($counter==0)
													{
														?>
														<td style="width:120px !important; border : 3px solid #afafaf;font-weight:bold !important;"><?php echo $b1; ?></td>
														<?php
													}
													else
													{
														?>
															<td style="width:120px !important; border : 3px solid #afafaf;font-weight:bold !important;"><?php echo "$".number_format($a1,2)." || ".$b1; $sum1=$sum1+$a1;
													$sum2=$sum2+$b1;?></td>
														<?php
													}
													
												}
												
											}
									 
									   }
									
									?>
										
									
											<td  style="width:120px !important; border : 3px solid #afafaf;"><?php echo "$".number_format($sum1,2)." || ".$sum2; $total1=$total1+$sum1; $total2=$total2+$sum2;  ?></td>
										
										
									</tr>
								
								
								
								<?php
								 
									}
									
								?>
								
								
							</tbody>
							<tbody>
								<tr>
								<td style="width:120px !important; border : 3px solid #afafaf;font-weight:bold !important;">Total</td>
								
								<?php
								$total_column = $res->columnCount();

									$c=0;
									for ($counter = 0; $counter < $total_column; $counter ++) {
										
										
										
									$meta = $res->getColumnMeta($counter);
									if(substr($meta["name"],-4) == '_amt')
											{
												?>
												<td style="width:120px !important ; border : 3px solid #afafaf;">
												<?php
												
												
												if($counter== '0') 
													{
														//echo "Total"; 
													} 
													else
													{ 
												
														echo "$".number_format(${"check2" . $counter},2)." || "; 
													
													
													}
											}
											else{
												
												
													if($counter== '0') 
													{
														//echo "Total"; 
													} 
													else
													{ 
														echo  ${"check1" . $counter};
													
													}
													?>
													</td>
													<?php
												}
											
											}
									
								?>
								
								 <td style="width:120px !important; border : 3px solid #afafaf;"><?php echo "$".number_format($total1,2)." || ".$total2 ;  ?></td>
								</tr>
								</tbody>
							
								
								
						</table>
					  </div>
				
			<?php
				}
				elseif($type=="publisher"){
					?>
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							

								<tbody>
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
								</tbody>
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
				else{
					?>
					
					
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							

								<tbody>
								<tr>
								<td style="width:120px !important; border : 3px solid #afafaf;">Partner</td>
								<td style="width:120px !important; border : 3px solid #afafaf;">SA</td>
								<td style="width:120px !important; border : 3px solid #afafaf;">OM</td>
								<td style="width:120px !important; border : 3px solid #afafaf;">AE</td>
								<td style="width:120px !important; border : 3px solid #afafaf;">PS</td>
								<td style="width:120px !important; border : 3px solid #afafaf;">TOTAL</td>
								
								
								</tr>
								</tbody>
								<tbody>
								<?php 
								
								
								
									while($row=$res->fetch())
									{
										$sa1=0;
										$om1=0;
										$ae1=0;
										$ps1=0;
										
										$saamt1=0;
										$omamt1=0;
										$aeamt1=0;
										$psamt1=0;
								?>
									<tr>
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php echo strtoupper($row['partner']); ?></td>		
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($row['sa'] == '0'){ echo "0"; }else{ echo $row['sa']." || $".$row['saamount']; $sa=$sa+$row['sa']; $saamt=$saamt+$row['saamount']; $sa1=$sa; $saamt1=$saamt;    } ?></td>	
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($row['om'] == '0'){ echo "0"; }else{ echo $row['om']." || $".$row['omamount']; $om=$om+$row['om']; $omamt=$omamt+$row['omamount']; $om1=$om; $omamt1=$omamt;} ?></td>
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($row['ae'] == '0'){ echo "0"; }else{ echo $row['ae']." || $".$row['aeamount']; $ae=$ae+$row['ae']; $aeamt=$aeamt+$row['aeamount']; $ae1=$ae; $aeamt1=$aeamt;} ?></td>
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($row['ps'] == '0'){ echo "0"; }else{ echo $row['ps']." || $".$row['psamount']; $ps=$ps+$row['ps']; $psamt=$psamt+$row['psamount']; $ps1=$ps; $psamt1=$psamt;} ?></td>
									<td style="width:120px !important; border : 3px solid #afafaf;"><?php $totalall= $sa+$om+$ae+$ps; $totalallamt=$saamt+$omamt+$aeamt+$psamt; $total1= $sa1+$om1+$ae1+$ps1; $total2= $saamt1+$omamt1+$aeamt1+$psamt1; echo $total1." || $".$total2; 	?></td>
									
									
									</tr>
								
								
								
								<?php
								 
									}
									
								?>
								
								<tr>
								<td style="width:120px !important; border : 3px solid #afafaf;">TOTAL</td>
								<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($sa ==''){echo "0";}else{ echo $sa." || $".$saamt;} ?></td>
								<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($om ==''){echo "0";}else{ echo $om." || $".$omamt;} ?></td>
								<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($ae ==''){echo "0";}else{ echo $ae." || $".$aeamt;} ?></td>
								<td style="width:120px !important; border : 3px solid #afafaf;"><?php if($ps ==''){echo "0";}else{ echo $ps." || $".$psamt;} ?></td>
								<td style="width:120px !important; border : 3px solid #afafaf;"><?php echo $totalall." || $".$totalallamt; ?></td>
								
								
								
								</tr>
							</tbody>
							
								
								
						</table>
					  </div>
					
					<?php
				}
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