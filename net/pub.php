<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$count=0;
$cc=0;
if(isset($_POST['submit']))
{
$count=1;

	$operator=strtolower($_POST['operator']);
	$operatorid=strtolower($_POST['operator']); 
	$product=strtolower($_POST['product']);
	$type=$_POST['type'];
	$start_date=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00"; 
	$end_date=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	$id=$_POST['pubadid'];
	$country =$_POST['country'];
	
	
	
	$sql_operator="select * from commondb.operator_tbl where operator_id = '".$operator."'";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	$operator=$row_operator['operator'];
	 $sql_operator1="select distinct operator,operator_id from commondb.operator_tbl where country_id = $country ";  
	$res_operator1=$conn->query($sql_operator1);
	$commondb="commondb";
	
	
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
	
	
	if($type == 'Advertiser' || $type == 'advertiser')
	{
		
		
		$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
		$res1=$conn->query($sql1);
		
		$sql="
			SELECT 
				COUNT(DISTINCT act_tbl1.clickid) act,
				COUNT(DISTINCT dct_tbl1.clickid) dct,
				act_tbl1.dt dt,
				CASE
					WHEN act_tbl1.campaign_title IS NULL THEN 'OTHER'
					ELSE act_tbl1.campaign_title
				END title,
				act_tbl1.pubid
			FROM
				(SELECT 
					clickid,
						DATE(camp_resp_datetime) dt,
						campaign_title,
						campaign_response_tbl.pubid
				FROM
					".strtolower($logdb).".campaign_response_tbl
				LEFT JOIN ".strtolower($logdb).".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						AND camp_action = 'act'
						".$condition.") act_tbl1
					LEFT JOIN
				(SELECT 
					clickid,
						DATE(camp_resp_datetime) dt,
						campaign_title,
						campaign_response_tbl.pubid
				FROM
					".strtolower($logdb).".campaign_response_tbl
				LEFT JOIN ".strtolower($logdb).".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime <= '".$end_date."'
						AND camp_action = 'dct'
						".$condition.") dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.campaign_title = dct_tbl1.campaign_title
					AND act_tbl1.pubid = dct_tbl1.pubid
			GROUP BY act_tbl1.dt , act_tbl1.campaign_title , act_tbl1.pubid

	 "; 
	}
	else
	{
		
		$sql1="select advertiser_name name , advertiser_id id from ".$commondb.".advertiser_tbl "; 
		$res1=$conn->query($sql1);
		
		
			
			$sql="
				SELECT 
						COUNT(DISTINCT act_tbl1.clickid) act,
						COUNT(DISTINCT dct_tbl1.clickid) dct,
						act_tbl1.dt dt,
						CASE WHEN 
						act_tbl1.advertiser_name is null THEN 'OTHER'
						ELSE
						act_tbl1.advertiser_name 
						END title,
						act_tbl1.pubid pubid
				FROM
					(SELECT 
					clickid,
						DATE(ad_resp_datetime) dt,
						advertiser_name,
						advertiser_response_tbl.pubid
				FROM
					".strtolower($logdb).".advertiser_response_tbl
				LEFT JOIN ".strtolower($commondb).".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$start_date."'
						AND ad_resp_datetime <= '".$end_date."'
						AND action = 'act'
						".$condition.") act_tbl1
				left JOIN (SELECT 
					clickid,
						DATE(ad_resp_datetime) dt,
						advertiser_name,
						advertiser_response_tbl.pubid
				FROM
					".strtolower($logdb).".advertiser_response_tbl
				LEFT JOIN ".strtolower($commondb).".advertiser_tbl ON advertiser_tbl.advertiser_id = advertiser_response_tbl.advertiser_id
				WHERE
					ad_resp_datetime >= '".$start_date."'
						AND ad_resp_datetime <= '".$end_date."'
						AND action = 'dct'
						".$condition.") dct_tbl1 ON act_tbl1.clickid = dct_tbl1.clickid
					AND act_tbl1.dt = dct_tbl1.dt
					AND act_tbl1.advertiser_name = dct_tbl1.advertiser_name
					AND act_tbl1.pubid = dct_tbl1.pubid
				GROUP BY act_tbl1.dt , act_tbl1.advertiser_name , act_tbl1.pubid"; 
	}
	
	
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
                    <h2>PubID wise Activation & Deactivation</h2>
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
								<?php 
								$sql_country="select distinct country_name,operator_tbl.country_id from commondb.country_tbl inner join commondb.operator_tbl on country_tbl.country_id = operator_tbl.country_id ;";
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
						<select name="type" class="form-control" id="pubad">
							<option>Select Publisher / Advertiser</option>
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

						
						
						
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                    

                    </form>
                  </div>
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
									<td><strong>Campaign Title</strong></td>
									<td><strong>PubID</strong></td>
									<td><strong>Activation</strong></td>
									<td><strong>Deactivation</strong></td>
									<td><strong>Churn %</strong></td>
									
									
									
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								$act_sum='';
								
								$dct_sum='';
								
								
								
									while($row=$res->fetch())
									{
								?>
									<tr>
										<td><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td><?php echo $row['title'];  ?></td>
										<td><?php echo $row['pubid'];  ?></td>
										
										<td><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act'];?></td>
										<td><?php echo number_format($row['dct']); $dct_sum=$dct_sum+$row['dct'];?></td>
										<td><?php echo number_format($row['dct']/$row['act']*100)." %";?></td>
										
										
									</tr>
								
								
								
								<?php
									}
								
								
								?>
								
								
								
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo number_format($dct_sum); ?></td>
									<td><?php echo number_format($dct_sum/$act_sum*100)." %";?></td>
									
									
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