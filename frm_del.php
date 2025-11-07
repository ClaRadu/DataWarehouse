<html>
<body bgcolor="Silver">

<hr>

<?php 
include 'dbs/session.php';
  
if(isset($_GET['table'])) {
	$tab = $_GET['table'];
	$save = true;

	echo "<font color='green'>Stergere date din tabelul '" . $tab . "':";
	echo "<hr><form action='dbs/del.php' method='post'>";

	switch($tab) {
		case "magazine": {
			echo "<input type='hidden' name='table_id' value='1'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelmag' value={$_POST['del1']} />";
		} break;
		case "orase": {
			echo "<input type='hidden' name='table_id' value='2'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelors' value={$_POST['del1']} />";
		} break;
		case "producatori": {
			echo "<input type='hidden' name='table_id' value='3'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelprd' value={$_POST['del1']} />";
		} break;
		case "produse": {
			echo "<input type='hidden' name='table_id' value='4'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelprds' value={$_POST['del1']} />";
		} break;
		case "produse_categorii": {
			echo "<input type='hidden' name='table_id' value='5'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelcp' value={$_POST['del1']} />";
		} break;
		case "vanzari": {
			echo "<input type='hidden' name='table_id' value='6'>";
			echo "ID-ul randului pe care doriti sa il stergeti: <input type='text' name='iddelvnz'value={$_POST['del1']}  />";
		} break;
		default: {
			echo "<font color='red'>Wrong table selected!</font><br/>";
			$save = false;
		}
	}

	echo "<hr><hr>";
	if ($save) { 
		echo "<input type='submit' VALUE='Sterge' STYLE='background:none; border-width:0px; color:red;		text-decoration:underline;' />";
	}
	echo "</form>";
	echo "</font>";

} else { echo "<font color='red'>Table not found!!!</font><br/>"; }
?>

<hr>
<a href="JavaScript:window.close()" style="color:red;">Anuleaza stergerea</a>
<hr><hr>

</body>
</html>
