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

	$operator=$_POST['operator'];
	$product=$_POST['product'];
	

	
	
	if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db";	
		}
		elseif(strtolower($operator) == 'airtel' || strtolower($operator) == 'idea')
		{
			$logdb=$operator."_".$product."db_0617";	
		}
		else
		{
			$logdb=$operator."_".$product."db";	
		}
	
	$sql_advertiser="select * from ".strtolower($logdb).".advertiser_tbl "; 
	$res_advertiser=$conn->query($sql_advertiser);
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
                    <h2>Publisher Blocking</h2>
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
						<select name="product" class="form-control" id="product">
							<option>Select</option>
							<option value="Glamour" <?php if($product=='Glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="Games" <?php if($product=='Games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option value="">Select Operator</option>

							<option value="Vodafone" <?php if($operator=='Vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="Airtel" <?php if($operator=='Airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="Idea" <?php if($operator=='Idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
						</select>
						</div>
						
						
						
						
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
									<td><strong>Totally Stop</strong></td>	
									<td><strong>SpillOver Callback Stop(%)</strong></td>
									<td><strong>Activation Callback Stop(%)</strong></td>
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_advertiser=$res_advertiser->fetch())
									{
										if($row_advertiser['advertiser_isactive'] != '1')
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}	
										
								?>
									<tr>
										<td><?php echo $row_advertiser['advertiser_id']; ?></td>
										<td><?php echo $row_advertiser['advertiser_name']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row_advertiser['advertiser_id'];?>" <?php echo $checked; ?>  ></td>
										<td><input type="text" style="width:60px;padding:3px;" value="<?php echo $row_advertiser['spo_stopcallback']; ?>" onblur="stop_callback(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>','spo')" placeholder="%"></td>
										
										<td><input type="text" style="width:60px;padding:3px;" value="<?php echo $row_advertiser['act_stopcallback']; ?>" onblur="stop_callback(this.value,<?php echo $row_advertiser['advertiser_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>','act')" placeholder="%"></td>
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

$(document).ready(function() {
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
           
            var operator = $(".operator1").val();
			var product = $(".product1").val();
			
			$.ajax({
            type: "GET",
            url: "ajax/advertiser_blocking.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			});
			
			 
        }
        else {
			
			var val = $(this).val();
         
            var operator = $(".operator1").val();
			var product = $(".product1").val();

			$.ajax({
            type: "GET",
            url: "ajax/advertiser_blocking.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val  
			});
           
        }
    });
});

</script> 		





<script type="text/javascript">

function stop_callback(callbackstop_perc,advertiserid,operator,product,type)
{
	
		
		$.ajax({
            type: "GET",
            url: "ajax/stop_callback.php?operator="+operator+"&product="+product+"&callbackstop_perc="+callbackstop_perc+"&advertiserid="+advertiserid+"&type="+type       
			});			
			
			
}

</script> 		



