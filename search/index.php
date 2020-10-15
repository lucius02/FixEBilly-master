<?php
	require_once("perpage.php");	
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	
	$onderwerp = "";
	$wat = "";	
	$why = "";
	$how = "";
	$niveau = "";

	$queryCondition = "";
	if(!empty($_POST["search"])) {
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("onderwerp","wat", "why", "how", "niveau");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " AND ";
					} else {
						$queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "onderwerp":
						$onderwerp = $v;
						$queryCondition .= "onderwerp LIKE '" . $v . "%'";
						break;
					case "wat":
						$wat = $v;
						$queryCondition .= "wat LIKE '" . $v . "%'";
						break;
					case "why":
						$why = $v;
						$queryCondition .= "why LIKE '" . $v . "%'";
						break;
					case "how":
						$how = $v;
						$queryCondition .= "how LIKE '" . $v . "%'";
						break;
					case "niveau":
							$niveau = $v;
							$queryCondition .= "niveau LIKE '" . $v . "%'";
							break;
					case "filter":
						$niveau = $_POST["niveau"]["search_in"];
						break;
				}
			}
		}
	}

	$pdocrud = new PDOCrud();
	//add Filter ("unique-filter-name", "Filter display name", "column name to be matched","type of filter")
	$pdocrud->addFilter("product_cat_filter", "Product Category", "product_cat", "radio");
	//set data for filter ("unique-filter-name",array of data or table,key (if source=db),value (if source=db), "source_type") 
	$pdocrud->setFilterSource("product_cat_filter", array("Electronic" => "Electronic", "Fashion" => "Fashion"), "", "", "array");
	
	$pdocrud->addFilter("ProductLineFilter", "Product Line", "product_line", "dropdown");
	$pdocrud->setFilterSource("ProductLineFilter", "products", "product_line", "product_line as pl", "db");
	
	$pdocrud->addFilter("ProductVendorFilter", "Vendor", "ProductVendor", "text");
	$pdocrud->setFilterSource("ProductVendorFilter", "", "", "", "");
	
	echo $pdocrud->dbTable("products")->render();

	$orderby = " ORDER BY kenniskaart_id desc"; 
	$sql = "SELECT * FROM sch_map.kenniskaart " . $queryCondition;
	$href = 'index.php';					
		
	$perPage = 2; 
	$page = 1;
	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}
	$start = ($page-1)*$perPage;
	if($start < 0) $start = 0;
		
	$query =  $sql . $orderby .  " limit " . $start . $perPage; 
	$result = $db_handle->runQuery($query);
	
	if(!empty($result)) {
		$result["perpage"] = perpage($sql, $perPage, $href);
	}
?>

<html>
	<head>
		<title>Zoeken</title>
		<link href="style.css" type="text/css" rel="stylesheet"/>
	</head>
	<body>
		<h2>PHP CRUD with Search and Pagination</h2>
		<div id="toys-grid">      
			<form name="frmSearch" method="post" action="index.php">
			<div class="search-box">
				<p>
					<input type="text" id="mysearch" placeholder="onderwerp" name="search[onderwerp]" class="demoInputBox" value="<?php echo $onderwerp; ?>"/>
					<input type="text" id="mysearch" placeholder="wat" name="search[wat]" class="demoInputBox" value="<?php echo $wat; ?>"/>
					<input type="text" id="mysearch" placeholder="why" name="search[why]" class="demoInputBox" value="<?php echo $why; ?>"/>
					<input type="text" id="mysearch" placeholder="how" name="search[how]" class="demoInputBox" value="<?php echo $how; ?>"/>
					<div>
						<select name="niveau[search_in]" id="search_in" class="demoInputBox">
							<option value="">Select Column</option>
							<option value="niveau" <?php if($niveau=="niveau") { echo "selected"; } ?>>beginner</option>
							<option value="niveau" <?php if($niveau=="niveau") { echo "selected"; } ?>>Gevorderde</option>
							<option value="niveau" <?php if($niveau=="niveau") { echo "selected"; } ?>>Expert</option>
						</select>
					</div> 
					<input type="submit" name="go" class="btnSearch" value="Search">
					<input type="reset" class="btnSearch" value="Reset" onclick="window.location='index.php'">
				</p>
				</div>
			
			<table cellpadding="10" cellspacing="1">
				<thead>
					<tr>
						<th><strong>Onderwerp</strong></th>
						<th><strong>Rol</strong></th>          
						<th><strong>Competentie</strong></th>
						<th><strong>Wat</strong></th>
						<th><strong>Why</strong></th>
						<th><strong>How</strong></th>
						<th><strong>Plaatje</strong></th>
						<th><strong>Bronnen</strong></th>
						<th><strong>Niveau</strong></th>
						<th><strong>Studieduur</strong></th>
						<th><strong>Rating</strong></th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($result)) {
						foreach($result as $k=>$v) {
						  if(is_numeric($k)) {
					?>
					<tr>
						<td><?php echo $result[$k]["onderwerp"]; ?></td>
						<td><?php echo $result[$k]["rol"]; ?></td>
						<td><?php echo $result[$k]["competentie"]; ?></td>
						<td><?php echo $result[$k]["wat"]; ?></td>
						<td><?php echo $result[$k]["why"]; ?></td>
						<td><?php echo $result[$k]["how"]; ?></td>
						<td><img src='<?php echo $result[$k]["plaatje"]; ?>' ></td> 
						<td><?php echo $result[$k]["bronnen"]; ?></td>
						<td><?php echo $result[$k]["niveau"]; ?></td>
						<td><?php echo $result[$k]["studieduur"]; ?></td>
						<td><?php echo $result[$k]["rating"]; ?></td>
					</tr>
					<?php
						  }
					   }
                    }
					if(isset($result["perpage"])) {
					?>
					<tr>
					<td colspan="6" align=right> <?php echo $result["perpage"]; ?></td>
					</tr>
					<?php } ?>
				<tbody>
			</table>
			</form>	
		</div>
	</body>
</html>