<?php 
include("../includes/connection.php");


$operator=$_GET['operator'];
$product = $_GET['product'];


//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 

if(strtolower($product) == 'glamour')
{
	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_glamourdb";	
	}
	else
	{
		$logdb=$operator."_glamourdb";	
	}
}
else
{
	if(strtolower($operator) == 'vodafone')
	{
		$logdb="voda_gamesdb";	
	}
	else
	{
		$logdb=$operator."_gamesdb";	
	}
}
	
	
	$sql="select * from ".$logdb.".campaign_tbl where campaign_operator='".$operator."' "; 
	$res=$conn->query($sql);
	
	



?>
                          
                        
	<select name="campaign_id" class="form-control select2_single"  required >
		
		<option value="all">All</option>
		<?php
		while($row=$res->fetch())
		{

		?>
		<option value="<?php echo $row['campaign_id']; ?>"><?php echo $row['campaign_title']; ?></option>
		<?php
		}
		?>
		
	</select>

		
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
	
