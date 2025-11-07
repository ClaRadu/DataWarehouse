<?php 
// delete the selected row

require "gvars.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['row_id'])) {
	// create db object
	$conn = new Connection($params);
	
	// table name
	$table_name = mysqli_real_escape_string($conn->getConn(), $_POST['tbl_name']);
	// row id
	$row_id = mysqli_real_escape_string($conn->getConn(), $_POST['row_id']);
	
	$sql = "";
	if(!empty($table_name) && !empty($row_id)) { $sql = "DELETE FROM " . $table_name . " WHERE ID={$row_id}"; }
	
	if ($sql != "") {
		$result = $conn->runQuery($sql, 0);

		if ($result === TRUE) { // new entry added
			echo "Row with ID: " . $row_id . " from table " . $table_name . " was deleted successfully.";
		}
	} else {
		echo "Data cannot be deleted from the " . $table_name . " table!";
	}
	
	$conn = null;
} else {
	echo "Error encountered while making the delete request!";
} // end req. method

?>