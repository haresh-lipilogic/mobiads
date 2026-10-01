<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);

$commondb="commondb";

$operator='';
$product='';

$count=0;
$cc=0;

$commondb="commondb";
	$sql="select * from commondb.operator_tbl ";
	$res=$conn->query($sql);
	
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
                    <h2>Operator Blocking</h2>
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
					
						<div class="col-md-6 col-sm-2 col-xs-12 form-group has-feedback"> 
						<table border =1>
						<tr>
						
						<?php
						$i=1;
						while($row=$res->fetch())
						{
							if($row['isactive'] ==1)
							{
								$checked="checked";
							}
							else
							{
								$checked="";
							}
							if($i % 4 == 0 )
							{
								?>
							<input type='checkbox'  class="myCheckbox" value="<?php echo $row['operator_id'];  ?>" <?php echo $checked; ?>><?php echo $row['operator']; ?> </br>
								<?php
							}
							else
							{
								?>
								<input type='checkbox'  class="myCheckbox" value="<?php echo $row['operator_id']; ?>"  <?php echo $checked; ?>>  <?php echo $row['operator']; ?>
								<?php
								
							}
							$i++;
						
							
							
						}
						?>	
						
						</tr>
						</table>
						
						
						
						
						
						
                      

                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			 <?php
	   include("includes/footer.php");
		?>
		
			
			<script type="text/javascript">
  
$(document).ready(function() {
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			
			
            var val = $(this).val();
         
            
			
			$.ajax({
            type: "GET",
            url: "ajax/update_operator.php?c="+'check'+"&val="+val       
			});
			
			 
        }
        else {
			
			var val = $(this).val();
         
            var operator = $(".operator1").val();
			var product = $(".product1").val();

			$.ajax({
            type: "GET",
            url: "ajax/update_operator.php?c="+'uncheck'+"&val="+val  
			});
           
        }
    });
});

</script> 	