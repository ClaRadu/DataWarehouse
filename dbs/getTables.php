<?php 
include 'gvars.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$conn = new Connection($params);
	
	$sql = "SELECT TABLE_SCHEMA, TABLE_TYPE, TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME='ratings' AND TABLE_SCHEMA='" . $params['dbs'] . "'";
	
	$result = $conn->runQuery($sql, 0); // run the 1st sql query
	$count = $result->num_rows;
	
	if ($count > 0) { // table found
		$stfd = "SELECT * FROM ratings ORDER BY rating DESC";
	} else {
		$stfd = "SHOW TABLES FROM " . $params['dbs'];
	}
	$result->free();
	
	// run the 2nd query
	$res = $conn->runQuery($stfd, 0);
	
	$adat = array();
	if ($res->num_rows > 0) {
		while($row = $res->fetch_assoc()) { $adat[] = $row; }		
	} else {
		$adat[] = array("table_name" => "No tables found");
	}
	
	$json_str = json_encode($adat);
	
	$res->free();
	$conn = null;
	
	echo $json_str;
}
?>