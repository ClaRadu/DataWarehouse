var aTables = new Array();

// new http request
function httpreq() {
	var xmlhttp =  null;
	
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else { // older ie versions
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	return xmlhttp;
}

// generic get request
function greq(str, oResp, slink) {
	var finLink = slink+'?'+str;
	var xmlhttp = httpreq();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (oResp !== null) { oResp.innerHTML = this.responseText; }
		}
	}
	
	xmlhttp.open("GET", finLink);
	xmlhttp.send();
}

// generic post request
function preq(str, oResp, slink) {
	var xmlhttp =  httpreq();

	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (oResp !== null) { oResp.innerHTML = this.responseText; }
		}
	}
	
	xmlhttp.open("POST", slink, true);
	xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(str);
	
	return true;
}

// check for db - get
function checkdb(str, sResp, slink) {
	var finLink = slink+'?db_name='+str;
	var elem = document.getElementById(sResp);
	var xmlhttp = httpreq();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var obj = JSON.parse(this.responseText);
			if (obj.status === 'found') { 
				elem.innerHTML = "Ready for use";
			} else {
				elem.innerHTML = "Not available";
				elem.classList.add("w3-red");
			}
		}
	}
	
	xmlhttp.open("GET", finLink);
	xmlhttp.send();
}

// src. for tables - show result in a table - get req.
function getTablesData(strlink, oResp) {
	var table = "<table><tr class='w3-black'><th class='w3-left-align'>Table</th><th	class='w3-left-align'>Database</th></tr>";
	var footer = "</table>";
	var i = 0;
	var xmlhttp = httpreq();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var obj = JSON.parse(this.responseText);
			for (i; i<obj.length; i++) {
				var row = obj[i];
				table += '<tr><td>'+row['table_name']+'</td><td>'+row['table_schema']+'</td></tr>';
			}
			table += footer;
			oResp.innerHTML = table;
		}
	}
	
	xmlhttp.open("GET", strlink);
	xmlhttp.send();
}

function getTables() {
	var inputval = document.getElementById('srctabs').value;
	var elem = document.getElementById('found_tables');
	var slink = '../dbs/getables.php?table_name=';
	
	if (inputval === "") {
		alert("Please add valid data.");
	} else {
		slink += inputval;
		getTablesData(slink, elem);
	}
}

// show all dbs
function showdbs(cResp, cStat, clink) {
	var elem = document.getElementById(cResp);
	var finlink = clink+'?show_dbs='+cStat;
	var tdata = '<table><tr><th>Baze de date disponibile</th></tr>';
	var i = 0;
	var xmlhttp = httpreq();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var obj = JSON.parse(this.responseText);
			for (i; i<obj.length; i++) {
				var row = obj[i];
				tdata += '<tr><td>'+row['Database']+'</td></tr>';
			}
			tdata += '</table>';
			elem.innerHTML = tdata;
		}
	}
	
	xmlhttp.open("GET", finlink);
	xmlhttp.send();
}

// show all tables
function showTables(cElem, clink, cdb) {
	var elem = document.getElementById(cElem);
	var selectbox = "<div class='w3-padding-16'><select id='seltbl' onchange='selTable();'><option value='none'>Selecteaza un tabel</option>";
	var i = 0;
	var xmlhttp = httpreq();
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var obj = JSON.parse(this.responseText);
//			console.log(obj);
			// check for the right id
			if (obj[0]['table_name'] === undefined) { cid = 'Tables_in_'+cdb; }
			else { cid = 'table_name'; }
			// update the select box
			for (i; i<obj.length; i++) {
				var row = obj[i];
				selectbox += "<option value='"+row[cid]+"'>"+row[cid]+"</option>";
				aTables.push({ 'name':row[cid], 'rating':0 });
			}
			selectbox += '</select></div>';
			elem.innerHTML = selectbox;
		}
	}
	
	xmlhttp.open("GET", clink);
	xmlhttp.send();
}

