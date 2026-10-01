<?php
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);



$operator='';
$type='';
$count=0;

if(isset($_POST['submit']))
{

	$operator=strtolower($_POST['operator']);
	$product ="glamour";
	$type=$_POST['type'];
	
	include("includes/db.php");
	$logdb=strtolower($logdb);
		
	
	if($type==1)
	{
		$sql_campaign="select * from ".$logdb.".campaign_weightage_tbl where camp_weightage_operator='".$operator."' limit 1"; 
		$res_campaign=$conn->query($sql_campaign);
		$row_campaign=$res_campaign->fetch();
	}
	else
	{
		$sql_campaign="	
					SELECT 
					campaign_tbl.campaign_id,campaign_title,campaign_operator,campaign_weight
				FROM
					".$logdb.".campaign_tbl
						
				WHERE
					campaign_operator = '".$operator."'
				;

				";
		$res_campaign=$conn->query($sql_campaign);
	}
	
	
	
	// check karva mate ke campaign type automation 6 ke manually
	
	
		$sql_auto="select * from ".$logdb.".campaign_type_tbl where camp_operator ='".$operator."' limit 1";
		$res_auto=$conn->query($sql_auto);
		$row_auto=$res_auto->fetch();

		if($row_auto['camp_type'] == 1)
		{
			$checked="checked";
		}
		else
		{
			$checked="";
		}

	
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
                    <h2>Campaign Capping</h2>
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
							<option value="tunisietelecom" <?php if($operator=='tunisietelecom'){$selected='selected';}else{$selected='';} echo $selected; ?>>tunisietelecom</option>
							<option value="spainvodafone" <?php if($operator=='spainvodafone'){$selected='selected';}else{$selected='';} echo $selected; ?>>spainvodafone</option>
							<option value="yogo" <?php if($operator=='yogo'){$selected='selected';}else{$selected='';} echo $selected; ?>>yogo</option>
							<option value="movistar" <?php if($operator=='movistar'){$selected='selected';}else{$selected='';} echo $selected; ?>>movistar</option>
							<option value="spainorange" <?php if($operator=='spainorange'){$selected='selected';}else{$selected='';} echo $selected; ?>>spainorange</option>
							<option value="dialog" <?php if($operator=='dialog'){$selected='selected';}else{$selected='';} echo $selected; ?>>dialog</option>
							<option value="xl" <?php if($operator=='xl'){$selected='selected';}else{$selected='';} echo $selected; ?>>xl</option>
							<option value="indosat" <?php if($operator=='indosat'){$selected='selected';}else{$selected='';} echo $selected; ?>>indosat</option>
							<option value="viva" <?php if($operator=='viva'){$selected='selected';}else{$selected='';} echo $selected; ?>>Viva</option>
						</select>
						</div>
						
						<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> Type setting
						<select name="type" class="form-control select2_single" id="type">
							
							<option value="1" <?php if($type=='1'){$selected='selected';}else{$selected='';} echo $selected; ?> >Percentage</option>
							<option value="2" <?php if($type=='2'){$selected='selected';}else{$selected='';} echo $selected; ?>>Manually</option>
							
						</select>
						</div>
						
						<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> Automation
							<input type="checkbox"  <?php echo $checked; ?> id="automation"> 
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
					 
						<input type="text" value="<?php echo $operator ?>" class="operator1" name="operator1" hidden>
						<input type="text" value="<?php echo $product ?>" class="product1" name="product1" hidden>
						<?php 
						if($type == '1')
						{
						?>
							<table id="" class="table table-striped table-bordered">
							


							<tbody>
								
									<tr>
										
										<td >Give Percentage  %
											<input type="text" value="<?php echo $row_campaign['camp_weightage_perc']; ?>" onblur="change_weightage_auto(this.value,'<?php echo $operator; ?>','<?php echo $product; ?>')" >
											
										</td>	
										
									</tr>
								
								
								
								
																
							</tbody>
		
						</table>
						<?php
						}
						else
						{
						?>
							<table id="" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Campaign ID</strong></td>
									<td><strong>Title</td>
									<td><strong>Campaign Weight</strong></td>	
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
									while($row_campaign=$res_campaign->fetch())
									{
									
										
								?>
									<tr>
										<td><?php echo $row_campaign['campaign_id']; ?></td>
										<td><?php echo $row_campaign['campaign_title']; ?></td>
										<td>
											<input type="text"  value="<?php echo $row_campaign['campaign_weight']; ?>"  onblur="change_manually(this.value,<?php echo $row_campaign['campaign_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>')" >
											
										</td>	
									</tr>
								
								
								
								<?php
									}
								
								?>
																
							</tbody>
		
						</table>
					 
					
						<?php
						}
						?>
				
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

function change_manually(weight_value,campaign_id,operator,product)
{
		
		
		$.ajax({
            type: "GET",
            url: "ajax/update_camp_weight.php?operator="+operator+"&product="+product+"&weight_value="+weight_value+"&campaign_id="+campaign_id       
			});			
			
			
}
function change_weightage_auto(capping_value,operator,product)
{
		
		
		$.ajax({
            type: "GET",
            url: "ajax/update_camp_weight_auto.php?operator="+operator+"&product="+product+"&capping_value="+capping_value   
			});			
			
			
}
</script> 		


<script type="text/javascript">

$(document).ready(function() {
	
    $('#automation').change(function() {
		
    if ($(this).prop('checked')) {
			
			
          
            var operator = $(".operator1").val();
            var product = $(".product1").val();
			
		
			$.ajax({
            type: "GET",
            url: "ajax/update_camp_type.php?operator="+operator+"&product="+product+"&c="+'check' 
			
			
			});
			
			 
        }
        else {
			
		
          
            var operator = $(".operator1").val();
			var product = $(".product1").val();
			
			$.ajax({
            type: "GET",
            url: "ajax/update_camp_type.php?operator="+operator+"&product="+product+"&c="+'uncheck'     
			
			
			});
           
        }
    });
});

</script> 
