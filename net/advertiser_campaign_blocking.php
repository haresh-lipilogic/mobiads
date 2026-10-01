<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);



$operator='';
$product='';

$count=0;
$cc=0;
if(isset($_POST['submit']))
{
	$commondb="commondb"; 
	$operator=$_POST['operator'];
	$product=strtolower($_POST['product']);
	$advid=$_POST['advid']; 

	
	
	include("includes/db.php");
	
	$sql_op="select * from ".strtolower($commondb).".operator_tbl where operator = '".$operator."'";
	$res_op=$conn->query($sql_op);
	$row_op=$res_op->fetch();
	$op= $row_op['operator_id'];
	
	$sql1="select campaign_title name , campaign_id id from ".$logdb.".campaign_tbl where campaign_operator = '".$operator."' ";  
	$res1=$conn->query($sql1);
	
	$sql_campaign="select * from ".strtolower($commondb).".advertiser_tbl where operator = '".$op."'  ";  
	$res_campaign=$conn->query($sql_campaign);
	
	$count=1;

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
                    <h2>Campaign Wise Publisher Blocking</h2>
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
					
						<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> Product
						<select name="product" class="form-control select2_single" id="product">
							
							<option value="glamour" <?php if($product=='glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="games" <?php if($product=='games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							<option value="music" <?php if($product=='music'){$selected='selected';}else{$selected='';} echo $selected; ?>>Music</option>
							
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control select2_single" id="operator">
						<?php 	
						 $sql_op="select * from commondb.operator_tbl";
						$res_op=$conn->query($sql_op);
						while($row_op=$res_op->fetch())
						{
							if($row_op['operator'] == $operator)
							{
								$selected = "selected";
							}
							else
							{
									$selected = "";
							}
							?>
							<option value="<?php echo $row_op['operator']; ?>" <?php  echo $selected; ?> ><?php echo $row_op['operator']; ?></option>
							<?php
						}
						?>
							
							
						</select>
						</div>
						
						<span id="response">
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher Name
						<?php
						if($count == 1)
						{
						?>
							<select name="advid" class="form-control select2_single" >
								<option value="all" >All</option>
								<?php
								while($row1=$res1->fetch())
								{
									if($row1['id']== $advid)
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
						
						
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
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
					<form method="post">
			
					  <div class="x_content">
					  
					  <input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
					  <input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
					 
						
						<table id="" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Campaign ID</strong></td>
									<td><strong>Title</td>
									<td><strong>Block</strong></td>	
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_campaign=$res_campaign->fetch())
									{
										$sql_block="select * from ".strtolower($logdb).".advertiser_blocking_tbl where advertiser_id ='".$row_campaign['advertiser_id']."'  and campaign_id = '".$advid."'"; 
										$res_block=$conn->query($sql_block);
										$row_block=$res_block->rowCount();
										if($row_block >= '1' || $row_block >= 1)
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}	
										
								?>
									<tr>
										<td><?php echo $row_campaign['advertiser_id']; ?></td>
										<td><?php echo $row_campaign['advertiser_name']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row_campaign['advertiser_id'];?>" 
										onclick="stop_campaign(this.value,'<?php echo $operator; ?>','<?php echo $product; ?>','<?php echo $advid; ?>')"
										<?php echo $checked; ?>  ></td>	
									</tr>
								
								
								
								<?php
									}
								
								?>
																
							</tbody>
		
						</table>
					  </div>
					
				</form>
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
		
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product     
			
        }).done(function(data){
            $("#response").html(data);
			 
        });
    });
});

</script>			

<script type="text/javascript">

function stop_campaign(campaignid,operator,product,advertiserid)
{

	
	 $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			

			$.ajax({
            type: "GET",
            url: "ajax/stop_campaign.php?operator="+operator+"&product="+product+"&c="+'check'+"&campaignid="+advertiserid+"&advertiserid="+campaignid     
			});
			
			 
        }
        else {

			$.ajax({
            type: "GET",
             url: "ajax/stop_campaign.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&campaignid="+advertiserid+"&advertiserid="+campaignid
			});
           
        }
    });		
			
			
}

</script> 		

