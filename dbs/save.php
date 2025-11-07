<?php 
// insert new data in the selected table

require "gvars.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// create db object
	$conn = new Connection($params);
	
	// table name
	$table_name = mysqli_real_escape_string($conn->getConn(), $_POST['tbl_name']);
	
	$sql = "";
	$save = true;
	switch($table_name) {
		case 'magazine':
			$idors = mysqli_real_escape_string($conn->getConn(), $_POST['ID_oras']);
			$locmag = mysqli_real_escape_string($conn->getConn(), $_POST['locatie_magazin']);
			$nrtel = mysqli_real_escape_string($conn->getConn(), $_POST['numar_telefon']);
			$sql = "INSERT INTO " . $table_name . " (ID_oras, locatie_magazin, numar_telefon) VALUES ('$idors', '$locmag', '$nrtel')";
			if (empty($locmag)) { $save = false; }
			break;
		case 'producatori':
			$numprod = mysqli_real_escape_string($conn->getConn(), $_POST['Nume_producator']);
			$sql = "INSERT INTO " . $table_name . " (Nume_producator) VALUES ('$numprod')";
			if (empty($numprod)) { $save = false; }
			break;
		case 'orase':
			$numors = mysqli_real_escape_string($conn->getConn(), $_POST['nume_oras']);
			$numjud = mysqli_real_escape_string($conn->getConn(), $_POST['nume_judet']);
			$sql = "INSERT INTO " . $table_name . " (nume_oras, nume_judet) VALUES ('$numors', '$numjud')";
			if (empty($numors)) { $save = false; }
			break;
		case 'produse':
			$numprod = mysqli_real_escape_string($conn->getConn(), $_POST['Nume_produs']);
			$catprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_categorie_produs']);
			$idprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_producator']);
			$sql = "INSERT INTO " . $table_name . " (Nume_produs, ID_categorie_produs, ID_producator) VALUES ('$numprod', '$catprod', '$idprod')";
			if (empty($numprod)) { $save = false; }
			break;
/*		case 'users':
			break;*/
		case 'vanzari':
			$idprod = mysqli_real_escape_string($conn->getConn(), $_POST['ID_produs']);
			$idmag = mysqli_real_escape_string($conn->getConn(), $_POST['ID_magazin']);
			$cantvnz = mysqli_real_escape_string($conn->getConn(), $_POST['cant_vanzari']);
			$dtvnz = mysqli_real_escape_string($conn->getConn(), $_POST['data_vanzare']);
			$sql = "INSERT INTO " . $table_name . " (ID_produs, ID_magazin, cant_vanzari, data_vanzare) VALUES ('$idprod', '$idmag', '$cantvnz', '$dtvnz')";
			if (empty($cantvnz)) { $save = false; }
			break;
	}
	
	
	if ($save) {
		$result = $conn->runQuery($sql, 0);

		if ($result === TRUE) { // new entry added
			echo "New row added successfully in " . $table_name . " table.";
		}
	} else {
		echo "Data cannot be added into " . $table_name . " table!";
	}
	
	$conn = null;
} // end req. method

?>