<?php 
include 'gvars.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['table_name'])) {
	$conn = new Connection($params);
	
	$tname = mysqli_real_escape_string($conn->getConn(), $_GET['table_name']);
	$obj1 = new stdClass();
	
	$sql = "select table_schema, table_name from information_schema.tables where table_name='" . $tname . "'";
	
	$res = $conn->runQuery($sql, 0); // run the sql query
	$count = $res->num_rows;
	
	$adata = array();
	if ($count > 0) {
		while($row = $res->fetch_assoc()) { $adata[] = $row; }
	} else {
		$adata[] = array("table_name" => "Table not found", "table_schema" => "None");
	}
	
	$json_str = json_encode($adata);
	
	$res->free();
	$conn = null;
	
	echo $json_str;
}
?>