<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");



$operator='';
$type='';
$count=0;


//country fetch karva

$sql_country="select * from ".$commondb.".country_tbl";
$res_country=$conn->query($sql_country);


if(isset($_POST['submit']))
{
	$country=$_POST['country'];
	$category="glamour"; 
	$operator=$_POST['operator'];
	$opcode=$_POST['opcode'];
	
	

	
	
			
	include("includes/db.php");
			
				$logdb=strtolower($logdb);
			
				
				$insert= "insert into ".$commondb.".operator_tbl (operator,operator_code,country_id,isactive)
				values ('".$operator."','".$opcode."','".$country."','0')"; 
				$res_insert=$conn->query($insert);
				
			
				
	
	
	
	echo "<script>window.location='add_operator.php';</script>";


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
                    <h2>Add Operator</h2>
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
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong> Country</strong>
									<select required name="country"  class="form-control select2_single" id="country" >
										<option value="">Select Country</option>
										<?php 
										while($row_country=$res_country->fetch())
										{
										?>
										<option value="<?php echo $row_country['country_id'] ?>" ><?php echo $row_country['country_name'] ?></option>
										<?php
										}
										?>
										
									</select>
								</div>
							</div>
							
							
							
							
							<div class="x_content">	
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback" > <strong>Operator Name</strong>
									<input type="text" class="form-control" name="operator" id="op" required>
									<span id="check1" class="help-block"></span>
								</div>
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Operator Code (2 random characters only)</strong>
									<input type="text" class="form-control" name="opcode" id="opcode" maxlength="2"  required>
									<span id="check" class="help-block"></span>
								</div>
							</div>						
						
						
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						  <button type="submit" name="submit" class="btn btn-success">Submit</button>
						</div>
                      
					</div>
                    </form>
                  </div>
                </div>
				
              
              </div>
            </div>
			
			<!-- /page content -->

       <?php
	   include("includes/footer.php");
		?>


<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#opcode').keyup(function() {
	var usercheck = $(this).val();
		    
			$.post("ajax/check.php", {user_name: usercheck, opcode : '1'} , function(data)
			{
			if (data.status == true)
			{
			$('#check').parent('div').removeClass('has-error').addClass('has-success');
			
			} else {
			$('#check').parent('div').removeClass('has-success').addClass('has-error');
			}
			$('#check').html(data.msg);
			},'json');
	});
});


$(document).ready(function(){
	$('#op').keyup(function() {
	var usercheck = $(this).val();
		    
			$.post("ajax/check.php", {user_name: usercheck, opcode : '2'} , function(data)
			{
			if (data.status == true)
			{
			$('#check1').parent('div').removeClass('has-error').addClass('has-success');
			
			} else {
			$('#check1').parent('div').removeClass('has-success').addClass('has-error');
			}
			$('#check1').html(data.msg);
			},'json');
	});
});
</script>