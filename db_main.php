<?php include 'dbs/session.php'; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">

<html>
<head>
<TITLE>D.W. operations</TITLE>
<META NAME=AUTHOR CONTENT="Radu Claudiu CR-games" />
  
<style type="text/css">
A:link { color: red; 
	text-decoration: none }
A:visited { color: red; 
	text-decoration: none }
A:hover {   color : green;
	text-decoration: underline }
A:active { color: red }

table.a, td.a, th.a {
  border:1px solid green;
  margin: auto;
}

th.a {
  background-color:green;
  color:white;
}

.link-button {
	background: none;
    border: none;
    color: red;
    text-decoration: underline;
    cursor: pointer;
    font-size: inherit;
    font-family: inherit;
    padding: 0;
    margin: 0;
}
.link-button:hover { color: green; }
</style>
</head>

<body bgcolor="black" text="#FFFFFF">

<table style="vertical-align:center;margin-left:23%;" border="0" cellpadding="0" 
	cellspacing="0" width="550">
  <tbody>
    <tr height="30">
      <td height="30" width="30"><img src="img/topLeft.gif"
 alt="" border="0" height="30" width="30"></td>
      <td background="img/top.gif" height="30" width="490"></td>
      <td height="30" width="30"><img src="img/topRight.gif"
 alt="" border="0" height="30" width="30"></td>
    </tr>
    <tr>
      <td background="img/left.gif" width="30"></td>
      <td align="left" background="img/middle.jpg" valign="top"
 width="490"><font style="font-size: 14px;" color="#333333"
 face="verdana">

   <center><font id="bla">Hello!!</font></center>

   <img style="margin-left:22%;" src="img/factory2.png"
		 alt="C.R.G.D.W" >
<br>

<center>
<a href="db_home.php" target="_blank" >| HOME | </a>
<a href="db_main.php" target="_blank" > | OPERATIONS |</a>
</center>

<br>
<hr>
<br>

<?php 
error_reporting($debug);
//print_r($db_list);

// establish new server connection
$con = mysqli_connect($params['srv'], $params['usr'], $params['pas'], $params['dbs']);
if (!$con) {
	die('Could not connect: ' . mysqli_error());
}

echo "<table class='a' border='1'>
<tr>
<th class='a'>Baze de date disponibile:</th>
</tr>";
while ($db = mysqli_fetch_object($db_list)) {
  echo "<tr>";
  echo "<td class='a'>" . $db->Database . "<br />" . "</td>";
  echo "</tr>";
}
echo "</table>";
mysqli_free_result($db_list);

echo "<br/><hr/>";

echo "<br />";
echo "<font size='3' face='arial' color='green'>Database in use: [" . $params['dbs'] . "]</font><br />";
echo "<br />";

// check if ratings table exists using the information schema db
$q1 = mysqli_query($con, "SELECT TABLE_SCHEMA, TABLE_TYPE, TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME='ratings'");
if(mysqli_num_rows($q1) > 0) { // table exists
	$stfd = "SELECT * FROM ratings ORDER BY rating DESC";
	$rowid = 1;
} else { // table doesn't exist
	$stfd = "SHOW TABLES FROM " . $params['dbs'];
	$rowid = 0;
}
mysqli_free_result($q1); // free query result

// show tables
$result_tab = mysqli_query($con, $stfd);

echo "<FORM name ='frm1' method ='post' action =''>";
echo "<table border='1'>
<tr>
<th class='a'>Tabelele bazei de date folosite</th><th class='a'>Selecteaza</th>
</tr>";
while($rowtab = mysqli_fetch_row($result_tab)) {
    echo "<tr>";
    echo "<td class='a'>" . $rowtab[$rowid] . "</td>";
    // add checkbox to select the table
    echo "<td class='a' align='center'><Input type='Radio' Name='toggle' value='" . $rowtab[$rowid] . "'</td>";
    echo "</tr>"; 
}
echo "</table>";

echo "</br><Input type='Submit' Name='Submit' VALUE='Afiseaza tabelul'>";
echo "</FORM>";

mysqli_free_result($result_tab);

