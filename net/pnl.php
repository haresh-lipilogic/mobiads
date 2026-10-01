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
	$commondb= "commondb";
	$count=1;


	
	$type=strtolower($_POST['type']);
	$product=strtolower($_POST['product']);
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
	
	
	
	
	
	
	 $select="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  isactive=1 ;
	";
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res= $conn->query($select);
	$num=$res->rowCount();  
	
	
	 $select_operator="
	SELECT 
		operator_id,country_name, operator_tbl.country_id,operator
	FROM
		".$commondb.".country_tbl
			INNER JOIN
    ".$commondb.".operator_tbl ON country_tbl.country_id = operator_tbl.country_id where  isactive=1 ;
	";
	
	//77,11,90,128,104,171,163,182,111,118,53
	$res_operator= $conn->query($select_operator);
	$num=$res_operator->rowCount();  
	//$country[]=array();

 	
	
	

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
								while($row=$res->fetch())
								{ ?>
									<td  ><?php echo ucfirst($row['operator']); ?></td>
								<?php
								}
								?>
								</tr>
								</thead>
								
								<tbody>
								<tr>
								<?php
								while($row_operator=$res_operator->fetch())
								{ $operator=$row_operator['operator'];
							
										include("includes/db.php");
										
										$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb."'";
												$res_db=$conn->query($db);
												$row_db=$res_db->rowCount(); 
												if($row_db > 0)
												{
						$sql_pnl="
								SELECT 
									total2, total1, CASE
                WHEN total2 - total1 IS NULL THEN 0
                ELSE total2 - total1
            END pnl
								FROM
									(SELECT 
										total2,
											CASE
												WHEN total1 IS NULL THEN 0
												ELSE total1
											END total1,
											CASE
												WHEN total2 - total1 IS NULL THEN 0
												ELSE total2 - total1
											END pnl
									FROM
										(SELECT 
										ROUND(SUM(payout_tbl.payout), 2) total1
									FROM
										".$logdb.".payout_tbl
									INNER JOIN ".$logdb.".advertiser_response_tbl ON payout_tbl.clickid = advertiser_response_tbl.clickid
									INNER JOIN ".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = payout_tbl.advertiser_id
									WHERE
										ad_resp_datetime >= '".$startdate."'
											AND ad_resp_datetime <= '".$enddate."'
											AND advertiser_response != 'stop') a, (SELECT 
										ROUND(SUM(payout_tbl.camp_payout), 2) total2
									FROM
										".$logdb.".payout_tbl
									INNER JOIN ".$logdb.".advertiser_response_tbl ON payout_tbl.clickid = advertiser_response_tbl.clickid
									INNER JOIN ".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = payout_tbl.campaign_id
									WHERE
										ad_resp_datetime >= '".$startdate."'
											AND ad_resp_datetime <= '".$enddate."') b) a;"; 
											$res_pnl=$conn->query($sql_pnl);
											$row_pnl=$res_pnl->fetch();
											$pnl=$row_pnl['pnl'];
												}
												else{
												$pnl = 0;
												}
									
									?>
									<td ><?php  if ($pnl > 0) { echo "<h5 style='color:green;font-weight:bold;'>".$pnl."</h5>"; $sum=$sum+$pnl;} elseif ($pnl == 0) { echo "<h5 style='font-weight:bold;'>".$pnl."</h5>";  $sum=$sum+$pnl;}else {   echo "<h5 style='color:red;font-weight:bold;'>".$pnl."</h5>";  $sum=$sum+$pnl;} ?></td>
									
									<?php
								
								}
								?>
									
								</tr>
								</tbody>
								<tbody>
							
							</tbody>
							
								
								
						</table>
						
						
					  </div>
					  <h4><strong>Total Earnings: <?php echo $sum; ?> </strong></h4>
				
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