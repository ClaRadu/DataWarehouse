<?php 
include 'global.php';

// update data from tables *****************************
if(isset($_POST['table_id'])) {
	$tid = $_POST['table_id'];
	
	// establish server connection
	$conn = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
	if (!$conn) { die('Could not connect: ' . mysql_error()); }
	
	switch($tid) {
		case '1': {
			$sidm = $_POST['nidmag'];
			$sidors = $_POST['nidors'];
			$slocmag = $_POST['nlocmag'];
			$stel = $_POST['nnrtel'];

			if ($sidm!=0) {
				if ($sidors!=0) {
					mysqli_query($conn, "UPDATE magazine SET ID_oras='{$sidors}' WHERE ID='{$sidm}'") or die (mysqli_error());
				}
				if ($slocmag!='') {
					mysqli_query($conn, "UPDATE magazine SET locatie_magazin='{$slocmag}' WHERE ID='{$sidm}'") or die (mysqli_error());
				}
				if ($stel!=0) {
					mysqli_query($conn, "UPDATE magazine SET numar_telefon='{$stel}' WHERE ID='{$sidm}'") or die (mysqli_error());
				}
			}
		} break;
		case '2': {
			$sidp = $_POST['nidprod'];
			$snumep = $_POST['nnumeprod'];
			$sidcatp = $_POST['nidcatprod'];
			$sidprod = $_POST['nidproduc'];
  
			if ($sidp!=0) {
				if ($snumep!='') {
					mysqli_query($conn, "UPDATE produse SET Nume_produs='{$snumep}' WHERE ID='{$sidp}'") or die (mysqli_error());
				}
				if ($sidcatp!=0) {
					mysqli_query($conn, "UPDATE produse SET ID_categorie_produs='{$sidcatp}' WHERE ID='{$sidp}'") or die (mysqli_error());
				}
				if ($sidprod!=0) {
					mysqli_query($conn, "UPDATE produse SET ID_producator='{$sidprod}' WHERE ID='{$sidp}'") or die (mysqli_error());
				}
			}
		} break;
		case '3': {
			$sidv = $_POST['nidvnz'];
			$sidprodv = $_POST['nidprodv'];
			$sidstorev = $_POST['nidstorev'];
			$scantvnz = $_POST['ncantvnz'];
			$sdatavnz = $_POST['ndatavnz'];
  
			if ($sidv!=0) {
				if($sidprodv!=0) {
					mysqli_query($conn, "UPDATE vanzari SET ID_produs='{$sidprodv}' WHERE ID='{$sidv}'") or die (mysqli_error());
				}
				if($sidstorev!=0) {
					mysqli_query($conn, "UPDATE vanzari SET ID_magazin='{$sidstorev}' WHERE ID='{$sidv}'") or die (mysqli_error());
				}
				if($scantvnz!=0) {
					mysqli_query($conn, "UPDATE vanzari SET cant_vanzari='{$scantvnz}' WHERE ID='{$sidv}'") or die (mysqli_error());
				}
				if($sdatavnz!='') {
					mysqli_query($conn, "UPDATE vanzari SET data_vanzare='{$sdatavnz}' WHERE ID='{$sidv}'") or die (mysqli_error());
				}
			}
		} break;
		default: {
			echo 'Invalid value selected in `upd`!';
		}
	} // end switch
	
	echo "Datele au fost actualizate.<br>Puteti inchide fereastra.";
	// close the connection
	mysqli_close($conn);
	
} // end isset

?>
