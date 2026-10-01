<?php
include("includes/connection.php");
include("includes/language_cpi.php");
error_reporting(0);

$startdate='';
$enddate='';
$operator='';
$country='';
$product='';
$type='';
$count=0;
$cc=0; 
if(isset($_POST['submit']))
{
	
	$count=1;

	$operator=strtolower($_POST['operator']); 
	$operatorid=strtolower($_POST['operator']); 
	$product ="glamour";
	$startdate=date('Y-m-d',strtotime($_POST['start_date']))." 00:00:00";  
	$enddate=date('Y-m-d',strtotime($_POST['end_date']))." 23:59:59";
	
	
	
	$type=$_POST['type'];
	$id=$_POST['pubadid']; 
	$country =$_POST['country'];
	
	
	$sql_country="select country_name,operator_tbl.country_id from ".$commondb.".country_tbl inner join ".$commondb.".operator_tbl on country_tbl.country_id = operator_tbl.country_id ;";
	$res_country=$conn->query($sql_country);
	$row_country=$res_country->fetch();
	
	
	
	$sql_operator="select * from ".$commondb.".operator_tbl where operator_id = '".$operator."'";
	$res_operator=$conn->query($sql_operator);
	$row_operator=$res_operator->fetch();
	$operator=$row_operator['operator'];
	
	
		include("includes/db.php");
	
	if($type =='Advertiser' || $type == 'advertiser')
	{
		if($id != 'all')
		{
			$condition="AND campaign_tbl.campaign_id = '".$id."'";
			
		}
		else
		{
			$condition="";
			
		}
	}
	else
	{	
		if($id != 'all')
		{
			$condition="AND advertiser_tbl.advertiser_id = '".$id."'";
		}
		else
		{
			$condition="";
		}
	}
	
	 $sql_operator1="select distinct operator,operator_id from ".$commondb.".operator_tbl where country_id = $country ";  
	$res_operator1=$conn->query($sql_operator1);
	
	
		if($type =='Advertiser' || $type == 'advertiser')
		{
		$sql1="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
		$res1=$conn->query($sql1);
		
		}
		else{
	 	
		
		$sql1="SELECT advertiser_name name , advertiser_id id from ".$commondb.".advertiser_tbl ";  
		$res1=$conn->query($sql1);
		
		}
		
		
		$sql="SELECT 
    ad_resp_id,
			advertiser_callbackurl,
			ad_resp_datetime dt,
			advertiser_name publisher,
			campaign_title advertiser
FROM
    ".$logdb.".advertiser_response_tbl
        INNER JOIN
    ".$logdb.".campaign_tbl ON advertiser_response_tbl.campaign_id = campaign_tbl.campaign_id
		INNER JOIN
	".$commondb.".advertiser_tbl ON advertiser_response_tbl.advertiser_id = advertiser_tbl.advertiser_id
WHERE
    ad_resp_id IN (SELECT 
            MAX(ad_resp_id) ad_resp_id
        FROM
            ".$logdb.".advertiser_response_tbl
        WHERE
            ad_resp_datetime >= '".$startdate."'
					AND ad_resp_datetime <= '".$enddate."'
                AND advertiser_response = 'stop'
				".$condition."
                AND clickid NOT IN (SELECT DISTINCT
                    clickid
                FROM
                    ".$logdb.".advertiser_response_tbl
                WHERE
                    ad_resp_datetime >= '".$startdate."'
					AND ad_resp_datetime <= '".$enddate."'
                        AND advertiser_response != 'stop'
						".$condition.")
        GROUP BY clickid )
    
		;";
	$res=$conn->query($sql);


//echo "<script>window.location='report.php';</script>";



}


