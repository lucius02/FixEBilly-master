<?php
class DBController {
    private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = pg_connect("host=localhost dbname=EBilly user=postgres password=WelKom7993");
		return $conn;
	}
	
	function runQuery($query) {
		$result = pg_query($this->conn,$query);
		while($row=pg_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = pg_query($this->conn, $query);
		$rowcount = pg_num_rows($result);
		return $rowcount;	
	}
	
	function executeQuery($query) {
	    $result  = pg_query($this->conn, $query);
	    return $result;	
	}
}
?>
