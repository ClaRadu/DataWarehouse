<?php include("../dbs/session.php"); ?>

<!DOCTYPE html>

<html lang="en">
<head>
  <title>DW - Operations page</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../scripts/modal.css">
</head>
<body onbeforeunload="return updRatings();">

  <!-- operations section -->
  <div class="w3-black" id="oper">
    <div class="w3-container w3-content w3-padding-64" style="max-width:800px;">
      <h2 class="w3-wide w3-center">Operations</h2>
      <p class="w3-opacity w3-center"><i>Database related operations</i></p><br>
	  
		<div class="w3-row">
			<div class="w3-half w3-container">
			  <p><label>Search for tables in all databases:</label>
			  <input class="w3-input" type="text" id="srctabs" style="max-width:300px"></p>
			  <button value="Src" class="w3-button w3-white" style="width:300px" onclick="getTables();">Search</button>
			</div>
			<div id="found_dbs" class="w3-half w3-container">
			</div>
		</div>
		<br>
		
		<div class="w3-container w3-gray" id="found_tables"></div><br>

      <ul class="w3-ul w3-border w3-white w3-text-grey">
        <li class="w3-padding">cryza_data_wrhse <span id='db1' class="w3-tag w3-right w3-margin-right">Ready</span></li>
        <li class="w3-padding">cryza_11 <span id='db2' class="w3-tag w3-right w3-margin-right">Ready</span></li>
        <li class="w3-padding">cryza_pers <span id='db3' class="w3-tag w3-right w3-margin-right">Ready</span></li>
      </ul>
	  <br>
	  <hr>
	  
	  <!-- info on our db -->
	  <p class="w3-green">* Baza de date folosita: [<?php echo $params['dbs']; ?>]</p>
	  
	  <!-- select a table -->
	  <div class="w3-container" id="show_tables"></div>
	  
	  <!-- add new data to table -->
	  <div class="w3-container" id="add_table">
	    <button id="btnAdd" class="w3-button w3-green">Add</button>
		<p id="addinfo" class="w3-white"></p>
	  </div>
	  
	  <!-- show the selected table -->
	  <div class="w3-container" id="show_table"></div>
	  
	  <!-- modal form for adding/updating data in all tables -->
	  <!-- thanks for modal to: https://www.w3schools.com/ -->
	  <div id="Modal" class="modal">
	    <!-- content -->
		<div class="modal-content">
		  <span class="close">&times;</span>
		  <H1 id="modname1">Adaugare Date</H1>
		  <H1 id="modname2">Actualizare Date</H1>
		  <p id="modinfo">doing some stuff with data..</p>
		  <div id="modcontrols" class="w3-container"></div>
		  <div class="w3-container">
			<input id="saveStatus" type="hidden" value="0">
		    <button id="btnSave" class="w3-button w3-blue w3-right" onclick="Save();">Save</button>
		    <button id="btnCancel" class="w3-button w3-red w3-left">Cancel</button>
		  </div>
		</div>	
	  </div>
	  
	</div>
  </div>

<script src="../scripts/ops.js"></script>
<script>
var cpath = '../dbs/getdb.php';

// check 1st db
checkdb('cryza_data_wrhse', 'db1', cpath);
// check 2nd db
checkdb('cryza_11', 'db2', cpath);
// check 3rd db
checkdb('cryza_pers', 'db3', cpath);
// show all dbs
showdbs('found_dbs', 'OK', '../dbs/getdbs.php');
// show all tables
showTables('show_tables', '../dbs/getTables.php', 'cryza_11');
// hide the add data container
toggleElem('add_table', false);

// the modal
var btnAdd = document.getElementById("btnAdd");
var btnCancel = document.getElementById("btnCancel");
var spnClose = document.getElementsByClassName("close")[0];

// actions
// click add button
btnAdd.onclick = function() {
	toggleElem('Modal', true); // open modal
	clearInputs(); // clear all input controls, if the case
	document.getElementById("saveStatus").value = 1; // save data
	toggleElem('modname1', true); // show 1st title
	toggleElem('modname2', false); // 2nd not needed
}
// close modal
btnCancel.onclick = function() { toggleElem('Modal', false); } // cancel btn.
spnClose.onclick = function() { toggleElem('Modal', false); } // close btn.

// update the ratings table
function updRatings() {
	var str = '';
	var clink = '../dbs/ratings.php';
	for (var x in aTables) {
		if (str === '') { str += aTables[x]['name']+'='+aTables[x]['rating']; }
		else { str += '&'+aTables[x]['name']+'='+aTables[x]['rating']; }
	}
	var xmlhttp =  httpreq();

	xmlhttp.open("POST", clink, true);
	xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(str);
}
</script>

</body>
</html>
