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
								
							</select>
						</div>
						
						
						
						
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
									<td><strong>SameDay ACT</strong></td>
									<td><strong>SPO</strong></td>
									<td><strong>SDC</strong></td>
									<td><strong>Churn</strong></td>
									<td><strong>Churn%</strong></td>
									<td><strong>Callback</strong></td>
									<td><strong>Callback CR%</strong></td>
									<td><strong>Callback%</strong></td>
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$req_sum='';
								$resp_sum='';
								$sameday_sum='';
								$samedaydct_sum='';
								$act_sum='';
								$actamnt_sum='';
								$dct_sum='';
								$cbr_sum='';
								$dctamnt_sum='';
								
								
									while($row=$res->fetch())
									{
										
								?>
									<tr>
										<td  style="width:10%"><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td style="width:10%"><?php echo $row['title']; ?></td>
										<td style="width:10%"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>
										<td style="width:10%"><?php echo number_format(($row['act']/$row['clicks'])*100,2)."%";  ?></td>
										<td style="width:10%"><?php echo number_format($row['sameday']); $sameday_sum=$sameday_sum+$row['sameday']; ?></td>
										<td style="width:10%"><?php echo number_format($row['act']-$row['sameday']); $act_sum=$act_sum+($row['act']-$row['sameday']); ?></td>
										<td style="width:10%"><?php echo number_format($row['samedaydct']); $samedaydct_sum=$samedaydct_sum+$row['samedaydct']; ?></td>
										<td style="width:10%"><?php echo number_format($row['dct']-$row['samedaydct']); $dct_sum=$dct_sum+($row['dct']-$row['samedaydct']); ?></td>
									
										<td  style="width:10%"><?php  $a=number_format(($row['samedaydct']/$row['sameday'])*100,2)."%"; if($a >15){echo "<span style='color:white;font-weight:bold;background:red;padding:5px;'>".$a."</span>";} else{echo "<span style='color:white;font-weight:bold;background:green;padding:5px;'>".$a."</span>";}  ?></td>
										<td style="width:10%"><?php echo number_format($row['cbr']); $cbr_sum=$cbr_sum+$row['cbr']; ?></td>
										<td style="width:10%"><?php echo number_format(($row['cbr']/$row['clicks'])*100,2)."%";  ?></td>
										<td style="width:10%"><?php echo number_format(($row['cbr']/$row['act'])*100,2)."%";  ?></td>
										
										
										
									</tr>
								
								
								
								<?php
									}
								?>
								
								<tr>
									<td>Total</td>
									<td></td>
									
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format(($sameday_sum/$click_sum)*100,2)."%";  ?></td>
									<td><?php echo number_format($sameday_sum); ?></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td><?php echo number_format($samedaydct_sum); ?></td>
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