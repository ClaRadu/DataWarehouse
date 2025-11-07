<?php 
// session logout

include 'gvars.php';

session_start();
if (session_destroy()) { 
	// create db conn. object
	$conn = new Connection($params);
	
	// total the ratings
	$sqls = "SELECT SUM(rating) AS sumrating FROM ratings";
	
	$result = $conn->runQuery($sqls, 0); // run the 1st sql query
	$count = $result->num_rows;
	
	$tot = 0;
	$max = 100;
	if ($count > 0) { // data found
		while($row = $result->fetch_assoc()) { $tot += $row['sumrating']; } // update totals
		
		if ($tot > $max) {
			// halfen all ratings, if the case
			$sqlu = "UPDATE ratings SET rating = ROUND(rating / 2) WHERE rating>1";
			$res = $conn->runQuery($sqlu, 0);
			// check if update worked
			if ($res === TRUE) { 
				echo "Ratings updated successfully.";
			} else {
				echo "Error while updating ratings.";
			}
		}
	}
	$result->free();
	$conn = null;
	
	// redirect to login page
	header('Location: ../login.html');
}

?>
