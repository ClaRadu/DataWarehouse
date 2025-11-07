<?php 
include 'gvars.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['show_dbs'])) {
	$conn = new Connection($params);
	
	$dbstat = $_GET['show_dbs'];
	$sql = "SHOW DATABASES";
	
	$res = $conn->runQuery($sql, 0); // run the sql query
	$count = $res->num_rows;
	
	$adat = array();
	if ($dbstat == 'OK' && $count > 0) {
		while($row = $res->fetch_assoc()) { $adat[] = $row; }
	} else {
		$adat[] = array("Database" => "No databases found");
	}
	
	$json_str = json_encode($adat);
	
	$res->free();
	$conn = null;
	
	echo $json_str;
}

?>