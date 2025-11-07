<?php // retrieve a row or an entire table
include 'gvars.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['tname'])) {
	$conn = new Connection($params);
	
	$table = mysqli_real_escape_string($conn->getConn(), $_GET['tname']);
	
	if (isset($_GET['row_id'])) {
		$row_id = mysqli_real_escape_string($conn->getConn(), $_GET['row_id']);
		$sql = "SELECT * FROM " . $table . " WHERE ID={$row_id}";
	} else {
		$sql = "SELECT * FROM " . $table;
	}
	
	$result = $conn->runQuery($sql, 0); // run the 1st sql query
	$count = $result->num_rows;
	
	$adat = array();
	if ($count > 0) { // data found
		while($row = $result->fetch_assoc()) { $adat[] = $row; }
	} else { // nothing to show
		$adat[] = array("table_name" => "No data found");
	}
	
	$json_str = json_encode($adat);
	
	$result->free();
	$conn = null;
	
	echo $json_str;
}
?>