// show selected table and update modal form
function selTable() {
	var elem = document.getElementById('show_table');
	var modal = document.getElementById('modcontrols');
	var sele = document.getElementById('seltbl');
	var selval = sele.value;
	var clink = '../dbs/getTable.php?tname='+selval;
	var table = "<table>";
	var controls = new Array();
	var dummy = [];
	var i,j;
	document.getElementById('modinfo').innerHTML = 'In tabelul ['+selval+']'; // update modal subtitle
	document.getElementById('addinfo').innerHTML = ''; // clear data in info label
	var xmlhttp = httpreq(); // create request
	
	if (selval === "none") { 
		elem.innerHTML = "";
		toggleElem('add_table', false); // hide add div
	} else {
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
//				console.log(this.responseText);
				i = j = 0;
				var obj = JSON.parse(this.responseText);
				// get all objects from the array
				for (i; i<obj.length; i++) {
					var row = obj[i];
					// write header
					if (i === 0) {
						table += "<tr>";
						for (var elm in row) {
							table += "<th class='w3-left-align w3-padding-small'>"+elm+"</th>";
							controls.push(elm);
						}
						table += "<th>op_1</th><th>op_2</th>"; // add 2 more cells for update and delete
						table += "</tr>";
					}
					table += writeRow(row, selval);
				}
				table += '</table>';
				elem.innerHTML = table;
				modal.innerHTML = writeModal(controls, dummy, selval);
				toggleElem('add_table', true); // show add div
				updateRating(selval); // increment the table's rating
			}
		}
	
		xmlhttp.open("GET", clink);
		xmlhttp.send();
	} // end if
} // end func.

// increment the table rating in the aTables array
function updateRating(ctable) {
	for (var x in aTables) { 
		if (aTables[x]['name'] === ctable) { aTables[x]['rating'] += 1; }
	}
}

// write a table row
function writeRow(oRow, ctable) {
	var cdata = '<tr><td>'+oRow.ID+'</td><td>';
	var tag = "";
	
	switch (ctable) {
		case 'magazine':
			cdata += oRow.ID_oras+'</td><td>'+oRow.locatie_magazin+'</td><td>'+oRow.numar_telefon;
			break;
		case 'producatori':
			cdata += oRow.Nume_producator;
			break;
		case 'orase':
			cdata += oRow.nume_oras+'</td><td>'+oRow.nume_judet;
			break;
		case 'produse':
			cdata += oRow.Nume_produs+'</td><td>'+oRow.ID_categorie_produs+'</td><td>'+oRow.ID_producator;
			break;
		case 'users':
			cdata = '<tr><td>'+oRow.id+'</td><td>'+oRow.username+'</td><td>***';
			tag = "disabled"; // don't update or delete users from here
			break;
		case 'vanzari':
			cdata += oRow.ID_produs+'</td><td>'+oRow.ID_magazin+'</td><td>'+oRow.cant_vanzari+'</td><td>'+oRow.data_vanzare;
			break;
	}
	// update button
	cdata += '</td><td><button value='+oRow.ID+' class="w3-button w3-blue" onclick="Update(this);" '+tag+'>Update</button></td>';
	// delete button
	cdata += '<td><button value='+oRow.ID+' class="w3-button w3-red" onclick="Delete(this);" '+tag+'>Delete</button>';
	cdata += '</td></tr>';
	
	return cdata;
}

// add all the controls to the modal form
function writeModal(aControls, aValues, ctable) {
	var celem, tag;
	var cmodal, val;
	tag = celem = "";
	cmodal = val = "";
	
	for (var x in aControls) {
		celem = aControls[x];
		if (ctable === 'users') { tag = 'disabled'; } // no operations on users table
		else if (celem.toUpperCase() === 'ID') { tag = 'disabled'; } // id is incremented automatically
		else { tag = ''; }
		val = aValues.length > 0 ? aValues[x] : ''; // both arrays should have the same length
		cmodal += "<p><label>"+celem+":</label>";
		cmodal += '<input class="w3-input" type="text" id="'+celem+'" value="'+val+'" '+tag+'></p>';
	}
	
	return cmodal;
}

