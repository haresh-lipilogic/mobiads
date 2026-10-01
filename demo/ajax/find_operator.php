<?php
include("../includes/connection.php");
include("../includes/language_cpi.php");
$country=$_GET['country'];

$sql_operator="select distinct operator from ".$commondb.".operator_tbl where country_id = $country ";
$res_operator=$conn->query($sql_operator);
?>
<input type="checkbox" id="allop"> All &nbsp;&nbsp;	
<?php
while($row_operator=$res_operator->fetch())
{
?>
<input type="checkbox" name="operator[]" class="op" value="<?php echo $row_operator['operator']; ?>"> <?php echo $row_operator['operator']; ?> &nbsp;&nbsp;
<?php
}

?>
<!-- Select all Operator -->
<script type="text/javascript">
$(document).ready(function () {
    $("#allop").click(function () {
        $(".op").prop('checked', $(this).prop('checked'));
    });
});
</script>