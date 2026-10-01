<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");
$country=$_GET['country'];

$sql_operator="select distinct operator,operator_id from ".$commondb.".operator_tbl where country_id = $country "; 
$res_operator=$conn->query($sql_operator);
?>




<div class="col-md-2 col-sm-2 col-xs-12 form-group has-feedback">  Operator


		<select name="operator" class="form-control select2_single" id="operator">
			<option value="all" >All</option>
			<?php
			while($row_operator=$res_operator->fetch())
			{
			?>
			<option value="<?php echo $row_operator['operator_id']; ?>"><?php echo $row_operator['operator']; ?></option>
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