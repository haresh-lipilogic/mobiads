<?php
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$type='';
$country='';
$display='';
$count=0;
$cc=0;
$hour=''; 
if(isset($_POST['submit']))
{
	
	$count=1;

	$operator=strtolower($_POST['operator']);
	$operatorid=strtolower($_POST['operator']); 
	$product="glamour";
	$start_date=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00"; 
	$end_date=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
	
	$display=$_POST['display'];
	
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
		
	
	if($display == 'activation')
	{
		
		$sql="
		SELECT 
    COUNT(*) c,
    DATE(ad_resp_datetime) dt,
    campaign_tbl.campaign_title campaign,
    advertiser_tbl.advertiser_name publisher
FROM
    ".$logdb.".advertiser_response_tbl
        INNER JOIN
    ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
        INNER JOIN
    ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
WHERE
    ad_resp_datetime >= '".$start_date."'
	and ad_resp_datetime <= '".$end_date."'
GROUP BY dt , advertiser_response_tbl.campaign_id , advertiser_response_tbl.advertiser_id;";
$res=$conn->query($sql);
	}
	else
	{
		$sql="
		SELECT 
    COUNT(*) c,
    DATE(ad_resp_datetime) dt,
    campaign_tbl.campaign_title campaign,
    advertiser_tbl.advertiser_name publisher
FROM
    ".$logdb.".advertiser_response_tbl
        INNER JOIN
    ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
        INNER JOIN
    ".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
WHERE
     ad_resp_datetime >= '".$start_date."'
	and ad_resp_datetime <= '".$end_date."'
	and advertiser_response != 'stop'
GROUP BY dt , advertiser_response_tbl.campaign_id , advertiser_response_tbl.advertiser_id;";
$res=$conn->query($sql);
		
	}
//echo $sql; exit;

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
						
						
						
						
						
						
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>
					
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Display
						<select name="display" class="form-control">
							
							<option value="activation" <?php if($display=='activation'){$selected='selected';}else{$selected='';} echo $selected; ?> >Activation</option>
							<option value="cbs" <?php if($display=='cbs'){$selected='selected';}else{$selected='';} echo $selected; ?>>CBS</option>
							
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
										
										<td><strong>Campaign</strong></td>
										<td><strong>Publisher</strong></td>
										<td><strong>Activation</strong></td>
											
									</tr>
								</thead>


								<tbody>
									
																
									
									<?php  
									$sum='';
									while($row=$res->fetch())
									{?>
									
										<tr>

											<td><?php echo $row['dt']; ?></td>
											<td><?php echo $row['campaign']; ?></td>
											<td><?php echo $row['publisher']; ?></td>
											<td><?php echo $c=$row['c']; $sum=$sum+$c; ?></td>
											
											
										</tr>

									<?php } ?>
																
								</tbody>
							
							<tbody>
									
																
									
									
										<tr>

											<td></td>
											<td></td>
											<td></td>
											<td><?php echo $sum; ?></td>
											
											
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


<script type="text/javascript">
$(document).ready(function(){

    $("#operator").change(function(){
		
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