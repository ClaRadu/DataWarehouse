<?php include("dbs/session.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">

<html>
<title>| D.W. Data Warehouse | C.R.G. |</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<META NAME=AUTHOR CONTENT="Claudiu Radu CRG" />
<link rel="shortcut icon" href="img/favicon.ico"/>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="scripts/styles.css">
<style>
  iframe { width:100%; height:550px; }
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="toggleMenu()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="content/main.htm" target="mainFrame" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="content/operations.php" target="mainFrame" class="w3-bar-item w3-button w3-padding-large w3-hide-small">OPERATIONS</a>
	<a href="content/contact.htm" target="mainFrame" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>
    <a href="dbs/logout.php" class="w3-padding-large w3-hover-red w3-hide-small w3-right">LOGOUT</a>
  </div>
</div>

<!-- Navbar on small screens -->
<div id="navSmall" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="content/main.htm" target="mainFrame" class="w3-bar-item w3-button w3-padding-large">HOME</a>
  <a href="content/operations.php" target="mainFrame" class="w3-bar-item w3-button w3-padding-large">OPERATIONS</a>
  <a href="content/contact.htm" target="mainFrame" class="w3-bar-item w3-button w3-padding-large">CONTACT</a>
  <a href="dbs/logout.php" class="w3-bar-item w3-button w3-padding-large">LOGOUT</a>
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:2000px; margin-top:46px;">

	<!-- Logo Image -->
	<br/>
	<div class="myImg w3-display-container w3-center">
		<img src="img/factory2.png">
	</div>
	
	<!-- greet user -->
	<div class="w3-center"><?php echo 'Hello, ' . $login_session . '!' ?></div>

	<!-- The Main Section -->
	<!-- using iframes - thanks to: https://www.tutorialrepublic.com/html-tutorial/html-iframes.php -->
	<iframe src="content/main.htm" name="mainFrame"></iframe>
  
<!-- End Page Content -->
</div>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  <p class="w3-medium">C.R.G. a.k.a. CRGames &copy; 2011 -
	<script type="text/javascript">
		var d=new Date();
		document.write(d.getFullYear());
	</script>
  </p>
</footer>

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function toggleMenu() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

function showform() {
	var frm = document.getElementById('addfrm');
	frm.style.display = 'block';
}

function hideform() {
	var frm = document.getElementById('addfrm');
	frm.style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('addfrm');
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// thanks to w3schools: https://www.w3schools.com
</script>

</body>
</html>
