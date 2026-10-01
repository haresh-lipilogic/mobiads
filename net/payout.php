<?php
include("includes/check_session.php");
include("includes/connection.php");
error_reporting(0);

$commondb="commondb";

$start_date='';
$end_date='';
$operator='';
$product='';

$count=0;
$cc=0;
if(isset($_POST['submit']))
{
	$count=1;
$commondb="commondb";
	$operator=strtolower($_POST['operator']);
	$product=strtolower($_POST['product']);
	
	$start_date=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$end_date=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";

	if(strtolower($product) == 'glamour')
	{
		$tbl="glamour_payout_tbl";
	}
	else
	{
		$tbl="games_payout_tbl";
	}
include("includes/db.php");
		 $sql="
			SELECT 
				COUNT(*) leads,
				round(SUM(payout_tbl.payout) ,2) total,
				payout_tbl.payout payout,
				
				advertiser_name
			FROM
				".$logdb.".payout_tbl
					INNER JOIN
				".$logdb.".advertiser_response_tbl ON payout_tbl.clickid = advertiser_response_tbl.clickid
					INNER JOIN
				".$commondb.".advertiser_tbl ON advertiser_tbl.advertiser_id = payout_tbl.advertiser_id
			WHERE
				ad_resp_datetime >= '".$start_date."'
								AND ad_resp_datetime <= '".$end_date."'
								AND advertiser_response != 'stop'
			GROUP BY advertiser_response_tbl.advertiser_id , payout_tbl.payout;
						";   
						
						

	
	$res=$conn->query($sql);
	
	
	
	 $sql1="
			SELECT 
				COUNT(*) leads,
				round(SUM(payout_tbl.camp_payout) ,2) total,
				payout_tbl.camp_payout payout,
				campaign_title
			FROM
				".$logdb.".payout_tbl
					INNER JOIN
				".$logdb.".advertiser_response_tbl ON payout_tbl.clickid = advertiser_response_tbl.clickid
					INNER JOIN
				".$logdb.".campaign_tbl ON campaign_tbl.campaign_id = payout_tbl.campaign_id
			WHERE
				ad_resp_datetime >= '".$start_date."'
								AND ad_resp_datetime <= '".$end_date."'
								
			GROUP BY advertiser_response_tbl.campaign_id , payout_tbl.camp_payout;
						";   
						
						

	
	$res1=$conn->query($sql1);
	

	
	
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
						<select name="product" class="form-control select2_single" id="product">
							
							<option value="Glamour" <?php if($product=='glamour'){$selected='selected';}else{$selected='';} echo $selected; ?> >Glamour</option>
							<option value="Games" <?php if($product=='games'){$selected='selected';}else{$selected='';} echo $selected; ?>>Games</option>
							<option value="music" <?php if($product=='music'){$selected='selected';}else{$selected='';} echo $selected; ?>>Music</option>
							
						</select>
						</div>
						
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
							
							<option value="truemove" <?php if($operator=='truemove'){$selected='selected';}else{$selected='';} echo $selected; ?>>truemove</option>
						</select>
						</select>
						</div>
						
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($start_date!=''){echo date('d-m-Y',strtotime($start_date));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($end_date!=''){echo date('d-m-Y',strtotime($end_date));}else{ echo date('d-m-Y');} ?>" type="text">
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
					 
						<h3>Publisher Payout</h3>
						</br>
						<table id="datatable-buttons"  class="table table-striped table-bordered">
							<thead>
								<tr>
									<td width="15%"><strong>Publisher</strong></td>
									<td width="15%"><strong>Leads Sent</td>
									<td width="15%"><strong>Payout (USD)</td>
									
									<td width="15%"><strong>Total</td>	
									
									
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								$act=0;
								$advertiser_payout=0;
									while($row=$res->fetch())
									{
										
								
								?>
									<tr>
										<td><?php echo $row['advertiser_name']; ?></td>
										<td><?php echo $row['leads']; $act=$act+$row['leads']; ?></td>
										<td><?php echo $row['payout']; ?></td>
										<td><?php echo $a=number_format($row['total'],2); $advertiser_payout=$advertiser_payout+$a; ?></td>
										
										
									</tr>
								
								
								
								<?php
									}
								
								?>
									
								<tr>
										<td>Total</td>
										<td><?php echo $act; ?></td>
										<td></td>
										<td><?php echo $advertiser_payout;  ?></td>
										
										
									</tr>									
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
					 
						<h3>Advertiser Payout</h3>
						</br>
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td width="15%"><strong>Advertiser</strong></td>
									<td width="15%"><strong>Leads Received</td>
									<td width="15%"><strong>Payout (USD)</td>
									
									<td width="15%"><strong>Total</td>	
									
									
																	
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								$act=0;
								$payout=0;
									while($row1=$res1->fetch())
									{
										
								
								?>
									<tr>
										<td><?php echo $row1['campaign_title']; ?></td>
										<td><?php echo $row1['leads']; $act=$act+$row1['leads']; ?></td>
										<td><?php echo $row1['payout']; ?></td>
										<td><?php echo $a=number_format($row1['total'],2); $payout=$payout+$a; ?></td>
										
										
									</tr>
								
								
								
								<?php
									}
								
								?>
									
								<tr>
										<td>Total</td>
										<td><?php echo $act; ?></td>
										<td></td>
										<td><?php echo $payout;  ?></td>
										
										
									</tr>									
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
		

       <?php
	   include("includes/footer.php");
		?>
		