// save data to the selected table
function Save() {
	var selval = document.getElementById('seltbl').value; // option should already be selected
	var nfo = document.getElementById('addinfo');
	var saveStatus = document.getElementById('saveStatus').value;
	var idelem = document.getElementById('ID');
	var id = idelem===null ? null : idelem.value;
	var save = true;
	var clink, str;
	str = 'tbl_name='+selval;
	if (saveStatus > 0) {
		clink =  '../dbs/save.php';
	} else {
		clink = '../dbs/update.php';
		if (id !== null) { str += '&row_id='+id; }
	}
	
	switch (selval) {
		case 'magazine':
			var idors = document.getElementById('ID_oras').value;
			var locmag = document.getElementById('locatie_magazin').value;
			var nrtel = document.getElementById('numar_telefon').value;
			str += '&ID_oras='+idors+'&locatie_magazin='+locmag+'&numar_telefon='+nrtel;
			break;
		case 'producatori':
			var nmprod = document.getElementById('Nume_producator').value;
			str += '&Nume_producator='+nmprod;
			break;
		case 'orase':
			var nmors = document.getElementById('nume_oras').value;
			var nmjud = document.getElementById('nume_judet').value;
			str += '&nume_oras='+nmors+'&nume_judet='+nmjud;
			break;
		case 'produse':
			var nmprod = document.getElementById('Nume_produs').value;
			var categprod = document.getElementById('ID_categorie_produs').value;
			var idprod = document.getElementById('ID_producator').value;
			str += '&Nume_produs='+nmprod+'&ID_categorie_produs='+categprod+'&ID_producator='+idprod;
			break;
		case 'users':
			save = false;
			break;
		case 'vanzari':
			var idprod = document.getElementById('ID_produs').value;
			var idmag = document.getElementById('ID_magazin').value;
			var cantv = document.getElementById('cant_vanzari').value;
			var dtvnz = document.getElementById('data_vanzare').value;
			str += '&ID_produs='+idprod+'&ID_magazin='+idmag+'&cant_vanzari='+cantv+'&data_vanzare='+dtvnz;
			break;
	}
	
	if (save) {
		var xmlhttp = httpreq();
	
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (nfo !== null) {
					nfo.innerHTML = this.responseText; // show response
					selTable(); // reset table
					toggleElem('Modal', false); // close modal
				}
			}
		}
	
		xmlhttp.open("POST", clink, true);
		xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(str);
	} else {
		nfo.innerHTML = 'Nu se efectueaza operatii pe acest tabel!';
		toggleElem('Modal', false); // close modal
	}
}

// update entry
function Update(obj) { 
	var modal = document.getElementById('modcontrols');
	var sele = document.getElementById('seltbl');
	var selval = sele.value;
	var clink = '../dbs/getTable.php?tname='+selval+'&row_id='+obj.value;
	var controls = new Array();
	var values = new Array();
	document.getElementById('modinfo').innerHTML = 'In tabelul ['+selval+']'; // update modal subtitle
	document.getElementById("saveStatus").value = 0; // change status to 0 ( update )
	var xmlhttp = httpreq(); // create request
	
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
//			console.log(this.responseText);
			var jobj = JSON.parse(this.responseText);
			// get all data from the array
			var row = jobj[0]; // we should only get 1 row anyway
			for (var elm in row) {
				controls.push(elm);
				values.push(row[elm]);
			}
			// populate the form
			modal.innerHTML = writeModal(controls, values, selval);
			toggleElem('Modal', true); // show modal form
			toggleElem('modname1', false); // hide 1st title
			toggleElem('modname2', true); // show 2nd
		}
	}
	
	xmlhttp.open("GET", clink);
	xmlhttp.send();
}

// clear the data in all input controls
function clearInputs() {
	var inputs = document.getElementsByTagName("input");
	if (inputs.length > 0) {
		for (var x in inputs) { inputs[x].value = ''; }
	}
}

// delete entry from db
function Delete(obj) { 
	var selval = document.getElementById('seltbl').value; // option should already be selected
	var nfo = document.getElementById('addinfo');
	var save = selval==='users' ? false : true;
	var clink = '../dbs/dele.php';
	var str = 'tbl_name='+selval+'&row_id='+obj.value;
	
	save = confirm('Doriti sa stergeti randul cu id = '+obj.value+'?');
	
	if (save) {
		var xmlhttp = httpreq();
	
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (nfo !== null) {
					nfo.innerHTML = this.responseText; // show response
					selTable(); // reset table
				}
			}
		}
	
		xmlhttp.open("POST", clink, true);
		xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(str);
	} else {
		nfo.innerHTML = 'Nu se efectueaza operatii pe acest tabel!';
		toggleElem('Modal', false); // close modal
	}
}

// toggle show/hide element
function toggleElem(cElem, show) {
	var elem = document.getElementById(cElem);
	
	if (show) { elem.style.display = "block"; }
	else { elem.style.display = "none"; }
}