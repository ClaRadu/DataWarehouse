// get all values and validate data
function reg() {
	var user = document.getElementById("user").value;
	var pass1 = document.getElementById("pass1").value;
	var pass2 = document.getElementById("pass2").value;
	var elem = document.getElementById("nfo");
	var strlnk = "dbs/reg.php";
	
	var ids = [];
	ids[0] = 'username';
	ids[1] = 'password1';
	ids[2] = 'password2';
	
	var vals = [];
	vals[0] = user;
	vals[1] = pass1;
	vals[2] = pass2;
	
	elem.style.display = 'block'; // show info label
	
	if (pass1 !== pass2) {
		elem.innerHTML = 'Passwords must be identical!';
	} else {
		req(ids, vals, elem, strlnk);
	}
}

// make post request
function req(aIds, aVals, objResp, strlink) {
	var str = '';
	var alen = aIds.length; // both arrays have the same length
	var xmlhttp = null;
	
	// create address string
	str = aIds[0]+'='+aVals[0]; // array cannot be empty
	if (alen > 1) {
		for (var i=1; i<alen; i++) {
			str += '&'+aIds[i]+'='+aVals[i];
		}
	}
	
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else { // older ie versions
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (objResp !== null) { objResp.innerHTML = this.responseText; }
		}
	}
	
	xmlhttp.open("post", strlink, true);
	xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xmlhttp.send(str);
	
	return true;
}
