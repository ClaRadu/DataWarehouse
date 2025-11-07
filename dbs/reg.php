<?php 
// register a new user

require "gvars.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// create db object
	$conn = new Connection($params);
	
	// username and password sent from form
	$u = mysqli_real_escape_string($conn->getConn(), $_POST['username']);
	$p1 = mysqli_real_escape_string($conn->getConn(), $_POST['password1']);
	$p2 = mysqli_real_escape_string($conn->getConn(), $_POST['password2']);
	
	$sql = "SELECT * FROM " . $tables['usr'] . " WHERE username='" . $u . "'";
	$result = $conn->runQuery($sql, 0); // sel_usr

	if ($result && $result->num_rows > 0) {
		echo "User allready exists. Please select another username.";
	} else {
		if ($u != "") {
			$sqli = "INSERT INTO " . $tables['usr'] . " (username, password) VALUES ('$u', '" . 
				sha1($p1) . "')";
			$resi = $conn->runQuery($sqli, 0);

			if ($resi === TRUE) { // new user created
				// check if user wants to login with the newly created usename and pass
				echo "<form name='loginfrm' action='dbs/log.php' method='post'>";
				echo "<input type='hidden' name='username' value='" . $u . "'>";
				echo "<input type='hidden' name='password' value='" . $p1 . "'>";
				echo "Hello " . $u . ", proceed to main page: ";
				echo "<input type='submit' class='w3-button w3-blue w3-border w3-round' value='Continue'>";
				echo "</form>";
			}
//			else echo "Error: " . $sqli . "<br>" . $conn->error;
		} else {
			echo "Username not valid!";
		}
	}
	
	$result->free();
	$conn = null;
} // end req. method

?>