<?php 
include 'global.php';

session_start();

if (isset($_SESSION['usr_login'])) {
	$usr = $_SESSION['usr_login'];
	
	$sql = "SELECT * FROM " . $tables['usr'] . " WHERE username='{$usr}'";
	$res = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($res); // associative array
	
	$login_sess = $row['username'];
	
	// free query result
	mysqli_free_result($res);
	// close connection
	mysqli_close($con);
	$con = null;

} else {
	header('Location: log.htm');
}

?>
