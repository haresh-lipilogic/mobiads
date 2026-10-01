<?php
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$type='';
$display='';
$count=0;
$cc=0; 
if(isset($_POST['submit']))
{
	
	$count=1;

	$operator=strtolower($_POST['operator']);
	$operatorid=strtolower($_POST['operator']); 
	$product="glamour";
	$start_date=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00"; 
	$end_date=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	$type=$_POST['type'];
	$id=$_POST['pubadid']; 
	$display=$_POST['display'];
	$country =$_POST['country'];
	
	
	
	$sql_operator="select * from ".$commondb.".operator_tbl where operator_id = '".$operator."'";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	$operator=$row_operator['operator'];
	 $sql_operator1="select distinct operator,operator_id from ".$commondb.".operator_tbl where country_id = $country ";  
	$res_operator1=$conn->query($sql_operator1);
	
		include("includes/db.php");
	$logdb=strtolower($logdb);
		
	
	
	if($type =='Advertiser' || $type == 'advertiser')
	{
		if($id != 'all')
		{
			$condition="AND campaign_tbl.campaign_id = '".$id."'";
			
		}
		else
		{
			$condition="";
			$condition1="";
		}
	}
	else
	{	
		if($id != 'all')
		{
			$condition="AND advertiser_tbl.advertiser_id = '".$id."'";
		}
		else
		{
			$condition="";
		}
	}
	
	if($type =='Publisher' || $type == 'publisher')
	{ 
		$sql1="select advertiser_name name, advertiser_id id from ".$commondb.".advertiser_tbl  "; 
		$res1=$conn->query($sql1);
		if($display == 'activation')
		{
		 	$sql="
					SELECT 
						COUNT( distinct clickid) act, DATE(ad_resp_datetime) dt, HOUR(ad_resp_datetime) hr
					FROM
						".strtolower($logdb).".advertiser_response_tbl
							LEFT JOIN
						".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
					WHERE
						ad_resp_datetime >= '".$start_date."'
							AND ad_resp_datetime <='".$end_date."'
							AND action = 'act'
							".$condition."
					GROUP BY dt,hr order by hr"; 
		
					
		}
		elseif($display == 'churn')
		{
			$sql="
					SELECT 
						COUNT(clickid) act, DATE(ad_resp_datetime) dt, HOUR(ad_resp_datetime) hr
					FROM
						".strtolower($logdb).".advertiser_response_tbl
							LEFT JOIN
						".strtolower($logdb).".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
					WHERE
						ad_resp_datetime >= '".$start_date."'
							AND ad_resp_datetime <='".$end_date."'
							AND action = 'dct'
							".$condition."
					GROUP BY dt,hr order by hr";
			
		
		}
		elseif($display == 'cb')
		{
			$sql="
				SELECT 
					COUNT(clickid) act,
					DATE(ad_resp_datetime) dt,
					HOUR(ad_resp_datetime) hr
				FROM
					".strtolower($logdb).".advertiser_response_tbl
						LEFT JOIN
					".strtolower($logdb).".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$start_date."'
						AND ad_resp_datetime <= '".$end_date."'
						AND advertiser_response != 'stop'
						AND action = 'act'
				GROUP BY dt , hr";
		}
		elseif($display == 'cr')
		{
			$sql="SELECT 
					clicks, act, dt1 dt, CASE 
					WHEN  round(((act / clicks) * 100),2) is null then 0
					else
					round(((act / clicks) * 100),2)
					END act, click_tbl.hr hr
				FROM
					(SELECT 
						COUNT(advertiserlog_tbl.clickid) clicks,
							DATE(adlog_datetime) dt1,
							HOUR(adlog_datetime) hr
					FROM
						".strtolower($logdb).".advertiserlog_tbl
					LEFT JOIN ".strtolower($logdb).".campaign_request_tbl ON advertiserlog_tbl.clickid = campaign_request_tbl.clickid
					LEFT JOIN ".strtolower($logdb).".advertiser_tbl ON campaign_request_tbl.advertiser_id = advertiser_tbl.advertiser_id
					WHERE
						adlog_datetime >= '".$start_date."'
							AND adlog_datetime < '".$end_date."'
							".$condition."
					GROUP BY dt1 , hr) click_tbl
						LEFT JOIN
					(SELECT 
						COUNT(clickid) act,
							DATE(ad_resp_datetime) dt2,
							HOUR(ad_resp_datetime) hr
					FROM
						".strtolower($logdb).".advertiser_response_tbl
					LEFT JOIN ".strtolower($logdb).".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
					WHERE
						ad_resp_datetime >= '".$start_date."'
							AND ad_resp_datetime < '".$end_date."'
							AND action = 'act'
							".$condition."
					GROUP BY dt2 , hr) act_tbl ON click_tbl.dt1 = act_tbl.dt2
						AND click_tbl.hr = act_tbl.hr
				GROUP BY dt , click_tbl.hr order by click_tbl.hr
				";
				
				
				
		}
		else
		{
			exit;
			 $sql="SELECT 
					COUNT(userlog_tbl.clickid) act,
					DATE(userlog_datetime) dt,
					HOUR(userlog_datetime) hr,
					'other' advname
				FROM
					".$logdb.".userlog_tbl
						LEFT JOIN
					".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = userlog_tbl.advertiser_id
				WHERE
					userlog_datetime >= '".$start_date."'
						AND userlog_datetime <= '".$end_date."'
						".$condition."
				GROUP BY dt , hr,advname;
				"; 
		}
		$res=$conn->query($sql); 
				$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=$res->fetch())
					{	
						if($prevdate == "")
							$prevdate = $row['dt'];
						
						if($prevdate != $row['dt'])
						{
							$dt[$prevdate]= $act;		
							$act = array();
							$prevdate = $row['dt'];
						}
						
						
							$act[$row['hr']]= $row['act'];	
						
						
						if(!in_array($row['hr'], $advname)) 
							$advname[] = $row['hr'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
				
	
	}
	else
	{
		$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
		$res1=$conn->query($sql1);
		if($display == 'activation')
		{
			$sql="
					SELECT 
						COUNT(clickid) act, DATE(camp_resp_datetime) dt, HOUR(camp_resp_datetime) hr
					FROM
						".strtolower($logdb).".campaign_response_tbl
							LEFT JOIN
						".strtolower($logdb).".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
					WHERE
						camp_resp_datetime >= '".$start_date."'
							AND camp_resp_datetime <='".$end_date."'
							AND camp_action = 'act'
							".$condition."
					GROUP BY dt,hr order by hr";
			
		
					
					
		}
		elseif($display == 'churn')
		{
			$sql="
					SELECT 
						COUNT(clickid) act, DATE(camp_resp_datetime) dt, HOUR(camp_resp_datetime) hr
					FROM
						".strtolower($logdb).".campaign_response_tbl
							LEFT JOIN
						".strtolower($logdb).".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
					WHERE
						camp_resp_datetime >= '".$start_date."'
							AND camp_resp_datetime <='".$end_date."'
							AND camp_action = 'dct'
							".$condition."
					GROUP BY dt,hr order by hr";
			
		
		}
		elseif($display == 'cb')
		{
			$sql="
				SELECT 
					COUNT(clickid) act,
						DATE(camp_resp_datetime) dt,
						HOUR(camp_resp_datetime) hr
				FROM
					".strtolower($logdb).".campaign_response_tbl
				LEFT JOIN ".strtolower($logdb).".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						".$condition."
				GROUP BY dt, hr order by hr";
		}
		else
		{
			exit;
			$sql="
				SELECT 
					COUNT(userlog_tbl.clickid) act,
					DATE(userlog_datetime) dt,
					HOUR(userlog_datetime) hr,
					'other' advname
				FROM
					".$logdb.".userlog_tbl
						LEFT JOIN
					".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = userlog_tbl.advertiser_id
				WHERE
					userlog_datetime >= '".$start_date."'
						AND userlog_datetime <= '".$end_date."'
						".$condition."
				GROUP BY dt , hr,advname;
				";
				
			
		}
		
			$res=$conn->query($sql);
			
					$cnt = 0;
					$prevdate = "";
					$advname = [];
					$arrdt = [];
					$act = array();
					while($row=$res->fetch())
					{	
						if($prevdate == "")
							$prevdate = $row['dt'];
						
						if($prevdate != $row['dt'])
						{
							$dt[$prevdate]= $act;		
							$act = array();
							$prevdate = $row['dt'];
						}
						
						
							$act[$row['hr']]= $row['act'];	
						
						
						if(!in_array($row['hr'], $advname)) 
							$advname[] = $row['hr'];

						if(!in_array($row['dt'], $arrdt)) 
							$arrdt[] = $row['dt'];		
						
					}
					$dt[$prevdate]= $act;
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
                    <h2>Trend Report</h2>
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
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Country
							<select name="country" class="form-control select2_single" id="country">
								<option>Select</option>
								<?php 
								$sql_country="select distinct country_name,operator_tbl.country_id from ".$commondb.".country_tbl inner join ".$commondb.".operator_tbl on country_tbl.country_id = operator_tbl.country_id ;";
								$res_country=$conn->query($sql_country);
								while($row_country=$res_country->fetch())
								{
									if($row_country['country_id'] == $country)
									{
										$selected="selected";
									}
									else
									{
										$selected= "";
									}
								?>
								<option value="<?php echo $row_country['country_id'] ?>" <?php  echo $selected; ?> ><?php echo $row_country['country_name'] ?></option>
								<?php
								}
								?>
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
							<select name="pubadid" class="form-control select2_single" >
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
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
				
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
						<select name="display" class="form-control" id="pubad">
							<option value="clicks" <?php if($display=='clicks'){$selected='selected';}else{$selected='';} echo $selected; ?>>Clicks</option>
							<option value="activation" <?php if($display=='activation'){$selected='selected';}else{$selected='';} echo $selected; ?> >Activation</option>
							<option value="churn" <?php if($display=='churn'){$selected='selected';}else{$selected='';} echo $selected; ?>>Churn</option>
							
							<option value="cr" <?php if($display=='cr'){$selected='selected';}else{$selected='';} echo $selected; ?>>CR</option>
							<option value="cb" <?php if($display=='cb'){$selected='selected';}else{$selected='';} echo $selected; ?>>CB</option>
							
						</select>
						</div>
					</div>
						
						
						
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
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
										
										<?php
										foreach($advname as $key=>$val)
										{
											?>
											<td><?php echo $val; ?></td>
											<?php
										}
										?>
										<td><strong>Total</strong></td>
											
									</tr>
								</thead>


								<tbody>
									
																
									<?php  foreach($dt as $key=>$val) { ?>
										<tr>

											<td><?php echo $key; ?></td>
											<?php $sum=0; foreach($advname as $adkey=>$adval) { 
											if(array_key_exists($adval, $val))
											{
											?>

											<td><?php if($type == 'Aggr CR') {echo $sum=$sum+$a; } else{echo $a=$val[$adval]; $sum=$sum+$a; }  ?></td>

											<?php 
											}
											else
											{
											?>
											<td><?php echo $a=0; $sum=$sum+$a; ?></td>
											<?php

											}
											}?>
											<td><?php if($type == 'CR') { echo number_format($sum/$num,2) ; } else { echo $sum;}  ?></td>
										</tr>

									<?php } ?>
																
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