<?php 
include("../includes/connection.php");

//$commondb="commondb";
$operator=$_GET['operator'];
$partner = $_GET['partner'];

if($partner=='svmobi')
{
	$ad='commondbthailand';
}
else{
	$ad='aggregatorthailand';
}

//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 
if($operator=='ais' )
{
	
	$sql11="select * from ".$ad.".advertiser where operator=1";
	//$res11=mysql_query($sql11);
	
}
else if($operator=='dtac' )
{
	
	$sql11="select * from ".$ad.".advertiser where operator=2";
	//$res11=mysql_query($sql11);
}
elseif($operator=='truemove' )
{
	
	$sql11="select * from ".$ad.".advertiser where operator=3";
	//$res11=mysql_query($sql11);
}
else{
	$sql11="select * from ".$ad.".advertiser";
}

	$res11=$conn->query($sql11);
	
	
	//while($row_ad=$res11->fetch())
	
	



?>
                          
                        
	
   
                          
                        
	<select name="advertiser" class="form-control select2_single" >
		<option value="all">All</option>
		<?php
		while($row_ad=$res11->fetch())
		{
			
		?>
		<option value="<?php echo $row_ad['advertiserid']; ?>"><?php echo $row_ad['advertiser_name']; ?></option>
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
	
	
	
	
	
	
	