
<?php
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);


$start_date='';
$end_date='';
$operator='';
$product='';
$browser='';
$count=0;
$cc=0;
if(isset($_POST['submit']))
{
	

	$operator=strtolower($_POST['operator']);
	$product ="glamour";
	$browser=$_POST['browser'];
	 
	
	
	$os=$_POST['os'];

	$query='';
	if($browser != ''  && $browser != 'all' )
	{
		$query.=" and campaign_browser like '%".$browser."%' ";
	}
	else
	{
		$query.="";
	}
	
	if($os != '' && $os != 'all' )
	{
		$query.=" and campaign_os like '%".$os."%' ";
	}
	else
	{
		$query.="";
	}
	
	include("includes/db.php");
	

	$sql_campaign="select * from ".$logdb.".campaign_tbl where campaign_operator='".$operator."' ".$query." "; 
	$res_campaign=$conn->query($sql_campaign);

	$count=1;
	
	
	$sql1="select * from ".strtolower($commondb).".operator_tbl where operator= '".$operator."'"; 
$res1=$conn->query($sql1);
$row1=$res1->fetch();
	
	

	

}



?>


<style>
.calendar
{
	display:none !important; 
}
</style

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
                    <h2>Campaign Blocking</h2>
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
					
						
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Operator
						
							
						<select name="operator" class="form-control select2_single" id="operator">
						<?php 	
						 $sql_op="select * from ".$commondb.".operator_tbl";
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
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> Browser
						<select name="browser" class="form-control select2_single" id="operator">
							
							<option value="all" <?php if($browser=='all'){$selected='selected';}else{$selected='';} echo $selected; ?> >All</option>
							<option value="chrome" <?php if($browser=='chrome'){$selected='selected';}else{$selected='';} echo $selected; ?> >Chrome</option>
							<option value="opera" <?php if($browser=='opera'){$selected='selected';}else{$selected='';} echo $selected; ?>>Opera</option>
							<option value="ucb" <?php if($browser=='ucb'){$selected='selected';}else{$selected='';} echo $selected; ?>>UC Browser</option>
							<option value="ucb" <?php if($browser=='other'){$selected='selected';}else{$selected='';} echo $selected; ?>>Other</option>
						</select>
						</div>
						
						<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"> OS
						<select name="os" class="form-control select2_single" id="operator">
							
							<option value="all" <?php if($os=='all'){$selected='selected';}else{$selected='';} echo $selected; ?> >All</option>
							<option value="android" <?php if($os=='android'){$selected='selected';}else{$selected='';} echo $selected; ?> >Android</option>
							<option value="iphone" <?php if($os=='iphone'){$selected='selected';}else{$selected='';} echo $selected; ?>>Iphone</option>
							<option value="windows" <?php if($os=='windows'){$selected='selected';}else{$selected='';} echo $selected; ?>>Windows</option>
							<option value="linux" <?php if($os=='linux'){$selected='selected';}else{$selected='';} echo $selected; ?>>Linux</option>
							<option value="other" <?php if($os=='other'){$selected='selected';}else{$selected='';} echo $selected; ?>>Other</option>
						</select>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                   
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
					
			
					  <div class="x_content">
					  
					  <input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
					  <input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
					 
						
						<table id="" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td width="5%"><strong>Camp ID</strong></td>
									<td width="10%"><strong>Title</strong></td>
									<td width="5%"><strong>Block</strong></td>	
									<td><strong>URL</strong> <input type="button" id="button" value="disable/enable" class="btn btn-danger"></td>	
									<td width="5%"><strong>Payout</strong></td>							
									<td width="21%"><strong>Time</strong></td>							
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_campaign=$res_campaign->fetch())
									{
										if($row_campaign['campaign_live'] != '1')
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}	
								
								?>
									<tr>
										<td><?php echo $row_campaign['campaign_id']; ?></td>
										<td><?php echo $row_campaign['campaign_title']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row_campaign['campaign_id'];?>" <?php echo $checked; ?>  ></td>
										<td>
											
											  
											  <input type="text" name ="camp_url" onblur="campaign_url(<?php echo "'".$product."','".$operator."','".$row_campaign['campaign_id']."'"; ?>, this.value)" value="<?php echo $row_campaign['campaign_url']; ?>" class="form-control pull-left url" disabled="disabled" >
											
										</td>
										<td>
											
											  
											  <input type="text" name ="camp_payout" onblur="campaign_payout(<?php echo "'".$product."','".$operator."','".$row_campaign['campaign_id']."'"; ?>, this.value)" value="<?php echo $row_campaign['campaign_price']; ?>" class="form-control pull-left" >
											
										</td>	
										
										<td>
											
											  
											  <input type="text" name ="camp_time" onblur="campaign_time(<?php echo "'".$product."','".$operator."','".$row_campaign['campaign_id']."'"; ?>, this.value)" value="<?php echo $row_campaign['campaign_startdatetime']."/".$row_campaign['campaign_enddatetime']; ?>" class="form-control pull-left" placeholder='00:00:00 - 23:59:59'>
											
										</td>											
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




</script> 	
	


<script type="text/javascript">
  
$(document).ready(function() {
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
           
            var operator = $(".operator1").val();
			var product = $(".product1").val();
			
			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'check'+"&val="+val       
			});
			
			 
        }
        else {
			
			var val = $(this).val();
         
            var operator = $(".operator1").val();
			var product = $(".product1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&val="+val  
			});
           
        }
    });
});

</script> 		



<script type="text/javascript">

function campaign_time(product,operator,campaign_id,datetime)
{
	
		
		$.ajax({
            type: "GET",
            url: "ajax/update_time.php?operator="+operator+"&product="+product+"&campaign_id="+campaign_id+"&datetime="+datetime      
			});			
			
			
}

</script> 		


<script type="text/javascript">

function campaign_payout(product,operator,campaign_id,payout)
{
	
		
		$.ajax({
            type: "GET",
            url: "ajax/update_payout.php?operator="+operator+"&product="+product+"&campaign_id="+campaign_id+"&payout="+payout      
			});			
			
			
}

</script> 	


<script type="text/javascript">

function campaign_url(product,operator,campaign_id,url)
{
	var a= encodeURIComponent(url);
		
		$.ajax({
            type: "GET",
            url: "ajax/update_url.php?operator="+operator+"&product="+product+"&campaign_id="+campaign_id+"&url="+a      
			});			
			
			
}




$("#button").click(function() {
  $(".url").attr('disabled', !$(".url").attr('disabled'));
});

</script> 	



