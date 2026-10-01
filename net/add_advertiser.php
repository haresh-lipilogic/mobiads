<?php
error_reporting(0);
include("includes/check_session.php");
include("includes/connection.php");
include("../includes/language.php");

$count=0;


//country fetch karva

$sql_country="select * from commondb.country_tbl";
$res_country=$conn->query($sql_country);

$sql_operator="select distinct operator_id,operator from commondb.operator_tbl";
$res_operator=$conn->query($sql_operator);

if(isset($_POST['submit']))
{
	$ad_name=$_POST['ad_name'];
	$ad_url=$_POST['ad_url'];
	$ad_dcturl=$_POST['ad_dcturl'];

	$ad_active=$_POST['ad_isactive'];
	$operator=$_POST['operator']; 

	//print_r($operator); exit;
	
	
	if($_POST['redirect_url'] == '')
	{
		$redirect_url=$_POST['redirect_url'];
	}
	else
	{
		$redirect_url='http://bit.ly/28TEoDR';
	}



	
	$commondb='commondb';
	foreach ($operator as $op)
	{
		$sql_operator1="select * from commondb.operator_tbl where operator_id='".$op."'"; 
		$res_operator1=$conn->query($sql_operator1);
		$row_operator1=$res_operator1->fetch();
		
					$ad_name1=$ad_name.$row_operator1['operator_code'];

				 	$sql="insert into ".strtolower($commondb).".advertiser_tbl (advertiser_name,operator,advertiser_url,advertiser_isactive,advertiser_dct_url,
					spo_stopcallback,act_stopcallback,games_spo_stopcallback,games_act_stopcallback,music_spo_stopcallback,music_act_stopcallback,redirect_url) values ('".$ad_name1."','".$row_operator1['operator_id']."','".$ad_url."','".$ad_active."','".$ad_dcturl."','100','10','100','10','100','10','".$redirect_url."')" ;  
					$res=$conn->query($sql);
				
				if($op == 1)
				{
					$logdb1="voda_glamourdb_0617";
					$logdb2="voda_gamesdb_0617";
					$logdb3="voda_musicdb";
					$logdb4="voda_utilitydb";
				}
				elseif($op == 2)
				{
					$logdb1=$row_operator1['operator']."_glamourdb_0817";
					$logdb2=$row_operator1['operator']."_gamesdb_1017";
					$logdb3=$row_operator1['operator']."_musicdb";
					$logdb4=$row_operator1['operator']."_utilitydb";
				}
				elseif($op == 3)
				{
					$logdb1=$row_operator1['operator']."_glamourdb_1117";
					$logdb2=$row_operator1['operator']."_gamesdb_0617";
					$logdb3=$row_operator1['operator']."_musicdb";
					$logdb4=$row_operator1['operator']."_utilitydb";
				}
				else{
					$logdb1=$row_operator1['operator']."_glamourdb";
					$logdb2=$row_operator1['operator']."_gamesdb";
					$logdb3=$row_operator1['operator']."_musicdb";
					$logdb4=$row_operator1['operator']."_utilitydb";
				}
				
				$db="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb1."'";
				$res_db=$conn->query($db);
				$row_db=$res_db->rowCount(); 
				if($row_db > 0)
				{
					$sql_adid="select * from commondb.advertiser_tbl order by advertiser_id  desc limit 1";
					$res_adid=$conn->query($sql_adid);
					$row_adid=$res_adid->fetch();
					
					$sql_callback="insert into ".$logdb1.".advertiser_callback_counter_tbl   (advertiser_id,spo_callback_counter,act_callback_counter)
					values ('".$row_adid['advertiser_id']."','20','20')";
					$res_callback=$conn->query($sql_callback);
				}
				
				
				
				$db1="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb2."'";
				$res_db1=$conn->query($db1);
				$row_db1=$res_db1->rowCount(); 
				if($row_db1 > 0)
				{
					$sql_adid="select * from commondb.advertiser_tbl order by advertiser_id  desc limit 1";
					$res_adid=$conn->query($sql_adid);
					$row_adid=$res_adid->fetch();
					
					$sql_callback="insert into ".$logdb2.".advertiser_callback_counter_tbl   (advertiser_id,spo_callback_counter,act_callback_counter)
					values ('".$row_adid['advertiser_id']."','20','20')";
					$res_callback=$conn->query($sql_callback);
				}
				
				
				
				
				$db2="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb3."'";
				$res_db2=$conn->query($db2);
				$row_db2=$res_db2->rowCount(); 
				if($row_db2 > 0)
				{
					$sql_adid="select * from commondb.advertiser_tbl order by advertiser_id  desc limit 1";
					$res_adid=$conn->query($sql_adid);
					$row_adid=$res_adid->fetch();
					
					$sql_callback="insert into ".$logdb3.".advertiser_callback_counter_tbl   (advertiser_id,spo_callback_counter,act_callback_counter)
					values ('".$row_adid['advertiser_id']."','20','20')";
					$res_callback=$conn->query($sql_callback);
				}
				
				$db3="SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME ='".$logdb4."'";
				$res_db3=$conn->query($db3);
				$row_db3=$res_db3->rowCount(); 
				if($row_db3 > 0)
				{
					$sql_adid="select * from commondb.advertiser_tbl order by advertiser_id  desc limit 1";
					$res_adid=$conn->query($sql_adid);
					$row_adid=$res_adid->fetch();
					
					$sql_callback="insert into ".$logdb4.".advertiser_callback_counter_tbl   (advertiser_id,spo_callback_counter,act_callback_counter)
					values ('".$row_adid['advertiser_id']."','20','20')";
					$res_callback=$conn->query($sql_callback);
				}
				
				
	}

	echo "<script>window.location='add_advertiser.php';</script>";


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
                    <h2>Add Publisher</h2>
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
								<div class="col-md-12 col-sm-2 col-xs-12 form-group has-feedback"> <strong>Operator</strong> 
							</br></br>
									
									<input type="checkbox" id="allop"> All &nbsp;&nbsp;	
									<?php
										while($row_operator=$res_operator->fetch())
										{
									?>
									<input type="checkbox" name="operator[]" class="op" value="<?php echo $row_operator['operator_id']; ?>" > <?php echo $row_operator['operator']; ?> &nbsp;&nbsp;
									<?php
										}
									?>
								</div>
							</div>
							
							<div class="x_content">	
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback" > <strong>Publisher Name</strong>
									<input type="text" class="form-control" name="ad_name" >
								</div>
								
							</div>
							
							<div class="x_content">	
								<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback"> <strong>Publisher Activation PostBack URL</strong>
									<input type="text" class="form-control" name="ad_url" >
								</div>
							</div>
							<div class="x_content">	
								<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback"> <strong>Publisher Deactivation PostBack URL</strong>
									<input type="text" class="form-control" name="ad_dcturl" >
								</div>
							</div>
							
							
							
						
						
							<div class="x_content">	
								<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback"> <strong>Redirect URL</strong>
									<input type="text" class="form-control" name="redirect_url" >
								</div>
								
							</div>
						
							
						
						
						
												
						
							<div class="x_content">
								<div class="col-md-3 col-sm-2 col-xs-12 form-group has-feedback"> <strong> Is Publisher active or not?</strong>
									<select name="ad_isactive" required class="form-control" id="operator">
										<option>Yes / No</option>
										<option value="1" <?php if($active=='1'){$selected='selected';}else{$selected='';} echo $selected; ?> >Yes</option>
									
										<option value="0" <?php if($active=='1'){$selected='selected';}else{$selected='';} echo $selected; ?>>No</option>
									</select>
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

<!-- Select all Operator -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allop").click(function () {
        $(".op").prop('checked', $(this).prop('checked'));
    });
});
</script>