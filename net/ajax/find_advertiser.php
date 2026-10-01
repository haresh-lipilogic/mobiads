<?php 
include("../includes/connection.php");

$commondb="commondb";
$operator=$_GET['operator'];
$product = $_GET['product'];



//echo "<script>alert('".$product."');</script>"; 
//echo "<script>alert('".$operator."');</script>"; 

	
	include("../includes/db.php");
	
	
	$sql_op="select * from ".strtolower($commondb).".operator_tbl where operator = '".$operator."'";
	$res_op=$conn->query($sql_op);
	$row_op=$res_op->fetch();
	$op= $row_op['operator_id'];
	
	
	
	
	$sql_camp="select campaign_id id, campaign_title name from ".$logdb.".campaign_tbl  "; 
	$res_camp=$conn->query($sql_camp);


	



?>
                          
                        
	<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">  Publisher Name
		<select name="advid" class="form-control select2_single" >
			<option value="all" >All</option>
			<?php
			while($row=$res_camp->fetch())
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
	
