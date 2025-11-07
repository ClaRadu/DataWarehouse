<?php 
// session login

include 'gvars.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// create db object
	$conn = new Connection($params);
	
	// username and password sent from form
	$rec_username = mysqli_real_escape_string($conn->getConn(), $_POST['username']);
	$rec_pass = mysqli_real_escape_string($conn->getConn(), $_POST['password']);
	
	$sql = "select id from " . $tables['usr'] . " where username='" . $rec_username . "' and 
		password='" . sha1($rec_pass) . "'";
		
	$res = $conn->runQuery($sql, 0); // sel_usr
	$row = $res->fetch_assoc(); // get result as associative array
	$count = $res->num_rows;
	
	// if results matched, table row should be 1
	if ($count == 1) {
		$_SESSION['usr_login'] = $rec_username;
		
		header('Location: ../db_main.php');
	} else {
		if ($debug) { // only for debug
			$error = "You username or password is invalid. u=$rec_username & p=$rec_pass.";
		} else {
			$error = "You username or password is invalid.";
		}
	}
	
	$res->free();
	$conn = null;
	
}

echo $error;
echo "&nbsp;<a href='../login.html'>Go Back</a>";

?>