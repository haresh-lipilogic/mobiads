<?php 
include("../includes/connection.php");

$commondb="commondb";
$operator=strtolower($_GET['operator']);
$product =strtolower($_GET['product']);
$advid=$_GET['advid'];



//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 



include("../includes/db.php");
	
	$sql_pub="select * from ".strtolower($logdb).".pub_blocking_tbl inner join ".$commondb.".advertiser_tbl on pub_blocking_tbl.advertiser_id = advertiser_tbl.advertiser_id where pub_blocking_tbl.advertiser_id='".$advid."' order by pub_blocking_tbl.advertiser_id  ";  
	$res_pub=$conn->query($sql_pub);

	



?>
                          
                        
	<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">  Publisher Name
		<select name="advid" class="form-control select2_single" id="adv" >
			<option value="all" >All</option>
			<?php
			while($row_pub=$res_pub->fetch())
			{
			?>
			<option value="<?php echo $row_pub['id']; ?>"><?php echo $row_pub['name']; ?></option>
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
	
