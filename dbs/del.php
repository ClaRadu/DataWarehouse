<?php 
include 'global.php';

// delete data from tables *****************************
if(isset($_POST['table_id'])) {
	$tid = $_POST['table_id'];
	
	// establish server connection
	$conn = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
	if (!$conn) { die('Could not connect: ' . mysqli_error()); }
	
	switch($tid) {
		case '1': {
			$sdelid_m = $_POST['iddelmag'];
			if (!empty($sdelid_m)) {
				mysqli_query($conn, "DELETE FROM magazine WHERE ID='{$sdelid_m}'") or die (mysqli_error());
			}
		} break;
		case '2': {
			$sdelid_o = $_POST['iddelors'];
			if (!empty($sdelid_o)) {
				mysqli_query($conn, "DELETE FROM orase WHERE ID='{$sdelid_o}'") or die (mysqli_error());
			}
		} break;
		case '3': {
			$sdelid_prd = $_POST['iddelprd'];
			if (!empty($sdelid_prd)) {
				mysqli_query($conn, "DELETE FROM producatori WHERE ID='{$sdelid_prd}'") or die (mysqli_error());
			}
		} break;
		case '4': {
			$sdelid_prds = $_POST['iddelprds'];
			if (!empty($sdelid_prds)) {
				mysqli_query($conn, "DELETE FROM produse WHERE ID='{$sdelid_prds}'") or die (mysqli_error());
			}
		} break;
		case '5': {
			$sdelid_cp = $_POST['iddelcp'];
			if (!empty($sdelid_cp)) {
				mysqli_query($conn, "DELETE FROM produse_categorii WHERE ID='{$sdelid_cp}'") or die (mysqli_error());
			}
		} break;
		case '6': {
			$sdelid_v = $_POST['iddelvnz'];
			if (!empty($sdelid_v)) {
				mysqli_query($conn, "DELETE FROM vanzari WHERE ID='{$sdelid_v}'") or die (mysqli_error());
			}
		} break;
		default: {
			echo 'Invalid value selected in `del`!';
		}
	} // end switch
	
	echo "Datele au fost sterse.<br>Puteti inchide fereastra.";
	// close the connection
	mysqli_close($conn);
	
} // end isset

?>
