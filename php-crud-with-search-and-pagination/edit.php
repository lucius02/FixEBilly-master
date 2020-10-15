<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["submit"])) {
    $query = "UPDATE toy set name = '".$_POST["name"]."', code = '".$_POST["code"]."', category = '".$_POST["category"]."', price = '".$_POST["price"]."', stock_count = '".$_POST["stock_count"]."' WHERE  id=".$_GET["id"];
    $result = $db_handle->executeQuery($query);
	if(!$result){
		$message = "Problem in Editing! Please Retry!";
	} else {
		header("Location:index.php");
	}
}
$result = $db_handle->runQuery("SELECT * FROM toy WHERE id='" . $_GET["id"] . "'");
?>
<link href="style.css" type="text/css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function validate() {
	var valid = true;	
	$(".demoInputBox").css('background-color','');
	$(".info").html('');
	
	if(!$("#name").val()) {
		$("#name-info").html("(required)");
		$("#name").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#code").val()) {
		$("#code-info").html("(required)");
		$("#code").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#category").val()) {
		$("#category-info").html("(required)");
		$("#category").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#price").val()) {
		$("#price-info").html("(required)");
		$("#price").css('background-color','#FFFFDF');
		valid = false;
	}	
	if(!$("#stock_count").val()) {
		$("#stock_count-info").html("(required)");
		$("#stock_count").css('background-color','#FFFFDF');
		valid = false;
	}	
	return valid;
}
</script>
<form name="frmToy" method="post" action="" id="frmToy" onClick="return validate();">
<div id="mail-status"></div>
<div>
<label style="padding-top:20px;">Name</label>
<span id="name-info" class="info"></span><br/>
<input type="text" name="name" id="name" class="demoInputBox" value="<?php echo $result[0]["name"]; ?>">
</div>
<div>
<label>Code</label>
<span id="code-info" class="info"></span><br/>
<input type="text" name="code" id="code" class="demoInputBox" value="<?php echo $result[0]["code"]; ?>">
</div>
<div>
<label>Category</label> 
<span id="category-info" class="info"></span><br/>
<input type="text" name="category" id="category" class="demoInputBox" value="<?php echo $result[0]["category"]; ?>">
</div>
<div>
<label>Price</label> 
<span id="price-info" class="info"></span><br/>
<input type="text" name="price" id="price" class="demoInputBox" value="<?php echo $result[0]["price"]; ?>">
</div>
<div>
<label>Stock Count</label> 
<span id="stock_count-info" class="info"></span><br/>
<input type="text" name="stock_count" id="stock_count" class="demoInputBox" value="<?php echo $result[0]["stock_count"]; ?>">
</div>
<div>
<input type="submit" name="submit" id="btnAddAction" value="Save" />
</div>
</div>