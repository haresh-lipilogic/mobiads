<?php
include("includes/check_session.php");
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);



$operator='';
$product='';
$type='';
$count=0;
$logdb='';

if(isset($_POST['submit']))
{

	$operator=$_POST['operator'];
	$product ="glamour";
	
	
	include("includes/db.php");
	$logdb=strtolower($logdb);
		

		 $sql_campaign="	
					SELECT 
					campaign_tbl.campaign_id,campaign_title,campaign_operator,capping_count
				FROM
					".$logdb.".campaign_tbl
						LEFT JOIN
					".$logdb.".capping_tbl ON capping_tbl.campaign_id = campaign_tbl.campaign_id
				WHERE
					campaign_operator = '".$operator."'

				";
		$res_campaign=$conn->query($sql_campaign);
	
	
	$count=1;


}



if(isset($_POST['delete']))
{
	
	
	$operator=$_POST['operator'];
	$product ="glamour";
	
	if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db_cpi";	
		}
	
		else
		{
			$logdb=$operator."_".$product."db_cpi";	
		}
	$logdb=strtolower($logdb);
		
	$camp_id=implode(",",$_POST['del']); 
	
	$camp_live="UPDATE ".$logdb.".campaign_tbl  SET campaign_live = 1 where campaign_id in (".$camp_id.") ";
	$res_live=$conn->query($camp_live);
	
	$delete="DELETE FROM ".$logdb.".capping_tbl where campaign_id in (".$camp_id.") ";  
	$res_delete=$conn->query($delete);
	echo "<script>window.location='capping.php';</script>";
	
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
						<select name="operator" class="form-control " id="operator">
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
							<option value="dialog" <?php if($operator=='dialog'){$selected='selected';}else{$selected='';} echo $selected; ?>>dialog</option>
							<option value="xl" <?php if($operator=='xl'){$selected='selected';}else{$selected='';} echo $selected; ?>>xl</option>
							<option value="indosat" <?php if($operator=='indosat'){$selected='selected';}else{$selected='';} echo $selected; ?>>indosat</option>
							<option value="tele2" <?php if($operator=='tele2'){$selected='selected';}else{$selected='';} echo $selected; ?>>tele2</option>
							<option value="maxis" <?php if($operator=='maxis'){$selected='selected';}else{$selected='';} echo $selected; ?>>maxis</option>
							<option value="zain" <?php if($operator=='zain'){$selected='selected';}else{$selected='';} echo $selected; ?>>Zain</option>
							<option value="spainvodafone" <?php if($operator=='spainvodafone'){$selected='selected';}else{$selected='';} echo $selected; ?>>Spainvodafone</option>
						
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
					  
						<?php 
						if($type == '1')
						{
						?>
						
							<table id="" class="table table-striped table-bordered">
							


							<tbody>
								
									<tr>
										
										<td >Give Percentage  %
											<input type="text" value="<?php echo $row_campaign['camp_weightage_perc']; ?>" onblur="change_capping_auto(this.value,'<?php echo $operator; ?>','<?php echo $product; ?>')" >
											
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
									<td><strong>Capping</strong></td>
									<td><strong><input type="submit" name ="delete" class="btn btn-danger" value="Erase from capping"></strong></td>
																	
									
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
										<td>
											<input type="text"  value="<?php echo $row_campaign['capping_count']; ?>"  onblur="change_capping(this.value,<?php echo $row_campaign['campaign_id']; ?>,'<?php echo $operator; ?>','<?php echo $product; ?>')" >
											
										</td>	
										<td><input type="checkbox" name="del[]"  value="<?php echo $row_campaign['campaign_id']; ?>">
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
	   echo $logdb;
	   include("includes/footer.php");
		?>



<script type="text/javascript">

function change_capping(capping_value,campaign_id,operator,product)
{
		
		
		$.ajax({
            type: "GET",
            url: "ajax/update_capping.php?operator="+operator+"&product="+product+"&capping_value="+capping_value+"&campaign_id="+campaign_id       
			});			
			
			
}

</script> 		



