<?php 
include 'global.php';

// add new data in tables *****************************
if(isset($_POST['table_id'])) {
	$tid = $_POST['table_id'];
	$sav = false;
	
	// establish server connection
	$conn = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
	if (!$conn) { die('Could not connect: ' . mysql_error()); }
	
	switch($tid) {
		case '1': {
			$idors = $_POST['idors'];
			$locmang = $_POST['locmag'];
			$nrtel = $_POST['nrtel'];
			
			if (!empty($idors)) {
				$sql="INSERT INTO magazine (ID_oras, locatie_magazin, numar_telefon)
				VALUES
				('{$idors}', '{$locmang}', '{$nrtel}');";
				$sav = true;
			}
		} break;
		case '2': {
			$numeors = $_POST['numeors'];
			$numejud = $_POST['numejud'];
			
			if (!empty($numeors)) {
				$sql="INSERT INTO orase (nume_oras, nume_judet)
				VALUES
				('{$numeors}', '{$numejud}');";
				$sav = true;
			}
		} break;
		case '3': {
			$numeproduc = $_POST['numeproduc'];
			
			if (!empty($numeproduc)) {
				$sql="INSERT INTO producatori (Nume_producator)
				VALUES
				('{$numeproduc}');";
				$sav = true;
			}
		} break;
		case '4': {
			$numeprod = $_POST['numeprod'];
			$idcatprodp = $_POST['idcatprodp'];
			$idprodp = $_POST['idprodp'];
			
			if (!empty($numeprod)) {
				$sql="INSERT INTO produse (Nume_produs, ID_categorie_produs, ID_producator)
				VALUES
				('{$numeprod}', '{$idcatprodp}', '{$idprodp}');";
				$sav = true;
			}
		} break;
		case '5': {
			$numecateg = $_POST['numecateg'];
			
			if (!empty($numecateg)) {
				$sql="INSERT INTO produse_categorii (nume_categorie)
				VALUES
				('{$numecateg}');";
				$sav = true;
			}
		} break;
		case '6': {
			$idprodv = $_POST['idprodv'];
			$idstorev = $_POST['idstorev'];
			$cantvnz = $_POST['cantvnz'];
			$datavnz = $_POST['datavnz'];
			
			if (!empty($idprodv)) {
				$sql="INSERT INTO vanzari (ID_produs, ID_magazin, cant_vanzari, data_vanzare)
				VALUES
				('{$idprodv}','{$idstorev}','{$cantvnz}','{$datavnz}');";
				$sav = true;
			}
		} break;
		default: {
			echo 'Invalid value selected in `add`!';
		}
	} // end switch
	
	// save data, if the case
	if ($sav) {
		if (mysqli_query($conn, $sql)) {
			echo "Datele au fost adaugate cu succes.<br>";
		} else { die('Error: ' . mysqli_error()); }
	}
	echo "Puteti inchide fereastra.";
	
	// close the connection
	mysqli_close($conn);
}

?>
