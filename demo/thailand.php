<?php

include("includes/connection.php");

$sql="SELECT 
    COUNT(clickid) clicks, 0 act, DATE(accesstime) dt, 0 dct, 0 cbs, 0 cbr
FROM
    (SELECT DISTINCT
        clickid, accesstime
    FROM
        fashionbardb_thailand.userlog
    WHERE
        accesstime >= '2017-05-26 00:00:00'
            AND accesstime <= '2017-05-26 23:59:59') a
GROUP BY dt 
UNION SELECT 
    0 clicks,
    COUNT(clickid) act,
    DATE(subscriptionstartdate) dt,
    0 dct,
    0 cbs,
    0 cbr
FROM
    (SELECT DISTINCT
        clickid, subscriptionstartdate
    FROM
        fashionbardb_thailand.subscriber
    WHERE
        subscriptionstartdate >= '2017-05-26 00:00:00'
            AND subscriptionstartdate <= '2017-05-26 23:59:59'
            AND charging_mode = 'act') b
GROUP BY dt 
UNION SELECT 
    0 clicks,
    0 act,
    DATE(subscriptionstartdate) dt,
    COUNT(clickid) dct,
    0 cbs,
    0 cbr
FROM
    (SELECT DISTINCT
        clickid, subscriptionstartdate
    FROM
        fashionbardb_thailand.subscriber
    WHERE
        subscriptionstartdate >= '2017-05-26 00:00:00'
            AND subscriptionstartdate <= '2017-05-26 23:59:59'
            AND charging_mode = 'dct') b
GROUP BY dt 
UNION SELECT 
    0 clicks,
    0 act,
    DATE(advertdatetime) dt,
    0 dct,
    count(clickid) cbs,0 cbr
FROM
    (SELECT DISTINCT
        clickid, advertdatetime
    FROM
        fashionbardb_thailand.advertcallback
    WHERE
        advertdatetime >= '2017-05-26 00:00:00'
            AND advertdatetime <= '2017-05-26 23:59:59'
           ) b
GROUP BY dt
UNION SELECT 
    0 clicks,
    0 act,
    DATE(subscriptionstartdate) dt,
    0 dct,
    0 cbs,
    count(clickid) cbr
FROM
    (SELECT DISTINCT
        clickid, subscriptionstartdate
    FROM
        fashionbardb_thailand.subscriber
    WHERE
        subscriptionstartdate >= '2017-05-26 00:00:00'
            AND subscriptionstartdate <= '2017-05-26 23:59:59'
            and charging_mode = 'act'
           ) b
GROUP BY dt
;";


$res=$conn->query($sql);

?>

<html>

<input type="date"  >
<table border = '1'>
<tr>
	<td>Date<td>
	<td>Clickd<td>
	<td>Activation<td>
	<td>Deactivation<td>
	<td>CBS<td>
	<td>CBR<td>
</tr>

<?php
while($row=$res->fetch())
{
?>
<tr>
	<td><?php echo $row['dt']; ?><td>
	<td><?php echo $row['clicks']; ?><td>
	<td><?php echo $row['act']; ?><td>
	<td><?php echo $row['dct']; ?><td>
	<td><?php echo $row['cbs']; ?><td>
	<td><?php echo $row['cbr']; ?><td>
</tr>
<?php
}
?>

</table>

</html>