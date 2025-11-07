<?php 
require 'global.php';

$usrname = $_POST['username'];
$usrpass = $_POST['password'];

$name = mysqli_real_escape_string($con, $usrname);
$pass = mysqli_real_escape_string($con, $usrpass);

$sqlq = "SELECT * FROM " . $tables['usr'] . " WHERE username='{$name}'";
$res = mysqli_query($con, $sqlq) or die(mysqli_error());
$num = mysqli_fetch_array($res);

if ($num > 0) { echo 'Username already exists. Please select another username.'; }
else { 
	if ($name != "") {
		$sqli = "INSERT INTO " . $tables['usr'] . " (username, password) VALUES ('{$name}', '" . 
		sha1($pass) . "')";
		if (mysqli_query($con, $sqli)) {
			echo 'User created successfully!';
		} else {
			die('Error: ' . mysqli_error());
		}
	}
}
echo "&nbsp;<a href='../log.htm'>Go to Login</a>";

?>
