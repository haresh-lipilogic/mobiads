<?php 
include("../includes/connection.php");


$operator=strtolower($_GET['operator']);
$product = strtolower($_GET['product']);
$pubad=$_GET['pubad'];


//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 


	if(strtolower($operator) == 'vodafone')
		{
			$logdb="voda_".$product."db";	
		}
		else
		{
			$logdb=$operator."_".$product."db";	
		}
	
	
if(strtolower($pubad) == 'advertiser')
{
	$sql="select campaign_title name, campaign_id id from ".$logdb.".campaign_tbl  "; 
	$res=$conn->query($sql);

}
else
{
	$sql="select advertiser_name name , advertiser_id id from commondb.advertiser_tbl "; 
	$res=$conn->query($sql);
}	
	
	



?>
                          
                        
	<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback"> Publisher / Advertiser Name
		<select name="pubadid" class="form-control select2_single" >
			<option value="all" >All</option>
			<?php
			while($row=$res->fetch())
			{
			?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
			<?php
			}
			?>
							
		</select>
	</div>

		
<!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->
	
