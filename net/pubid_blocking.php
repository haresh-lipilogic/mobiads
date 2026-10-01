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
	$advertiserid=$_POST['advid'];
	$pubid=explode(",",$_POST['pubid']);

	include("includes/db.php");
	
	
	$commondb="commondb";
		$sql1="SELECT advertiser_name name , advertiser_id id from ".$commondb.".advertiser_tbl inner join ".$commondb.".operator_tbl 
		on advertiser_tbl.operator = operator_tbl.operator_id where operator_tbl.operator = '".$operator."'
		";   
		$res1=$conn->query($sql1);		
		

	$logdb=strtolower($logdb);
		
	foreach($pubid as $pub)
	{
		$select_pub="select * from ".$logdb.".pub_blocking_tbl where pubid = '".$pub."' ";
		$res_pub=$conn->query($select_pub);
		$num=$res_pub->rowCount();
		if($num > 0)
		{
			$update="update ".$logdb.".pub_blocking_tbl  set pubid_isactive=0  where pubid='".$pub."' and advertiser_id='".$advertiserid."'"; 
		$res_update=$conn->query($update);
		}
		else
		{
		$insert="insert into ".$logdb.".pub_blocking_tbl (pubid,advertiser_id,pubid_isactive) values ('".$pub."','".$advertiserid."','0')"; 
		$res_insert=$conn->query($insert);
		}
	}
	
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
							<option value="vodafone" <?php if($operator=='vodafone'){$selected='selected';}else{$selected='';} echo $selected; ?> >Vodafone</option>
							<option value="airtel" <?php if($operator=='airtel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Airtel</option>
							<option value="idea" <?php if($operator=='idea'){$selected='selected';}else{$selected='';} echo $selected; ?>>Idea</option>
							<option value="bsnl" <?php if($operator=='bsnl'){$selected='selected';}else{$selected='';} echo $selected; ?>>BSNL</option>
							<option value="azercell" <?php if($operator=='azercell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Azercell</option>
							<option value="backcell" <?php if($operator=='backcell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Backcell</option>
							<option value="narcell" <?php if($operator=='narcell'){$selected='selected';}else{$selected='';} echo $selected; ?>>Narcell</option>
							<option value="kuwaitooredoo" <?php if($operator=='kuwaitooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Kuwaitooredoo</option>
							<option value="omanooredoo" <?php if($operator=='omanooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Omanooredoo</option>
							<option value="ais" <?php if($operator=='ais'){$selected='selected';}else{$selected='';} echo $selected; ?>>AIS</option>
							<option value="dtac" <?php if($operator=='dtac'){$selected='selected';}else{$selected='';} echo $selected; ?>>DTAC</option>
							<option value="du" <?php if($operator=='du'){$selected='selected';}else{$selected='';} echo $selected; ?>>DU</option>
							<option value="hutch" <?php if($operator=='hutch'){$selected='selected';}else{$selected='';} echo $selected; ?>>Hutch</option>
							<option value="celcom" <?php if($operator=='celcom'){$selected='selected';}else{$selected='';} echo $selected; ?>>Celcom</option>
							<option value="telcel" <?php if($operator=='telcel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Telcel</option>
							<option value="myanmarooredoo" <?php if($operator=='myanmarooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Myanmarooredoo</option>
							<option value="egyptvodafone" <?php if($operator=='egyptvodafone'){$selected='selected';}else{$selected='';} echo $selected; ?>>Egyptvodafone</option>
							<option value="orange" <?php if($operator=='orange'){$selected='selected';}else{$selected='';} echo $selected; ?>>Orange</option>
							<option value="egyptetisalat" <?php if($operator=='egyptetisalat'){$selected='selected';}else{$selected='';} echo $selected; ?>>Egyptetisalat</option>
							<option value="aircel" <?php if($operator=='aircel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Aircel</option>
							<option value="omantel" <?php if($operator=='omantel'){$selected='selected';}else{$selected='';} echo $selected; ?>>Omantel</option>
							<option value="omanmobile" <?php if($operator=='omanmobile'){$selected='selected';}else{$selected='';} echo $selected; ?>>Omanmobile</option>
							<option value="mtn" <?php if($operator=='mtn'){$selected='selected';}else{$selected='';} echo $selected; ?>>MTN</option>
							<option value="cellc" <?php if($operator=='cellc'){$selected='selected';}else{$selected='';} echo $selected; ?>>Cellc</option>
							<option value="vodacom" <?php if($operator=='vodacom'){$selected='selected';}else{$selected='';} echo $selected; ?>>Vodacom</option>
							<option value="zaooredoo" <?php if($operator=='zaooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>Zaooredoo</option>
							<option value="banglalink" <?php if($operator=='banglalink'){$selected='selected';}else{$selected='';} echo $selected; ?>>banglalink</option>
							<option value="robi" <?php if($operator=='robi'){$selected='selected';}else{$selected='';} echo $selected; ?>>robi</option>
							<option value="grameenphone" <?php if($operator=='grameenphone'){$selected='selected';}else{$selected='';} echo $selected; ?>>grameenphone</option>
							<option value="tunisiaooredoo" <?php if($operator=='tunisiaooredoo'){$selected='selected';}else{$selected='';} echo $selected; ?>>tunisiaooredoo</option>
							<option value="tunisie" <?php if($operator=='tunisie'){$selected='selected';}else{$selected='';} echo $selected; ?>>tunisie</option>
						</select>
						</div>
						
						
						
						<span id="response">
						
						<?php
						if($count == 1)
						{
						?>
								<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">Publisher Name
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
								</div>
								
								
						<?php
						}
						?>
					
						</span>
						
					</div>
					<div class="x_content">
						<div class="col-md-12 col-sm-12 col-xs-12">
						 
						 <textarea name="pubid" class="form-control"></textarea>
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


