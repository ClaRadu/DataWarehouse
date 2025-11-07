<?php 
// update the selected row

require "gvars.php";

// if the first entry exist means all entries exist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['row_id'])) { 
	// create db object
	$conn = new Connection($params);
	
	//get table id
	$row_id = mysqli_real_escape_string($conn->getConn(), $_POST['row_id']);
	// get table name
	$table = mysqli_real_escape_string($conn->getConn(), $_POST['tbl_name']);
	
	$sql = "";
	$save = true;
	switch($table) {
		case 'magazine':
			$idors = mysqli_real_escape_string($conn->getConn(), $_POST['ID_oras']);
			$locmag = mysqli_real_escape_string($conn->getConn(), $_POST['locatie_magazin']);
			$nrtel = mysqli_real_escape_string($conn->getConn(), $_POST['numar_telefon']);
			$sql = "UPDATE " . $table . " SET ID_oras={$idors}, locatie_magazin='{$locmag}', numar_telefon='{$nrtel}' WHERE ID={$row_id}";
			if (empty($locmag)) { $save = false; }
			break;
		case 'producatori':
			$numprod = mysqli_real_escape_string($conn->getConn(), $_POST['Nume_producator']);
			$sql = "UPDATE " . $table . " SET Nume_producator='{$numprod}' WHERE ID={$row_id}";
			if (empty($numprod)) { $save = false; }
			break;
		case 'orase':
			$numors = mysqli_real_escape_string($conn->getConn(), $_POST['nume_oras']);
			$numjud = mysqli_real_escape_string($conn->getConn(), $_POST['nume_judet']);
			$sql = "UPDATE " . $table . " SET nume_oras='{$numors}', nume_judet='{$numjud}' WHERE ID={$row_id}";
			if (empty($numors)) { $save = false; }
			break;
		case 'produse':
			$numprod = mysqli_real_escape_string($conn->getConn(), $_POST['Nume_produs']);
			$catprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_categorie_produs']);
			$idprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_producator']);
			$sql = "UPDATE " . $table . " SET Nume_produs='{$numprod}', ID_categorie_produs={$catprod}, ID_producator={$idprod} WHERE ID={$row_id}";
			if (empty($numprod)) { $save = false; }
			break;
/*		case 'users':
			break;*/
		case 'vanzari':
			$idprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_produs']);
			$idmag = mysqli_real_escape_string($conn->getConn(), $_POST['ID_magazin']);
			$cantvnz = mysqli_real_escape_string($conn->getConn(), $_POST['cant_vanzari']);
			$dtvnz = mysqli_real_escape_string($conn->getConn(), $_POST['data_vanzare']);
			$sql = "UPDATE " . $table . " SET ID_produs={$idprod}, ID_magazin={$idmag}, cant_vanzari={$cantvnz}, data_vanzare='{$dtvnz}' WHERE ID={$row_id}";
			if (empty($cantvnz)) { $save = false; }
			break;
	}
	
	
	if ($save) {
		$result = $conn->runQuery($sql, 0);

		if ($result === TRUE) { // new entry added
			echo "Row updated successfully in " . $table . " table.";
		}
	} else {
		echo "Data cannot be updated in " . $table . " table!";
	}
	
	$conn = null;
} // end req. method

?>