<html>
<body bgcolor="Silver">

<hr>

<?php 
include 'dbs/global.php';
include 'dbs/session.php';

if(isset($_GET['table'])) {
	$tab = $_GET['table'];
	$sav = false;
	$get = false;
	
	// establish server connection
	$conn = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
	if (!$conn) { die('Could not connect: ' . mysql_error()); }
	
	$ures = null;
	if(isset($_POST['upd1'])) {
		$uid = $_POST['upd1'];
		// get all data from the selected row
		$ures = mysqli_query($conn, "SELECT * FROM {$tab} WHERE ID='{$uid}'");
		$get = true;
	}

	echo "<font color='green'>Actualizati datele corespunzatoare tabelului '" . $tab . "':";
	echo "<hr><form enctype='multipart/form-data' action='dbs/upd.php' method='post'>";

	switch($tab) {
		case "magazine": {
			if(mysqli_num_rows($ures) > 0) {
				$row = mysqli_fetch_assoc($ures); // we only have 1 row
				// create form
				echo "<input type='hidden' name='table_id' value='1'>";
				echo "Introdu ID-ul randului pe care il vei modifica: <input type='text' name='nidmag' value={$uid} /><br>";
				echo "Introdu noul ID pt. oras: <input type='text' name='nidors' value={$row['ID_oras']} />";
				echo " unde, 1=Sibiu, 2=Timisoara, 3=Bucuresti;<br>";
				echo "Introdu noua locatie a magazinului: <input type='text' name='nlocmag' value='" . trim($row['locatie_magazin']) . "' />";
				echo "Introdu noul numar de telefon: <input type='text' name='nnrtel' value={$row['numar_telefon']} />";
				$sav = true;
			} else { echo "<p style='color: red;'>Error: Could not retrieve data!</p>"; }
		} break;
		case "produse": {
			if(mysqli_num_rows($ures) > 0) {
				$row = mysqli_fetch_assoc($ures);
				echo "<input type='hidden' name='table_id' value='2'>";
				echo "Introdu ID-ul randului pe care il vei modifica: <input type='text' name='nidprod' value=	{$uid} /><br>";
				echo "Introdu noul nume al produsului: <input type='text' name='nnumeprod' value='{$row['Nume_produs']}' /><br>";
				echo "Introdu noul ID categorie produs: <input type='text' name='nidcatprod' value={$row['ID_categorie_produs']} />";
				echo " unde, 1=procesor, 2=placa video;<br>";
				echo "Introdu noul ID al producatorului: <input type='text' name='nidproduc' value={$row['ID_producator']} />";
				echo " unde, 1=Intel, 2=AMD, 3=Asus; ";
				$sav = true;
			} else { echo "<p style='color: red;'>Error: Could not retrieve data!</p>"; }
		} break;
		case "vanzari": {
			if(mysqli_num_rows($ures) > 0) {
				$row = mysqli_fetch_assoc($ures);
				echo "<input type='hidden' name='table_id' value='3'>";
				echo "Introdu ID-ul randului pe care il vei modifica: <input type='text' name='nidvnz' value={$uid} /><br>";
				echo "Introdu noul ID al produsului: <input type='text' name='nidprodv' value={$row['ID_produs']} />";
				echo " unde, 1=Intel Core i7, 2=AMD Phenom II, 3=Nvidia GeForce 210, 4=ATI Radeon HD5450<br>";
				echo "Introdu noul ID pt. magazin: <input type='text' name='nidstorev' value={$row['ID_magazin']} />";
				echo " unde, 1=Sibiu, 2=Timisoara, 3=Bucuresti;<br>";
				echo "Introdu noua cantitate de vanzari: <input type='text' name='ncantvnz' value={$row['cant_vanzari']} /><br>";
				echo "Introdu noua data a vanzarii: <input type='text' name='ndatavnz' value='{$row['data_vanzare']}' />";
				echo " ,data se va scrie de forma: 'aaaa-ll-zz hh:mm:ss' ";
				$sav = true;
			} else { echo "<p style='color: red;'>Error: Could not retrieve data!</p>"; }
		} break;
		case "orase": // next
		case "producatori": // next
		case "produse_categorii": {
			echo "<font color='red'>Nu se pot efectua operatii pe acest tabel!</font><br/>";
		} break;
		default: {
			echo "<font color='red'>Wrong table selected!</font><br/>";
		}
	}
	
	if ($sav) { echo "<input type='submit' name='magupd' value='Actualizeaza'/>"; }
	echo "</form>";
	echo "</font>";
	
	// free the query result
	mysqli_free_result($ures);
	// close the connection
	mysqli_close($conn);

} else { echo "<font color='red'>Table not found!!!</font><br/>"; }
?>

<hr><hr>
<a href="JavaScript:window.close()" style="color:red;">Close window</a>
<hr>

</body>
</html>
