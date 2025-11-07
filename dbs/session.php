<?php 
// verifies the session, if there is no session it will redirect to the login page
// thanks to: https://www.tutorialspoint.com/php/php_mysql_login.htm

include 'gvars.php';

session_start();

if (!isset($_SESSION['usr_login'])) { 
	header('Location: login.html');
} else {
	$usr = $_SESSION['usr_login'];

	$conn = new Connection($params);

	$sql = "select * from users where username='$usr'";
//	$s_res = $conn->getConn()->query($sql);
	$s_res = $conn->runQuery($sql, 0); // select_ses
	$s_row = $s_res->fetch_array(MYSQLI_ASSOC); // associative array

	$login_session = $s_row['username']; // user

	$conn = null;
}

?>