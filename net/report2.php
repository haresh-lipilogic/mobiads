<?php
include("includes/connection.php");
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
	date_default_timezone_set('Asia/Kolkata');
	$count=1;

	$operator=strtolower($_POST['operator']); 
	$operatorid=strtolower($_POST['operator']); 
	$product=strtolower($_POST['product']);
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
	
	$date1=date('Y-m-d');
	
		if($startdate == $enddate)
		{
			
			$startdate1=date('Y-m-d',strtotime($_POST['start_date']));
			$enddate1=date('Y-m-d',strtotime($_POST['end_date']));
			//$hours=$_POST['hours'];
			
		}	
		else
		{
			
			$startdate1=date('Y-m-d',strtotime($_POST['start_date']));
			$enddate1=date('Y-m-d',strtotime($_POST['end_date']));
		
			
		}
		
		
		if($enddate1 == $date1 && $startdate1 == $date1)
		{
			$a='1';//currentdate
		}
		elseif($enddate1 == $date1 && $startdate1 != $date1) //current and past date
		{
			
			$b='1';
			$date1=date('Y-m-d',strtotime($_POST['end_date']))." 00:00:00";
			$date2=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
			
			$startdate1=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";
			$enddate1=date('Y-m-d',strtotime($_POST['end_date']))." 00:00:00";
			
		}
		else{ //
			
			$c='1';
		}
		
	
	$type=$_POST['type'];
	$id=$_POST['pubadid']; 
	$country =$_POST['country'];
	
	
	$sql_operator="select * from commondb.operator_tbl where operator_id = '".$operator."'";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	$operator=$row_operator['operator'];
	if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db_0617";	
		}
		elseif(strtolower($operator) == 'airtel' || strtolower($operator) == 'idea')
		{
			$logdb=$operator."_".$product."db_0617";	
		}
		else
		{
			$logdb=$operator."_".$product."db";	
		}
	$logdb=strtolower($logdb);
		
	
	if($type =='Advertiser' || $type == 'advertiser')
	{
		if($id != 'all')
		{
			$condition="AND campaign_tbl.campaign_id = '".$id."'";
			$cond="AND camp_id = '".$id."'";
			
		}
		else
		{
			$condition="";
			$condition1="";
			$cond="";
		}
	}
	else
	{	
		if($id != 'all')
		{
			$condition="AND advertiser_tbl.advertiser_id = '".$id."'";
			$cond="AND camp_id = '".$id."' ";
		}
		else
		{
			$condition="";
			$cond="";
		}
	}
	
	 $sql_operator1="select distinct operator,operator_id from commondb.operator_tbl where country_id = $country ";  
	$res_operator1=$conn->query($sql_operator1);
	
	
	if($type =='Advertiser' || $type == 'advertiser')
	{
		$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
		$res1=$conn->query($sql1);
		
		if($a ==1)
		{
				$sql="
				SELECT 
					dt1 dt,
					CASE
						WHEN campaign_title IS NULL THEN 'OTHER'
						ELSE campaign_title
					END title,
					SUM(clicks) clicks,
					SUM(act) act,
					SUM(dct) dct,
					SUM(cbr) cbr
				FROM
					(SELECT 
						COUNT(DISTINCT userlog_tbl.clickid) clicks,
							0 act,
							0 dct,
							0 cbr,
							DATE(userlog_datetime) dt1,
							campaign_title
					FROM
						".$logdb.".userlog_tbl
					LEFT JOIN ".$logdb.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
					LEFT JOIN ".$logdb.".campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
					WHERE
						userlog_datetime >= '".$startdate."'
							AND userlog_datetime < '".$enddate."'
							".$condition."
					GROUP BY dt1 , campaign_title UNION SELECT 
						0 clicks,
							COUNT(act_tbl1.clickid) act,
							COUNT(dct_tbl1.clickid) dct,
							0 cbr,
							act_tbl1.dt dt,
							act_tbl1.campaign_title
					FROM
						(SELECT DISTINCT
						clickid, DATE(camp_resp_datetime) dt, campaign_title
					FROM
						".$logdb.".campaign_response_tbl
					LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
					WHERE
						camp_resp_datetime >= '".$startdate."'
							AND camp_resp_datetime <= '".$enddate."'
							AND camp_action = 'act'
							".$condition.") act_tbl1
					LEFT JOIN (SELECT DISTINCT
						clickid, DATE(camp_resp_datetime) dt, campaign_title
					FROM
						".$logdb.".campaign_response_tbl
					LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
					WHERE
						camp_resp_datetime >= '".$startdate."'
							AND camp_resp_datetime <= '".$enddate."'
							AND camp_action = 'dct'
							".$condition.") dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
						AND act_tbl1.dt = dct_tbl1.dt
						AND act_tbl1.campaign_title = dct_tbl1.campaign_title
					GROUP BY act_tbl1.dt , act_tbl1.campaign_title UNION SELECT 
						0 click,
							0 act,
							0 dct,
							COUNT(clickid) cbr,
							dt,
							campaign_title
					FROM
						(SELECT DISTINCT
						0 click,
							0 act,
							0 dct,
							clickid,
							DATE(camp_resp_datetime) dt,
							campaign_title
					FROM
						".$logdb.".campaign_response_tbl
					LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
					WHERE
						camp_resp_datetime >= '".$startdate."'
							AND camp_resp_datetime <= '".$enddate."'
							AND camp_action = 'act'
							".$condition."
					GROUP BY clickid) bb
					GROUP BY dt , campaign_title) a
				GROUP BY dt1 , campaign_title

				"; 
				
				$res=$conn->query($sql);
		}
		if($b == 1)
		{
			$sql="
			SELECT 
				dt1 dt,
				CASE
					WHEN campaign_title IS NULL THEN 'OTHER'
					ELSE campaign_title
				END title,
				SUM(clicks) clicks,
				SUM(act) act,
				SUM(dct) dct,
				SUM(cbr) cbr
			FROM
				(SELECT 
					COUNT(DISTINCT userlog_tbl.clickid) clicks,
						0 act,
						0 dct,
						0 cbr,
						DATE(userlog_datetime) dt1,
						campaign_title
				FROM
					".$logdb.".userlog_tbl
				LEFT JOIN ".$logdb.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_request_tbl.campaign_id = campaign_tbl.campaign_id
				WHERE
					userlog_datetime >= '".$date1."'
						AND userlog_datetime < '".$date2."'
						".$condition."
				GROUP BY dt1 , campaign_title UNION SELECT 
					0 clicks,
						COUNT(act_tbl1.clickid) act,
						COUNT(dct_tbl1.clickid) dct,
						0 cbr,
						act_tbl1.dt dt,
						act_tbl1.campaign_title
				FROM
					(SELECT DISTINCT
					clickid, DATE(camp_resp_datetime) dt, campaign_title
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$date1."'
						AND camp_resp_datetime <= '".$date2."'
						AND camp_action = 'act'
						".$condition.") act_tbl1
				LEFT JOIN (SELECT DISTINCT
					clickid, DATE(camp_resp_datetime) dt, campaign_title
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$date1."'
						AND camp_resp_datetime <= '".$date2."'
						AND camp_action = 'dct'
						".$condition.") dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.campaign_title = dct_tbl1.campaign_title
				GROUP BY act_tbl1.dt , act_tbl1.campaign_title UNION SELECT 
					0 click,
						0 act,
						0 dct,
						COUNT(clickid) cbr,
						dt,
						campaign_title
				FROM
					(SELECT DISTINCT
					0 click,
						0 act,
						0 dct,
						clickid,
						DATE(camp_resp_datetime) dt,
						campaign_title
				FROM
					".$logdb.".campaign_response_tbl
				LEFT JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$date1."'
						AND camp_resp_datetime <= '".$date2."'
						AND camp_action = 'act'
						".$condition."
				GROUP BY clickid) bb
				GROUP BY dt , campaign_title) a
			GROUP BY dt1 , campaign_title

			";
			$res=$conn->query($sql);
			
			$sql11="select * from ".$logdb.".report where dt >= '".$startdate1."' and dt <= '".$enddate1."' and pubad=1  ".$cond." ";
			$res11=$conn->query($sql11);
			
			
			
		}
		if($c == 1)
		{
			$sql="select * from ".$logdb.".report where dt >= '".$startdate1."' and dt <= '".$enddate1."' and pubad=1 ".$cond." ";
			$res=$conn->query($sql);
		}
		
	}
	else
	{	
		$commondb="commondb";
		$sql1="SELECT advertiser_name name , advertiser_id id from ".$commondb.".advertiser_tbl ";  
		$res1=$conn->query($sql1);
		
		if($a == 1 )
		{
			$sql="
			SELECT 
				dt1 dt,
				CASE
					WHEN advertiser_name IS NULL THEN 'OTHER'
					ELSE advertiser_name
				END title,
				SUM(clicks) clicks,
				SUM(act) act,
				SUM(dct) dct,
				SUM(cbr) cbr
			FROM
				(SELECT 
					COUNT(userlog_tbl.clickid) clicks,
						0 act,
						0 dct,
						0 cbr,
						DATE(userlog_datetime) dt1,
						advertiser_name
				FROM
					".$logdb.".userlog_tbl
				LEFT JOIN ".$logdb.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
				LEFT JOIN ".$commondb.".advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
				WHERE
					userlog_datetime >= '".$startdate."'
						AND userlog_datetime <= '".$enddate."'
						".$condition."
				GROUP BY dt1 , advertiser_name UNION SELECT 
					0 clicks,
						COUNT(DISTINCT act_tbl1.clickid) act,
						COUNT(DISTINCT dct_tbl1.clickid) dct,
						0 cbr,
						act_tbl1.dt dt,
						act_tbl1.advertiser_name
				FROM
					(SELECT DISTINCT
					clickid, DATE(ad_resp_datetime) dt, advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >='".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND action = 'act'
						".$condition."
				GROUP BY clickid) act_tbl1
				LEFT JOIN (SELECT DISTINCT
					clickid, DATE(ad_resp_datetime) dt, advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND action = 'dct'
						".$condition."
				GROUP BY clickid) dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.advertiser_name = dct_tbl1.advertiser_name
				GROUP BY act_tbl1.dt , act_tbl1.advertiser_name UNION SELECT 
					0 clicks,
						0 act,
						0 dct,
						COUNT(clickid) cbr,
						dt,
						advertiser_name
				FROM
					(SELECT DISTINCT
					0 clicks,
						0 act,
						0 dct,
						clickid,
						DATE(ad_resp_datetime) dt,
						advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND advertiser_response != 'stop'
						AND action = 'act'
						".$condition."
				GROUP BY clickid) bb
				GROUP BY dt , advertiser_name) a
			GROUP BY dt , title;
		";
		
		$res=$conn->query($sql);
		}
		if($b == 1)
		{
			$sql="
			SELECT 
				dt1 dt,
				CASE
					WHEN advertiser_name IS NULL THEN 'OTHER'
					ELSE advertiser_name
				END title,
				SUM(clicks) clicks,
				SUM(act) act,
				SUM(dct) dct,
				SUM(cbr) cbr
			FROM
				(SELECT 
					COUNT(userlog_tbl.clickid) clicks,
						0 act,
						0 dct,
						0 cbr,
						DATE(userlog_datetime) dt1,
						advertiser_name
				FROM
					".$logdb.".userlog_tbl
				LEFT JOIN ".$logdb.".campaign_request_tbl ON userlog_tbl.clickid = campaign_request_tbl.clickid
				LEFT JOIN ".$commondb.".advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
				WHERE
					userlog_datetime >= '".$date1."'
						AND userlog_datetime <= '".$date2."'
						".$condition."
				GROUP BY dt1 , advertiser_name UNION SELECT 
					0 clicks,
						COUNT(DISTINCT act_tbl1.clickid) act,
						COUNT(DISTINCT dct_tbl1.clickid) dct,
						0 cbr,
						act_tbl1.dt dt,
						act_tbl1.advertiser_name
				FROM
					(SELECT DISTINCT
					clickid, DATE(ad_resp_datetime) dt, advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >='".$date1."'
						AND ad_resp_datetime <= '".$date2."'
						AND action = 'act'
						".$condition."
				GROUP BY clickid) act_tbl1
				LEFT JOIN (SELECT DISTINCT
					clickid, DATE(ad_resp_datetime) dt, advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$date1."'
						AND ad_resp_datetime <= '".$date2."'
						AND action = 'dct'
						".$condition."
				GROUP BY clickid) dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.advertiser_name = dct_tbl1.advertiser_name
				GROUP BY act_tbl1.dt , act_tbl1.advertiser_name UNION SELECT 
					0 clicks,
						0 act,
						0 dct,
						COUNT(clickid) cbr,
						dt,
						advertiser_name
				FROM
					(SELECT DISTINCT
					0 clicks,
						0 act,
						0 dct,
						clickid,
						DATE(ad_resp_datetime) dt,
						advertiser_name
				FROM
					".$logdb.".advertiser_response_tbl
				LEFT JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$date1."'
						AND ad_resp_datetime <= '".$date2."'
						AND advertiser_response != 'stop'
						AND action = 'act'
						".$condition."
				GROUP BY clickid) bb
				GROUP BY dt , advertiser_name) a
			GROUP BY dt , title;
			";
			$res=$conn->query($sql);
	 
			$sql11="select * from ".$logdb.".report where dt >= '".$startdate1."' and dt <= '".$enddate1."' and pubad=2  ".$cond."";
			$res11=$conn->query($sql11);
		}
		if($c == 1)
		{
			$sql="select * from ".$logdb.".report where dt >= '".$startdate1."' and dt <= '".$enddate1."' and pubad=2 ".$cond."";
			$res=$conn->query($sql);
		}
		
		 
	}
	



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
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control select2_single" id="product">
							<option>Select</option>
							<option value="Glamour" <?php if($product=='glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="Games" <?php if($product=='games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							<option value="music" <?php if($product=='music'){$selected='selected';}else{$selected='';} echo $selected; ?>>Music</option>
							
						</select>
						</div>
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Country
						<select name="country" class="form-control select2_single" id="country">
							<option>Select</option>
							<option value="77" <?php if($country=='77'){$selected='selected';}else{$selected='';} echo $selected; ?> >India</option>
							<option value="90" <?php if($country=='90'){$selected='selected';}else{$selected='';} echo $selected; ?>>Kuwait</option>
							<option value="128" <?php if($country=='128'){$selected='selected';}else{$selected='';} echo $selected; ?>>Oman</option>
							<option value="11" <?php if($country=='11'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azerbaijan</option>
							
							<option value="171" <?php if($country=='171'){$selected='selected';}else{$selected='';} echo $selected; ?>>Thailand</option>
							
							
						</select>
						</div>
						
						
						<span id="response1">
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
							
						
						
						<?php
						if($count == 1)
						{
						?>
							<select name="operator" class="form-control select2_single" id="operator" >
								
								
								<?php
								while($row_operator1=$res_operator1->fetch())
								{
									if($row_operator1['operator_id']== $operatorid)
									{
										$selected="selected";
									}
									else
									{
										$selected=""; 
									}
								?>
								<option value="<?php echo $row_operator1['operator_id']; ?>" <?php echo $selected; ?>><?php echo $row_operator1['operator']; ?></option>
								<?php
								}
								?>
												
							</select>
						<?php
						}
						?>
						</div>
						</span>
						
						
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser
						<select name="type" class="form-control select2_single" id="pubad">
							<option value='' >Select Publisher / Advertiser</option>
							<option value="Publisher" <?php if($type=='Publisher'){$selected='selected';}else{$selected='';} echo $selected; ?> >Publisher</option>
							<option value="Advertiser" <?php if($type=='Advertiser'){$selected='selected';}else{$selected='';} echo $selected; ?>>Advertiser</option>
							
						</select>
						</div>
						
						<span id="response">
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser Name
						<?php
						if($count == 1)
						{
						?>
							<select name="pubadid" class="form-control select2_single"  id="pubadid" >
								
								<option value="all" >All</option>
								<?php
								while($row1=$res1->fetch())
								{
									if($row1['id']== $id)
									{
										$selected="selected";
									}
									else
									{
										$selected="";
									}
								?>
								<option value="<?php echo $row1['id']; ?>" <?php echo $selected; ?>><?php echo $row1['name']; ?></option>
								<?php
								}
								?>
												
							</select>
						<?php
						}
						?>
						</div>
						</span>
						
						
					</div>
					<div class="x_content">
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($startdate!=''){echo date('d-m-Y',strtotime($startdate));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($enddate!=''){echo date('d-m-Y',strtotime($enddate));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						
						
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
									<td><strong>Date</strong></td>
									<td><strong>Name</strong></td>
									<td><strong>Clicks</strong></td>
									<td><strong>CR %</strong></td>
									<td><strong>Activations</strong></td>
									<td><strong>Deactivations</strong></td>
									<td><strong>Churn %</strong></td>
									<td><strong>Callback</strong></td>
									<td><strong>Callback CR %</strong></td>
									<td><strong>Callback %</strong></td>
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$req_sum='';
								$resp_sum='';
								$act_sum='';
								$actamnt_sum='';
								$dct_sum='';
								$cbr_sum='';
								$dctamnt_sum='';
								
								if($a == 1 || $c == 1)
								{
									while($row=$res->fetch())
									{
										
											
										
								?>
										<tr>
											<td  style="width:10%"><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
											<td style="width:10%"><?php echo $row['title']; ?></td>
											<td style="width:10%"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
											<td style="width:10%"><?php echo number_format(($row['act']/$row['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act']; ?></td>
											<td style="width:10%"><?php echo number_format($row['dct']); $dct_sum=$dct_sum+$row['dct']; ?></td>
											<td  style="width:10%"><?php  $a=number_format(($row['dct']/$row['act'])*100,2)."%"; if($a >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$a."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$a."</span>";}  ?></td>
											<td style="width:10%"><?php echo number_format($row['cbr']); $cbr_sum=$cbr_sum+$row['cbr']; ?></td>
											<td style="width:10%"><?php echo number_format(($row['cbr']/$row['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format(($row['cbr']/$row['act'])*100,2)."%";  ?></td>
											
											
											
										</tr>
								
								
								
								<?php
									}
								}
								else
								{
									while($row11=$res11->fetch())
									{
										
											
										
									?>
										<tr>
										
										
										
										<td  style="width:10%"><?php echo date('d-m-Y',strtotime($row11['dt']));  ?></td>
											<td style="width:10%"><?php echo $row11['title']; ?></td>
											<td style="width:10%"><?php echo number_format($row11['clicks']); $click_sum=$click_sum+$row11['clicks']; ?></td>
											<td style="width:10%"><?php echo number_format(($row11['act']/$row11['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format($row11['act']); $act_sum=$act_sum+$row11['act']; ?></td>
											<td style="width:10%"><?php echo number_format($row11['dct']); $dct_sum=$dct_sum+$row11['dct']; ?></td>
											<td  style="width:10%"><?php  $a=number_format(($row11['dct']/$row11['act'])*100,2)."%"; if($a >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$a."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$a."</span>";}  ?></td>
											<td style="width:10%"><?php echo number_format($row11['cbr']); $cbr_sum=$cbr_sum+$row11['cbr']; ?></td>
											<td style="width:10%"><?php echo number_format(($row11['cbr']/$row11['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format(($row11['cbr']/$row11['act'])*100,2)."%";  ?></td>
											
											
										</tr>		
											
											
										
								
								
								
									<?php
									
									}
									while($row=$res->fetch())
									{
										?>
										<tr>
										
											<td  style="width:10%"><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
											<td style="width:10%"><?php echo $row['title']; ?></td>
											<td style="width:10%"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
											<td style="width:10%"><?php echo number_format(($row['act']/$row['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act']; ?></td>
											<td style="width:10%"><?php echo number_format($row['dct']); $dct_sum=$dct_sum+$row['dct']; ?></td>
											<td  style="width:10%"><?php  $a=number_format(($row['dct']/$row['act'])*100,2)."%"; if($a >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$a."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$a."</span>";}  ?></td>
											<td style="width:10%"><?php echo number_format($row['cbr']); $cbr_sum=$cbr_sum+$row['cbr']; ?></td>
											<td style="width:10%"><?php echo number_format(($row['cbr']/$row['clicks'])*100,2)."%";  ?></td>
											<td style="width:10%"><?php echo number_format(($row['cbr']/$row['act'])*100,2)."%";  ?></td>
											
											
										</tr>
								
								
								
									<?php
									}
									
								}
								?>
								
								<tr>
									<td>Total</td>
									<td></td>
									
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format(($act_sum/$click_sum)*100,2)."%";  ?></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo number_format($dct_sum); ?></td>
									
									<td><?php  $a=number_format(($dct_sum/$act_sum)*100,2)."%"; if($a >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$a."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$a."</span>";}   ?></td>
									<td><?php echo number_format($cbr_sum); ?></td>
									<td><?php echo number_format(($cbr_sum/$click_sum)*100,2)."%";  ?></td>
									<td><?php echo number_format(($cbr_sum/$act_sum)*100,2)."%";  ?></td>
								
									
									
									
									
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