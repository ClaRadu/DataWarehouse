<?php 
require 'global.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usrname = $_POST['username'];
	$usrpass = $_POST['password'];
	
	$user = mysqli_real_escape_string($con, $usrname);
	$pass = mysqli_real_escape_string($con, $usrpass);
	
	$sql = "SELECT id FROM " . $tables['usr'] . " WHERE username='{$user}' AND password='" . sha1($pass) . "'";
	$res = mysqli_query($con, $sql);
//	$row = mysqli_fetch_assoc($res); // associative array
	
	// table should have 1 row
	if(mysqli_num_rows($res) == 1) {
		$_SESSION['usr_login'] = $user;
		header('Location: ../db_home.php');
	} else {
		echo "Your username or password is incorrect!";
		echo "&nbsp;<a href='../log.htm'>Go Back</a>";
	}
	
	mysqli_free_result($res);
}

?>
