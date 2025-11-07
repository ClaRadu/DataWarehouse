<?php 
// global variables
$debug = 0; // 1/0 or true/false

$params = array(
	'srv' => 'localhost',
	'usr' => 'root',
	'pas' => '',
	'dbs' => ''
	);
	
$tables = array(
	'usr' => 'users',
	'mag' => 'magazine',
	'ors' => 'orase',
	'pri' => 'producatori',
	'prd' => 'produse'
	);
	
// establish server connection
$con = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
if (!$con) { die('Could not connect: ' . mysql_error()); }

//$db_list = mysql_list_dbs($con); // deprecated
$db_list = mysqli_query($con, "SHOW DATABASES");

?>

