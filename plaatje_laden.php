<?php
include ("ini/connect.php");

$sql = "select plaatje from sch_map.test where test_id=3";
$result = pg_query($con,$sql);
$row = pg_fetch_array($result);

$image = $row['plaatje'];
$image_src = "upload/".$image;

?>
<img src='<?php echo $image_src;  ?>' >
