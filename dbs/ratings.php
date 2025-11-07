<?php 
// update the ratings

require "gvars.php";

// if the first entry exist means all entries exist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['magazine'])) { 
	// create db object
	$conn = new Connection($params);
	
	// get all ratings
	$tables = array();
	$magval = mysqli_real_escape_string($conn->getConn(), $_POST['magazine']);
	$tables[] = array('name' => 'magazine', 'rating' => $magval);
	$prodval = mysqli_real_escape_string($conn->getConn(), $_POST['producatori']);
	$tables[] = array('name' => 'producatori', 'rating' => $prodval);
	$orsval = mysqli_real_escape_string($conn->getConn(), $_POST['orase']);
	$tables[] = array('name' => 'orase', 'rating' => $orsval);
	$prodsval = mysqli_real_escape_string($conn->getConn(), $_POST['produse']);
	$tables[] = array('name' => 'produse', 'rating' => $prodsval);
	$usrval = mysqli_real_escape_string($conn->getConn(), $_POST['users']);
	$tables[] = array('name' => 'users', 'rating' => $usrval);
	$vanzval = mysqli_real_escape_string($conn->getConn(), $_POST['vanzari']);
	$tables[] = array('name' => 'vanzari', 'rating' => $vanzval);
	
	$sql = "";
	$errmsg = "";
	$res = null;
	$errcnt = 0;
	$len = count($tables);
	for ($i=0; $i<$len; $i++) {
		$sql = "UPDATE ratings SET rating = rating + " . $tables[$i]['rating'] . " WHERE table_name='" . $tables[$i]['name'] . "'";
		try {
			$res = $conn->runQuery($sql, 0);
//			$res->free();
		} catch(Exception $e) {
			$errmsg .= "Failed to update table no." . $i . " -> " . $e . "\n";
			$errcnt += 1;
		}
	}
	
	if ($errcnt > 0) {
		echo "Ratings updated with errors: \n" . $errmsg;
	} else {
		echo "All ratings updated successfully!";
	}
	
	$conn = null;
} else {
	echo "Error encountered while making the request!";
} // end req. method

?>