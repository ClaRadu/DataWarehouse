<html>
<body bgcolor="Silver">

<hr>

<?php 
include 'dbs/session.php';

if(isset($_GET['table'])) {
	$tab = $_GET['table'];
	$save = true;
	
	echo "<font color='green'>Introduceti datele corespunzatoare tabelului '" . $tab . "':";
	echo "<hr><form action='dbs/add.php' method='post'>";

	switch ($tab) {
		case "magazine": {
			echo "<input type='hidden' name='table_id' value='1'>";
			echo "ID oras: <input type='text' value='0' name='idors' />";
			echo " ( unde, 1=Sibiu, 2=Timisoara, 3=Bucuresti, ... );<br>";
			echo "Locatie magazin: <input type='text' name='locmag'/>";
			echo " Numar telefon: <input type='text' name='nrtel'/>";
			} break;
		case "orase": {
			echo "<input type='hidden' name='table_id' value='2'>";
			echo "Nume oras: <input type='text' name='numeors' /><br>";
			echo "Nume judet: <input type='text' name='numejud'/>";
			} break;
		case "producatori": {
			echo "<input type='hidden' name='table_id' value='3'>";
			echo "Nume producator: <input type='text' name='numeproduc'/>";
			} break;
		case "produse": {
			echo "<input type='hidden' name='table_id' value='4'>";
			echo "Nume produs: <input type='text' name='numeprod' /><br>";
			echo " ID categorie produs: <input type='text' name='idcatprodp' />";
			echo "( unde, 1=procesor, 2=placa video, ... );<br>";
			echo "ID producator: <input type='text' name='idprodp' />";
			echo " ( ex: 1=Intel, 2=AMD, 3=Asus );";
			} break;
		case "produse_categorii": {
			echo "<input type='hidden' name='table_id' value='5'>";
			echo "Nume categorie: <input type='text' name='numecateg'/>";
			} break;
		case "vanzari": {
			echo "<input type='hidden' name='table_id' value='6'>";
			echo "ID produs: <input type='text' name='idprodv' />";
			echo " ( unde, 1=Intel Core i7, 2=AMD Phenom II, ... );<br>";
			echo "ID magazin: <input type='text' name='idstorev' />";
			echo " ( unde, 1=Str. X nr.5, 2=Str. PLM nr.1, ... );<br>";
			echo "Cantitate vanzari: <input type='text' name='cantvnz'/><br>";
			echo "Data vanzarii: <input type='text' name='datavnz' />";
			echo " Data se va scrie de forma: 'aaaa-ll-zz hh:mm:ss' ";
			} break;
		default: {
			echo "<font color='red'>Wrong table selected!</font><br/>";
			$save = false;
		}
	} // end switch
	if ($save) { echo "<input type='submit' />"; }
	echo "</form>";
	echo "</font>";

} else { echo "<font color='red'>Table not found!!!</font><br/>"; }
?> 

<hr>
<hr>
<a href="JavaScript:window.close()" style="color:red;">Close window</a>
<hr>

</body>
</html>
