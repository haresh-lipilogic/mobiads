
<?php
include("includes/check_session.php");
include("includes/connection.php");
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
	$commondb='commondb';

	$operator=strtolower($_POST['operator']);
	$product=strtolower($_POST['product']);
	$browser=$_POST['browser'];
	 
	
	
	
	include("includes/db.php");
	

	
	$update_counter="update ".$logdb.".counter_tbl set counter_no=0 "; 
	$res_counter=$conn->query($update_counter);

	

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
						
						
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      

                   
                  </div>
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



