<?php
include("ini/connect.php");

if(isset($_POST['plaatje'])){
 
  $name = $_FILES['plaatje']['name'];
  $target_dir = "upload/";
  $target_file = $target_dir . basename($_FILES["plaatje"]["name"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){
 
    // Convert to base64 
    $image_base64 = base64_encode(file_get_contents($_FILES['plaatje']['tmp_name']) );
    $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
    // Insert record
    $query = "insert into sch_map.test(plaatje) values('".$image."')";
    pg_query($con,$query);
  }
 
}
?>

<form method="post" action="" enctype='multipart/form-data'>
  <input type='file' name='plaatje' />
  <input type='submit' value='Save name' name='plaatje'>
</form>

<?php

 $sql = "select plaatje from sch_map.test";
 $result = pg_query($con,$sql);
 $row = pg_fetch_array($result);

 $image_src = $row['plaatje'];
 
?>
<img src='<?php echo $image_src; ?>' >