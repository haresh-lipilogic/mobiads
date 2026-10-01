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

	$operator=$_POST['operator'];
	$product=$_POST['product'];
	$browser=$_POST['browser'];
	$os=$_POST['os'];

	$advid=$_POST['advid']; 
	
	$campid=$_POST['campid']; 
	
	
	
	$commondb="commondb";
		$sql1="SELECT advertiser_name name , advertiser_id id from ".$commondb.".advertiser_tbl ";   
		$res1=$conn->query($sql1);
		
		
	
	if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db_0617";	
		}
		elseif(strtolower($operator) == 'airtel' || strtolower($operator) == 'idea')
		{
			$logdb=$operator."_".$product."db_0617";	
		}
		else
		{
			$logdb=$operator."_".$product."db";	
		}
	$logdb=strtolower($logdb);
		
	$sql_camp="select campaign_id id, campaign_title name from ".strtolower($logdb).".campaign_tbl  "; 
	$res_camp=$conn->query($sql_camp);
	
	$sql_pub="select * from ".strtolower($logdb).".pub_blocking_tbl inner join ".$commondb.".advertiser_tbl on pub_blocking_tbl.advertiser_id = advertiser_tbl.advertiser_id where pub_blocking_tbl.advertiser_id='".$advid."' order by pub_blocking_tbl.advertiser_id  ";  
	$res_pub=$conn->query($sql_pub);
	$count=1;
	
	
	$sql_pub_camp="select * from ".strtolower($logdb).".pub_camp_blocking_tbl";
	$res_pub_camp=$conn->query($sql_pub_camp);
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
                    <h2>PubID wise Blocking</h2>
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
						<select name="product" class="form-control" id="product">
							<option>Select</option>
							<option value="glamour" <?php if($product=='glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="games" <?php if($product=='games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							<option value="music" <?php if($product=='music'){$selected='selected';}else{$selected='';} echo $selected; ?>>Music</option>
							
						</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
						<select name="operator" class="form-control" id="operator">
							<option>Select Operator</option>
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="airtel" <?php if($operator=='airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							<option value="azercell" <?php if($operator=='azercell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azercell</option>
							<option value="backcell" <?php if($operator=='backcell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Backcell</option>
							<option value="narcell" <?php if($operator=='narcell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Narcell</option>
							<option value="kuwaitooredoo" <?php if($operator=='kuwaitooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Kuwaitooredoo</option>
							<option value="omanooredoo" <?php if($operator=='omanooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Omanooredoo</option>
						</select>
						</div>
						
					</div>
					<div class="x_content">
						
						
						
						<div class="col-md-6 col-sm-6 col-xs-6">
						 
						  <textarea name="pubid" class="form-control"> </textarea>
						</div>
					</div>	
					
					<div class="x_content">
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
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
					<form method="post">
			
					  <div class="x_content">
					  
					  <input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
					  <input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
					 
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Advertiser</strong></td>
									<td><strong>PubID</td>
									<td><strong>Total Block</strong></td>	
									<td><strong>Campaign wise Block</strong></td>
														
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_pub=$res_pub->fetch())
									{
										if($row_pub['pubid_isactive'] != '1')
										{
											$checked="checked";
										}
										else
										{
											$checked="";
										}

										$sql_pub_camp="select * from ".$logdb.".pub_camp_blocking_tbl where pub ='".$row_pub['pubid']."' "; 
										$res_pub_camp=$conn->query($sql_pub_camp);
										$row_pub_camp=$res_pub_camp->fetch();
										$num=$res_pub_camp->rowCount(); 
										
										if($num > 0)
										{
											$checked1="checked";								}
										else
										{
											$checked1="";
										}
										
										
										 
								?>
									<tr>
										<td><?php echo $row_pub['advertiser_name']; ?></td>
										<td><?php echo $row_pub['pubid']; ?></td>
										<td><input type="checkbox" class="myCheckbox" value="<?php echo $row_pub['pub_blocking_id'];?>" <?php echo $checked; ?> onclick="stop_pub(this.value,'<?php echo $operator; ?>','<?php echo $product; ?>')" ></td>
										<td><input type="checkbox" class="myCheckbox1" value="<?php echo $row_pub['pub_blocking_id'];?>" <?php echo $checked1; ?> onclick="stop_pub_camp(this.value,'<?php echo $operator; ?>','<?php echo $product; ?>','<?php echo $campid; ?>')" ></td>
																					
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
  
function stop_pub(pubid,operator,product)
{
	
    $('.myCheckbox').change(function() {
        if ($(this).prop('checked')) {
			

			$.ajax({
            type: "GET",
            url: "ajax/update_pub.php?operator="+operator+"&product="+product+"&c="+'check'+"&pubid="+pubid      
			});
			
			 
        }
        else {

			$.ajax({
            type: "GET",
             url: "ajax/update_pub.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&pubid="+pubid  
			});
           
        }
    });
}
</script> 		



<script type="text/javascript">
  
function stop_pub_camp(pubid,operator,product,campid)
{
	
    $('.myCheckbox1').change(function() {
        if ($(this).prop('checked')) {
			

			$.ajax({
            type: "GET",
            url: "ajax/update_pub_camp.php?operator="+operator+"&product="+product+"&c="+'check'+"&pubid="+pubid+"&campid="+campid      
			});
			
			 
        }
        else {

			$.ajax({
            type: "GET",
            url: "ajax/update_pub_camp.php?operator="+operator+"&product="+product+"&c="+'uncheck'+"&pubid="+pubid+"&campid="+campid 
			});
           
        }
    });
}
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
		
		
        $.ajax({
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&product="+product       
			
        }).done(function(data){
            $("#response").html(data);
			 
        });
    });
});
</script>


