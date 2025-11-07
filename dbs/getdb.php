<?php 
include 'gvars.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['db_name'])) {
	$conn = new Connection($params);
	
	$dbname = $_GET['db_name'];
	$obj1 = new stdClass();
	
	// check if database exists
	if ($conn->exists($dbname, 'DATABASES')) { $obj1->status = 'found'; }
	else { $obj1->status = 'missing'; }
	
	$json_str = json_encode($obj1);
	
	$conn = null;
	
	echo $json_str;
}

?>