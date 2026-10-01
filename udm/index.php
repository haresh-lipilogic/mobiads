<?php
include("includes/connection.php");
error_reporting(0);


$startdate='';
$enddate='';
$operator='';
$partner='';
$type='';
$count=0;
$cc=0; 
if(isset($_POST['submit']))
{
	
	$count=1;	
	$country=$_POST['country'];
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";

	if($country == '162')
	{
		$adid="30288";
		$db="spainvodafone_glamourdb";
		$operator="Vodafone";
	}
	if($country == '160')
	{
		$adid="31364";
		$db="mtn_glamourdb";
		$operator="MTN";
	}
	elseif($country == '67')
	{
		$adid="30317";
		$db="vodafonegreece_glamourdb";
		$operator="Vodafone";
	}
	elseif($country == '65')
	{
		$adid="29546";
		$db="vodafonegermany_glamourdb";
		$operator="Vodafone";
	}
	elseif($country == '90')
	{
		$adid="31019";
		$db="zain_glamourdb";
		$operator="Zain";
	}
	elseif($country == '61')
	{
		$adid1="31010";
		$adid2="31013";
		$adid3="31016";
		$db="sfr_glamourdb";
		$operator1="SFR";
		$operator2="Bouygues";
		$operator3="Orange";
		
	}
	elseif($country == '127')
	{
		$adid="1031";
		$db="fashionbardb_norway";
	}
	elseif($country == '127')
	{
		$adid="1031";
		$db="fashionbardb_norway";
	}
	elseif($country == '198')
	{
		$adid="1031";
		$db1="fashionbardb_greecegamebar";
		$db2="fashionbardb_greeceglambar";
		$operator="Vodafone";
	}

	else{
		
	}
	
	
	if($country == '90'  || $country == '67'  || $country == '65'  || $country == '162' || $country == '160' || $country == '67' )
	{
		
		$sql="
		SELECT 
		SUM(clicks) clicks, SUM(act) act, dt, operator
		FROM
		(SELECT 
			COUNT(DISTINCT clickid) clicks,
				0 act,
				DATE(userlog_datetime) dt,
				'".$operator."' operator
		FROM
			".$db.".userlog_tbl
		WHERE
			userlog_datetime >= '".$startdate."'
				AND userlog_datetime <= '".$enddate."'
				AND advertiser_id = '".$adid."'
		GROUP BY dt UNION SELECT 
			0 clicks,
				COUNT(DISTINCT clickid) act,
				DATE(ad_resp_datetime) dt,
				'".$operator."' operator
		FROM
			".$db.".advertiser_response_tbl
		WHERE
			ad_resp_datetime >= '".$startdate."'
				AND ad_resp_datetime <= '".$enddate."'
				AND advertiser_response != 'stop'
				AND advertiser_id = '".$adid."'
		GROUP BY dt) a
		GROUP BY dt, operator
				"; 

	}
	elseif($country == '127')
	{
		$sql="SELECT 
			SUM(clicks) clicks, SUM(act) act, dt
		FROM
			(SELECT 
				COUNT(DISTINCT clickid) clicks, 0 act, DATE(accesstime) dt
			FROM
				".$db.".userlog
			WHERE
				accesstime >= '".$startdate."'
					AND accesstime <= '".$enddate."'
					AND advertiserid = '".$adid."'
			GROUP BY dt UNION SELECT 
				0 clicks,
					COUNT(DISTINCT clickid) act,
					DATE(advertdatetime) dt
			FROM
				".$db.".advertcallback
			WHERE
				advertdatetime >= '".$startdate."'
					AND advertdatetime <= '".$enddate."'
					AND advertresponse != 'stop'
					AND advertiserid = '".$adid."'
			GROUP BY dt) a
		GROUP BY dt"; 
		
	}
	elseif($country == '198')
	{
		
		 $sql="SELECT 
				SUM(clicks) clicks, SUM(act) act, dt,'".$operator."' operator
			FROM
				(SELECT 
					SUM(clicks) clicks, SUM(act) act, dt
				FROM
					(SELECT 
					COUNT(DISTINCT clickid) clicks, 0 act, DATE(accesstime) dt
				FROM
					".$db1.".userlog
				WHERE
					accesstime >= '".$startdate."'
					AND accesstime <= '".$enddate."'
						AND advertiserid = '".$adid."'
				GROUP BY dt UNION SELECT 
					0 clicks,
						COUNT(DISTINCT clickid) act,
						DATE(advertdatetime) dt
				FROM
					".$db1.".advertcallback
				WHERE
					advertdatetime >= '".$startdate."'
					AND advertdatetime <= '".$enddate."'
						AND advertresponse != 'stop'
						AND advertiserid = '".$adid."'
				GROUP BY dt) a
				GROUP BY dt UNION ALL SELECT 
					SUM(clicks) clicks, SUM(act) act, dt
				FROM
					(SELECT 
					COUNT(DISTINCT clickid) clicks, 0 act, DATE(accesstime) dt
				FROM
					".$db2.".userlog
				WHERE
					accesstime >= '".$startdate."'
					AND accesstime <= '".$enddate."'
						AND advertiserid = '".$adid."'
				GROUP BY dt UNION SELECT 
					0 clicks,
						COUNT(DISTINCT clickid) act,
						DATE(advertdatetime) dt
				FROM
					".$db2.".advertcallback
				WHERE
					advertdatetime >= '".$startdate."'
					AND advertdatetime <= '".$enddate."'
						AND advertresponse != 'stop'
						AND advertiserid = '".$adid."'
				GROUP BY dt) a
				GROUP BY dt) a
			GROUP BY dt;"; 
		
	}
	else{
		$sql="SELECT 
				SUM(clicks) clicks, SUM(act) act, dt, operator
			FROM
				(SELECT 
					COUNT(DISTINCT clickid) clicks,
						0 act,
						DATE(userlog_datetime) dt,
						'".$operator1."' operator
				FROM
					sfr_glamourdb.userlog_tbl
				WHERE
					userlog_datetime >= '".$startdate."'
						AND userlog_datetime <= '".$enddate."'
						AND advertiser_id = '".$adid1."'
				GROUP BY dt UNION SELECT 
					0 clicks,
						COUNT(DISTINCT clickid) act,
						DATE(ad_resp_datetime) dt,
						'".$operator1."' operator
				FROM
					sfr_glamourdb.advertiser_response_tbl
				WHERE
					ad_resp_datetime >= '".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND advertiser_response != 'stop'
						AND advertiser_id = '".$adid1."'
				GROUP BY dt) a
			GROUP BY dt , operator
			UNION ALL SELECT 
				SUM(clicks) clicks, SUM(act) act, dt, operator
			FROM
				(SELECT 
					COUNT(DISTINCT clickid) clicks,
						0 act,
						DATE(userlog_datetime) dt,
						'".$operator2."' operator
				FROM
					bouygues_glamourdb.userlog_tbl
				WHERE
					userlog_datetime >= '".$startdate."'
						AND userlog_datetime <= '".$enddate."'
						AND advertiser_id = '".$adid2."'
				GROUP BY dt UNION SELECT 
					0 clicks,
						COUNT(DISTINCT clickid) act,
						DATE(ad_resp_datetime) dt,
						'".$operator2."' operator
				FROM
					bouygues_glamourdb.advertiser_response_tbl
				WHERE
					ad_resp_datetime >= '".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND advertiser_response != 'stop'
						AND advertiser_id = '".$adid2."'
				GROUP BY dt) a
			GROUP BY dt , operator
			UNION ALL SELECT 
				SUM(clicks) clicks, SUM(act) act, dt, operator
			FROM
				(SELECT 
					COUNT(DISTINCT clickid) clicks,
						0 act,
						DATE(userlog_datetime) dt,
						'".$operator3."' operator
				FROM
					franceorange_glamourdb.userlog_tbl
				WHERE
					userlog_datetime >= '".$startdate."'
						AND userlog_datetime <= '".$enddate."'
						AND advertiser_id = '".$adid3."'
				GROUP BY dt UNION SELECT 
					0 clicks,
						COUNT(DISTINCT clickid) act,
						DATE(ad_resp_datetime) dt,
						'".$operator3."' operator
				FROM
					franceorange_glamourdb.advertiser_response_tbl
				WHERE
					ad_resp_datetime >= '".$startdate."'
						AND ad_resp_datetime <= '".$enddate."'
						AND advertiser_response != 'stop'
						AND advertiser_id = '".$adid3."'
				GROUP BY dt) a
			GROUP BY dt, operator";
	}
	
	$res=$conn->query($sql);
	
	

	
}
?>

		<?php include("includes/header.php"); ?>
		
			

        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="footer_down">

            
            

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post">
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Country 
							<select name="country" class="form-control select2_single" >
								<option>Select</option>
								<?php 
								$sql_country="select distinct country_name,country_id from commondb.country_tbl ";
								
								$res_country=$conn->query($sql_country);
								while($row_country=$res_country->fetch())
								{
									if($row_country['country_id'] == $country)
									{
										echo $selected="selected";
									}
									else
									{
										echo $selected= "";
									}
								
								?>
								<option value="<?php echo $row_country['country_id'] ?>" <?php  echo $selected; ?> ><?php echo $row_country['country_name'] ?></option>
								<?php
								}
								?>
							</select>
						</div>
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($startdate!=''){echo date('d-m-Y',strtotime($startdate));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($enddate!=''){echo date('d-m-Y',strtotime($enddate));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						</br>
						
						<div class="col-md-2 col-sm-2 col-xs-12">
						 
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
			
					  <div class="x_content"  style="overflow:auto;">
						
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td><strong>Date</strong></td>								
									<td><strong>Operator</strong></td>								
									<td><strong>Clicks</strong></td>								
									<td><strong>Activation </strong></td>									
									<td><strong>CR% </strong></td>									
								</tr>
							</thead>


							<tbody>
								<?php 
								$click_sum='';
								$ren_sum='';
								$resp_sum='';
								$act_sum='';
								$actamnt_sum='';
								$dct_sum='';
								$cbr_sum='';
								$cbs_sum='';
								$low_sum='';
								$dctamnt_sum='';
								
								
									while($row=$res->fetch())
									{
										
								?>
									<tr>
										<td  style="width:7%"><?php echo date('d-m-Y',strtotime($row['dt']));  ?></td>
										<td  style="width:7%"><?php echo $row['operator'];  ?></td>
										<td style="width:7%"><?php echo number_format($row['clicks']); $click_sum=$click_sum+$row['clicks']; ?></td>	
										<td style="width:7%"><?php echo number_format($row['act']); $act_sum=$act_sum+$row['act']; ?></td>	
										<td style="width:7%"><?php echo round(($row['act']/$row['clicks'])*100, 2);  ?>%</td>	
									</tr>
								
								
								
								<?php
									}
								?>
								
								<tr>
									<td>Total</td>	
									<td></td>									
									<td><?php echo number_format($click_sum); ?></td>
									<td><?php echo number_format($act_sum); ?></td>
									<td></td>
	
								</tr>
							</tbody>
							
							
								
								
						</table>
					  </div>
				
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
		var partner = $("#partner").val();
        
		//alert("ajax/find_advertiser.php?operator="+operator+"&partner="+partner);
		$.ajax({
			
			
            type: "GET",
            url: "ajax/find_advertiser.php?operator="+operator+"&partner="+partner         
			//url:"ajax/find_advertiser.php?operator=ais&partner=svmobi"
        }).done(function(data){
            $(".response").html(data);
			 
        });
    });
});
</script>
