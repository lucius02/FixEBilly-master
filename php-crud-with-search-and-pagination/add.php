<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["submit"])) {
    $query = "INSERT INTO toy(name, code, category, price, stock_count) VALUES('".$_POST["name"]."','".$_POST["code"]."','".$_POST["category"]."','".$_POST["price"]."','".$_POST["stock_count"]."')";
        $result = $db_handle->executeQuery($query);
    if(!$result){
			$message="Problem in Adding to database. Please Retry.";
	} else {
		header("Location:index.php");
	}
}
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
<input type="text" name="name" id="name" class="demoInputBox">
</div>
<div>
<label>Code</label>
<span id="code-info" class="info"></span><br/>
<input type="text" name="code" id="code" class="demoInputBox">
</div>
<div>
<label>Category</label> 
<span id="category-info" class="info"></span><br/>
<input type="text" name="category" id="category" class="demoInputBox">
</div>
<div>
<label>Price</label> 
<span id="price-info" class="info"></span><br/>
<input type="text" name="price" id="price" class="demoInputBox">
</div>
<div>
<label>Stock Count</label> 
<span id="stock_count-info" class="info"></span><br/>
<input type="text" name="stock_count" id="stock_count" class="demoInputBox">
</div>
<div>
<input type="submit" name="submit" id="btnAddAction" value="Add" />
</div>
</div>