if (isset($_POST['Submit'])) {
	$selected_radio = $_POST['toggle'];
	// show the selected table
	echo "<br/><br/>";
	echo "<hr/>";

	mysqli_select_db($con, $params['dbs']);
	//mysql_select_db($params['dbs'], $con); // deprecated

	$table = $selected_radio;

	//$result = mysql_query("SELECT * FROM magazine"); // testing
	$result = mysqli_query($con, "SELECT * FROM {$table}");

	$fields_num = mysqli_num_fields($result);

	echo "<font size='3' color='white'>Selected table: {$table}</font>";
	echo "<table border='1' class='a'><tr class='a'>";
	// printing table headers
	for($i=0; $i<$fields_num; $i++) {
		$field = mysqli_fetch_field($result);
		echo "<td class='a' style='font-weight:bold;'>{$field->name}</td>";
	}
	echo "</tr>";
	// printing table rows
	while($row = mysqli_fetch_row($result)) {
		echo "<tr class='a'>";

		// $row is of array type... foreach( .. ) puts every element
		// of $row to $cell variable
		foreach($row as $cell)
			echo "<td class='a'>$cell</td>";

		echo "</tr>";
	}
	echo "</table>";
	mysqli_free_result($result);
}

// save data to file ( if the case ) ***********************************
//$filename = 'img/dwnld/vanzari.csv';
$path = 'img/dwnld/';
$ext = '.csv';
$filename = $path . $table . $ext;
if($table!='') {
	$fp = fopen($filename, "w");

	//$wres = mysql_query("SELECT * FROM vanzari"); // testing
	$wres = mysqli_query($con, "SELECT * FROM " . $table);
	$wfields_num = mysqli_num_fields($wres);

	//wrinting table headers
	for($i=0; $i<$wfields_num; $i++) {
	    $field = mysqli_fetch_field($wres);
	    $spacefield = "$field->name ";
	    fputs($fp, $spacefield);
	}
	//wrinting table rows
	while($row = mysqli_fetch_row($wres)) {
	    // $row is array... foreach( .. ) puts every element
	    // of $row to $cell variable
	    foreach($row as $cell) {
		  $spacecell = " $cell ";
	        fputs($fp, $spacecell);
	    }
	}
	fclose($fp);
	mysqli_free_result($wres);
}

echo "<hr>";

// add data
echo "<a href='frm_add.php?table=$table' target='_blank'>Adauga date in tabel</a></br>";
echo "<hr/>";

// update or delete data, if table selected
if (isset($table)) {
	// update data
	$ures = mysqli_query($con, "SELECT * FROM {$table}"); // get all data from table
	// create select control
	echo "<form action='frm_upd.php?table=$table' target='_blank' name='frmu1' method='post' style='font-size=3; color:white;'>Selectati ID-ul campului pe care doriti sa-l actualizati: ";
	echo "<select id='sel-upd1' name='upd1' value='' onchange=''>";
	$drow = array();
	if(mysqli_num_rows($ures) > 0) {
		while($urow = mysqli_fetch_assoc($ures)) {
			echo "<option value=" . $urow["ID"] . ">" . $urow["ID"] . "</option>";
			array_push($drow, $urow['ID']);
		}
	}
	echo "</select><br>";
	echo "<input type='submit' class='link-button' value='Actualizeaza' />";
	echo "</form>";
	echo "<hr>";
	
	// delete data
	echo "<form action='frm_del.php?table=$table' target='_blank' name='frmd1' method='post' style='font-size=3; color:white;'>Selectati ID-ul campului pe care doriti sa-l stergeti: ";
	echo "<select id='sel-del1' name='del1' value='' onchange=''>";
	foreach($drow as $val) {
		echo "<option value=" . $val . ">" . $val . "</option>";
	}
	echo "</select><br>";
	echo "<input type='submit' class='link-button' value='Sterge' />";
	echo "</form>";
	
	mysqli_free_result($ures);
	
	// update the ratings table
	$resq = mysqli_query($con, "UPDATE ratings SET rating=rating+1 WHERE table_name='{$table}'");
}

echo "<hr/>";
echo "<hr/>";
echo "<br>";

if($table!='') {
	echo "<font color='green'>Pentru a downloada datele din tabelul [" . $table . "] apasati link-ul de mai jos:\n</font>";
	echo "<a href='img/dwnld/{$table}.csv' target='_blank'>DOWNLOAD FILE</a>";
}
echo "<br>";
echo "<br>";

mysqli_close($con);

?> 

<br />

 <a style="margin-left:3%;font-size:10px;" href="#bla">Back To Top</a>

    <td background="img/right.gif" width="30"></td>
    </tr>
    <tr height="30">
      <td height="30" width="30"><img src="img/BottomLeft.gif"
 alt="" border="0" height="30" width="30"></td>
      <td background="img/bottom.gif" height="30" width="490"></td>
      <td height="30" width="30"><img
 src="img/BottomRight.gif" alt="" border="0" height="30"
 width="30"></td>
    </tr>
  </tbody>
</table>

<font style="vertical-align:center;margin-left:41%;" 
		color="#666666" face="Georgia, verdana" size="1">
©2011-
<script type="text/javascript">
var d=new Date();
document.write(d.getFullYear());
</script>
CR Games. All rights reserved. 
</font>

</body>
</html>
