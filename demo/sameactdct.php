<?php
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$pubad='';
$count=0;
$cc=0;
if(isset($_POST['submit']))
{
$count=1;

	$operator=strtolower($_POST['operator']); 
	$product=strtolower($_POST['product']);
	$pubad=strtolower($_POST['pubad']);
	$pubadid=$_POST['pubadid']; 
	$start_date=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00"; 
	$end_date=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
		if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db_cpi";	
		}
		else
		{
			$logdb=$operator."_".$product."db_cpi";	
		}
	$logdb=strtolower($logdb);
		
	$sql_campaign="select * from ".$logdb.".campaign_tbl where campaign_operator='".$operator."' "; 
	$res_campaign=$conn->query($sql_campaign);
	
	if($pubad == 'publisher')
	{
		if($pubadid == 'all')
		{
			$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
			$res1=$conn->query($sql1);
			
			$selected1="selected"; 
			$sql="
			SELECT 
				a.dt1 dt, a.campaign_title title, a.clickid act, b.dct dct
			FROM
				(SELECT 
					DATE(camp_resp_datetime) dt1,
						COUNT(clickid) clickid,
						campaign_title,
						campaign_tbl.campaign_id
				FROM
					".$logdb.".campaign_response_tbl
				INNER JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_action = 'act'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
				GROUP BY dt1 , campaign_tbl.campaign_id) a
					LEFT JOIN
				(SELECT 
					DATE(camp_resp_datetime) dt2,
						COUNT(b.clickid) dct,
						campaign_title,
						campaign_tbl.campaign_id
				FROM
					(SELECT 
					clickid, DATE(camp_resp_datetime) dt3
				FROM
					".$logdb.".campaign_response_tbl
				WHERE
					camp_action = 'act'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."') b
				INNER JOIN ".$logdb.".campaign_response_tbl ON (b.clickid = campaign_response_tbl.clickid
					AND b.dt3 = DATE(campaign_response_tbl.camp_resp_datetime))
				INNER JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_action = 'dct'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
				GROUP BY dt2 , campaign_tbl.campaign_id) b ON a.campaign_id = b.campaign_id
					AND a.dt1 = b.dt2
			GROUP BY dt , a.campaign_id

		 "; 
		}
		else
		{
			
			$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
			$res1=$conn->query($sql1);
			
			$sql="
			SELECT 
				a.dt1 dt, a.campaign_title title, a.clickid act, b.dct dct
			FROM
				(SELECT 
					DATE(camp_resp_datetime) dt1,
						COUNT(clickid) clickid,
						campaign_title,
						campaign_tbl.campaign_id
				FROM
					".$logdb.".campaign_response_tbl
				INNER JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_action = 'act'
						AND campaign_tbl.campaign_id=".$pubadid."
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
				GROUP BY dt1 , campaign_tbl.campaign_id) a
					LEFT JOIN
				(SELECT 
					DATE(camp_resp_datetime) dt2,
						COUNT(b.clickid) dct,
						campaign_title,
						campaign_tbl.campaign_id
				FROM
					(SELECT 
					clickid, DATE(camp_resp_datetime) dt3
				FROM
					".$logdb.".campaign_response_tbl
				WHERE
					camp_action = 'act'
						
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."') b
				INNER JOIN ".$logdb.".campaign_response_tbl ON (b.clickid = campaign_response_tbl.clickid
					AND b.dt3 = DATE(campaign_response_tbl.camp_resp_datetime))
				INNER JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = campaign_response_tbl.campaign_id
				WHERE
					camp_action = 'dct'
						AND campaign_tbl.campaign_id=".$pubadid."
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
				GROUP BY dt2 , campaign_tbl.campaign_id) b ON a.campaign_id = b.campaign_id
					AND a.dt1 = b.dt2
			GROUP BY dt , a.campaign_id

		 "; 
		}
	}
	else
	{
		if($pubadid == 'all')
		{
			$sql1="select advertiser_name name , advertiser_id id from ".$logdb.".advertiser_tbl "; 
			$res1=$conn->query($sql1);
			
			$selected1="selected"; 
			$sql="
				SELECT 
					a.dt1 dt, a.name1 title, a.clickid act, b.dct dct
				FROM
					(SELECT 
						DATE(camp_resp_datetime) dt1,
							COUNT(clickid) clickid,
							advertiser_tbl.advertiser_name name1,
							advertiser_tbl.advertiser_id
					FROM
						".$logdb.".campaign_response_tbl
					INNER JOIN ".$logdb.".advertiser_tbl ON advertiser_tbl.advertiser_id = campaign_response_tbl.advertiser_id
					WHERE
						camp_action = 'act'
							AND camp_resp_datetime >= '".$start_date."'
							AND camp_resp_datetime < '".$end_date."'
					GROUP BY dt1 , advertiser_tbl.advertiser_id) a
						LEFT JOIN
					(SELECT 
						DATE(camp_resp_datetime) dt2,
							COUNT(b.clickid) dct,
							advertiser_tbl.advertiser_name,
							advertiser_tbl.advertiser_id
					FROM
						(SELECT 
						clickid, DATE(camp_resp_datetime) dt3
					FROM
						".$logdb.".campaign_response_tbl
					WHERE
						camp_action = 'act'
							AND camp_resp_datetime >= '".$start_date."'
							AND camp_resp_datetime < '".$end_date."') b
					INNER JOIN ".$logdb.".campaign_response_tbl ON (b.clickid = campaign_response_tbl.clickid
						AND b.dt3 = DATE(campaign_response_tbl.camp_resp_datetime))
					INNER JOIN ".$logdb.".advertiser_tbl ON advertiser_tbl.advertiser_id = campaign_response_tbl.advertiser_id
					WHERE
						camp_action = 'dct'
							AND camp_resp_datetime >= '".$start_date."'
							AND camp_resp_datetime < '".$end_date."'
					GROUP BY dt2 , advertiser_tbl.advertiser_id) b ON a.advertiser_id = b.advertiser_id
						AND a.dt1 = b.dt2
				GROUP BY dt , a.advertiser_id
		 "; 
		}
		else
		{
			
			$sql1="select advertiser_name name , advertiser_id id from ".$logdb.".advertiser_tbl "; 
			$res1=$conn->query($sql1);
			
			$sql="
			SELECT 
				a.dt1 dt, a.name1 title, a.clickid act, b.dct dct
			FROM
				(SELECT 
					DATE(camp_resp_datetime) dt1,
						COUNT(clickid) clickid,
						advertiser_tbl.advertiser_name name1,
						advertiser_tbl.advertiser_id
				FROM
					".$logdb.".campaign_response_tbl
				INNER JOIN ".$logdb.".advertiser_tbl ON advertiser_tbl.advertiser_id = campaign_response_tbl.advertiser_id
				WHERE
					camp_action = 'act'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
						AND advertiser_tbl.advertiser_id='".$pubadid."'
				GROUP BY dt1 , advertiser_tbl.advertiser_id) a
					LEFT JOIN
				(SELECT 
					DATE(camp_resp_datetime) dt2,
						COUNT(b.clickid) dct,
						advertiser_tbl.advertiser_name,
						advertiser_tbl.advertiser_id
				FROM
					(SELECT 
					clickid, DATE(camp_resp_datetime) dt3
				FROM
					".$logdb.".campaign_response_tbl
				WHERE
					camp_action = 'act'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
						AND advertiser_id='".$pubadid."') b
				INNER JOIN ".$logdb.".campaign_response_tbl ON (b.clickid = campaign_response_tbl.clickid
					AND b.dt3 = DATE(campaign_response_tbl.camp_resp_datetime))
				INNER JOIN ".$logdb.".advertiser_tbl ON advertiser_tbl.advertiser_id = campaign_response_tbl.advertiser_id
				WHERE
					camp_action = 'dct'
						AND camp_resp_datetime >= '".$start_date."'
						AND camp_resp_datetime < '".$end_date."'
						AND advertiser_tbl.advertiser_id='".$pubadid."'
				GROUP BY dt2 , advertiser_tbl.advertiser_id) b ON a.advertiser_id = b.advertiser_id
					AND a.dt1 = b.dt2
			GROUP BY dt , a.advertiser_id;


		 "; 
		}
	
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
                    <h2>Same-Day Activation & Deactivation <small></small></h2>
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
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control" id="product">
							<option>Select</option>
							<option value="Glamour" <?php if($product=='glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="Games" <?php if($product=='games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Select Operator</option>
							<option value="Vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser
						<select name="pubad" class="form-control" id="pubad">
							<option>Select Publisher / Advertiser</option>
							<option value="Publisher" <?php if($pubad=='publisher'){$selected='selected';}else{$selected='';} echo $selected; ?> >Publisher</option>
							<option value="Advertiser" <?php if($pubad=='advertiser'){$selected='selected';}else{$selected='';} echo $selected; ?>>Advertiser</option>
							
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
									if($row1['id']== $pubadid)
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