if(isset($_POST['push']))
{
	$product=$_POST['product']; 
	$operator=$_POST['operator']; 
	
	include("includes/db.php");
	
	$arr=$_POST['item'];
	foreach($arr as $a)
	{
		
		$select_url="select * from ".$logdb.".advertiser_response_tbl where ad_resp_id = '".$a."'";
		$res_url=$conn->query($select_url);
		$row_url=$res_url->fetch();
		
		$response=file_get_contents($row_url['advertiser_callbackurl']);
		//$response="success";
		
	 	$update_url="update ".$logdb.".advertiser_response_tbl set advertiser_response = '".$response."' where ad_resp_id = '".$a."'";
		$res_update_url=$conn->query($update_url);
		
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
                    <h2>Search Report</h2>
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
						
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Country
							<select name="country" class="form-control select2_single" id="country">
								<option>Select</option>
								<?php 
								$sql_country="select distinct country_name,operator_tbl.country_id from ".$commondb.".country_tbl inner join ".$commondb.".operator_tbl on country_tbl.country_id = operator_tbl.country_id ;";
								$res_country=$conn->query($sql_country);
								while($row_country=$res_country->fetch())
								{
									if($row_country['country_id'] == $country)
									{
										$selected="selected";
									}
									else
									{
										$selected= "";
									}
								?>
								<option value="<?php echo $row_country['country_id'] ?>" <?php  echo $selected; ?> ><?php echo $row_country['country_name'] ?></option>
								<?php
								}
								?>
							</select>
						</div>
						
						
						<span id="response1">
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Operator
							
						
						
						<?php
						if($count == 1)
						{
						?>
							<select name="operator" class="form-control select2_single" id="operator" >
								
								
								<?php
								while($row_operator1=$res_operator1->fetch())
								{
									if($row_operator1['operator_id']== $operatorid)
									{
										$selected="selected";
									}
									else
									{
										$selected=""; 
									}
								?>
								<option value="<?php echo $row_operator1['operator_id']; ?>" <?php echo $selected; ?>><?php echo $row_operator1['operator']; ?></option>
								<?php
								}
								?>
												
							</select>
						<?php
						}
						?>
						</div>
						</span>
						
						
						
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser
						<select name="type" class="form-control select2_single" id="pubad">
							<option value='' >Select Publisher / Advertiser</option>
							<option value="Publisher" <?php if($type=='Publisher'){$selected='selected';}else{$selected='';} echo $selected; ?> >Publisher</option>
							<option value="Advertiser" <?php if($type=='Advertiser'){$selected='selected';}else{$selected='';} echo $selected; ?>>Advertiser</option>
							
						</select>
						</div>
						
						<span id="response">
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser Name
						<?php
						if($count == 1)
						{
						?>
							<select name="pubadid" class="form-control select2_single"  id="pubadid" >
								
								<option value="all" >All</option>
								<?php
								while($row1=$res1->fetch())
								{
									if($row1['id']== $id)
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
						<?php
						}
						?>
						</div>
						</span>
						
						
					</div>
					
					<div class="x_content">
						
						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Start Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="start_date" value="<?php if($startdate!=''){echo date('d-m-Y',strtotime($startdate));}else{ echo date('d-m-Y');} ?>"  type="text">
						</div>

						<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> End Date
						<input class="date-picker form-control col-md-7 col-xs-12 birthday" name="end_date" value="<?php if($enddate!=''){echo date('d-m-Y',strtotime($enddate));}else{ echo date('d-m-Y');} ?>" type="text">
						</div>

						
						
						
						<div class="col-md-9 col-sm-9 col-xs-12">
						 
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
			
					  <div class="x_content"  style="overflow:auto;">
						<form method="post">
						<input type="text" hidden value="<?php echo $product; ?>" name="product">
						<input type="text" hidden value="<?php echo $operator; ?>" name="operator">
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<td style="width:10%"><strong>DateTime</strong></td>
									<td style="width:10%"><strong>Publisher</strong></td>
									<td style="width:10%"><strong>Advertiser</strong></td>
									<td style="width:10%"><strong><button type="submit" name="push" class="btn btn-primary btn-sm">Submit</button></strong></td>
									
									
									
								</tr>
							</thead>


							<tbody>
								<?php 
								
								
								
									while($row=$res->fetch())
									{
										
								?>
									<tr>
								
									
										<td  style="width:10%"><?php echo $row['dt'];  ?></td>
										<td style="width:10%"><?php echo $row['publisher']; ?></td>
										<td style="width:10%"><?php echo $row['advertiser']; ?></td>
									<td style="width:10%"> <input type="checkbox" name="item[]" value="<?php echo $row['ad_resp_id']; ?>"> </td>
										
									
										
										
									</tr>
								
								
								
								<?php
									}
								?>
								
							
								
							</tbody>
							
							
								
								
						</table>
						</form>
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

    $("#btn").click(function(){
		
		
			 
			
		
		
    });
});

$(document).ready(function(){

    $("#country").change(function(){
		
		var country=$("#country").val();
		
			$("#operator").val('');
			$("#pubad").val('');
			$("#pubadid").val('');
			$("#temp").hide();
			 
			
		
		
        $.ajax({
            type: "GET",
            url: "ajax/find_operator1.php?country="+country       
			
        }).done(function(data){
            $("#response1").html(data);
			 
        });
    });
});
</script>	
		
		
		
		
<script type="text/javascript">
$(document).ready(function(){

    $("#pubad").change(function(){
		
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
		var pubad = $("#pubad").val();
		
        $.ajax({
            type: "GET",
            url: "ajax/find_publisher_advertiser.php?operator="+operator+"&product="+product+"&pubad="+pubad       
			
        }).done(function(data){
            $("#response").html(data);
			 
        });
    });
});
</script>	