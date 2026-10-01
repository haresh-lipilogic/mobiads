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
	$partner=$_POST['partner'];
	$title=$_POST['title'];
	if($_POST['price'] == '')
	{
		$price=10;
	}
	else
	{
		$price=$_POST['price'];
	}
	
	$url=$_POST['url'];
	$live=$_POST['live'];
	if($_POST['weightage'] == '')
	{
		$weightage=1;
	}
	else
	{
		$weightage=$_POST['weightage'];
	}
	
	$browser=implode(',',$_POST['browser']); 
	$os=implode(',',$_POST['os']); 
	$startdatetime=date('Y-m-d')." 00:00:00";
	$enddatetime=date('Y-m-d')." 23:59:59"; 
	
		foreach($_POST['operator'] as $operator)
		{
			
			
	include("includes/db.php");
			
			$logdb=strtolower($logdb);
				$insert_camp="insert into ".$logdb.".campaign_tbl (campaign_partner,campaign_title,campaign_url,campaign_price,campaign_operator,campaign_live,campaign_startdatetime,campaign_enddatetime,campaign_weight,
				campaign_weight_track,campaign_country,campaign_category,campaign_browser,campaign_os) 
				values ('".$partner."','".$title."','".$url."','".$price."','".$operator."','".$live."','".$startdatetime."','".$enddatetime."','".$weightage."','".$weightage."','".$country."','".$category."','".$browser."','".$os."')";   
				//echo $insert_camp; exit;
				$res_camp=$conn->query($insert_camp);
				
				$select_last_campaign="select * from ".$logdb.".campaign_tbl order by campaign_id desc limit 1"; 
				$res_last_campaign=$conn->query($select_last_campaign);
				$row_last_campaign=$res_last_campaign->fetch();
				$campaign_id = $row_last_campaign['campaign_id']; 
				
				$sql_operator="select * from ".$commondb.".operator_tbl where operator = '".$operator."'";
				$res_operator=$conn->query($sql_operator);
				$row_operator=$res_operator->fetch();
				$operatorid=$row_operator['operator_id']; 
				
				$insert= "insert into ".$commondb.".".$product."_advertiser_payout_tbl (operatorid,campaign_id,payout,payout_datetime)
				values ('".$operatorid."','".$campaign_id."','".$price."','".$startdatetime."')"; 
				$res_insert=$conn->query($insert);
				
				$insert1= "insert into ".$logdb.".running_campaign_tbl (campaign_id,run_camp_operator,run_camp_track)
				values ('".$campaign_id."','".$operator."','1')"; 
				$res_insert1=$conn->query($insert1);
				
			
				
		}
	
	
	
	echo "<script>window.location='add_campaign.php';</script>";


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
                    <h2>Add Campaign</h2>
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
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback"> <strong> Operator </strong>
									<span class="response">
									</span>
								</div>
							</div>
							
							
							<div class="x_content">	
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback" > <strong>Campaign Partner</strong>
									<input type="text" class="form-control" name="partner" required>
								</div>
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Campaign Title</strong>
									<input type="text" class="form-control" name="title" required>
								</div>
							</div>
						
							<div class="x_content">
							
								
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Campaign Price</strong>
									<input type="text" class="form-control" name="price">
								</div>
								<div class="col-md-6 col-sm-2 col-xs-12 form-group has-feedback"><strong> Campaign URL </strong>
									<input type="text" class="form-control" name="url" >
								</div>
							</div>
						
						
						
												
						
							<div class="x_content">
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong> Campaign Live</strong>
									<select name="live" required class="form-control" id="operator">
										<option value="">Yes / No</option>
										<option value="1" <?php if($live=='1'){$selected='selected';}else{$selected='';} echo $selected; ?> >Yes</option>
									
										<option value="0" <?php if($live=='0'){$selected='selected';}else{$selected='';} echo $selected; ?>>No</option>
									</select>
								</div>
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Campaign Weightage</strong>
									<input type="text" class="form-control" name="weightage" required>
								</div>
								
							</div>
						
							<div class="x_content">
								<div class="col-md-12 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Campaign Browser</strong>
									<input type="checkbox" id="allbrowser"> All &nbsp;&nbsp;	
									<input type="checkbox" name="browser[]" class="browser" value="chrome"> Chrome &nbsp;&nbsp;	
									<input type="checkbox" name="browser[]" class="browser" value="opera"> Opera &nbsp;&nbsp;
									<input type="checkbox" name="browser[]" class="browser" value="ucb"> UC Browser &nbsp;&nbsp;
									<input type="checkbox" name="browser[]" class="browser" value="other"> other 
								</div>
								
							</div>
						
							<div class="x_content">
								<div class="col-md-12 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Campaign OS</strong>
									<input type="checkbox" id="allos"> All &nbsp;&nbsp;	
									<input type="checkbox" name="os[]" class="os" value="android"> Android &nbsp;&nbsp;	
									<input type="checkbox" name="os[]" class="os" value="iphone"> Iphone &nbsp;&nbsp;
									<input type="checkbox" name="os[]" class="os" value="windows"> Windows &nbsp;&nbsp;
									<input type="checkbox" name="os[]" class="os" value="linux"> Linux &nbsp;&nbsp;
									<input type="checkbox" name="os[]" class="os" value="other"> other 
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

<!-- fetch operators from country -->
<script type="text/javascript">

$(document).ready(function(){

    $("#country").change(function(){
		
		
        var country = $("#country").val();	
		
        $.ajax({
            type: "GET",
            url: "ajax/find_operator.php?country="+country       
			
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>	   		

<!-- Select all Operator -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allop").click(function () {
        $(".op").prop('checked', $(this).prop('checked'));
    });
});
</script>

<!-- Select all Operator -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allcat").click(function () {
        $(".category").prop('checked', $(this).prop('checked'));
    });
});
</script>

<!-- Select all OS -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allos").click(function () {
        $(".os").prop('checked', $(this).prop('checked'));
    });
});
</script>

<!-- Select all Browser -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allbrowser").click(function () {
        $(".browser").prop('checked', $(this).prop('checked'));
    });
});
</script>