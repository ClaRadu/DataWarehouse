<html>
<body bgcolor="Silver">

<hr>

  <!-- Create / Update form -->
  <div id="modfrm" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
      <header class="w3-container w3-teal w3-center w3-padding-32"> 
        <span onclick="document.getElementById('modfrm').style.display='none'"
       class="w3-button w3-teal w3-xlarge w3-display-topright">×</span>
        <h2 class="w3-wide"><i class="fa fa-database w3-margin-right"></i>Modify</h2>
      </header>
      <div class="w3-container">
        <p><label><i class="fa fa-caret-square-o-right"></i> Name</label></p>
        <input class="w3-input w3-border" type="text" placeholder="name">
        <p><label><i class="fa fa-caret-square-o-right"></i> Address</label></p>
        <input class="w3-input w3-border" type="text" placeholder="address">
        <button class="w3-button w3-block w3-teal w3-padding-16 w3-section w3-right">Save <i class="fa fa-check"></i></button>
        <button class="w3-button w3-red w3-section" onclick="document.getElementById('modfrm').style.display='none'">Close <i class="fa fa-remove"></i></button>
        <p class="w3-right"><a href="#" class="w3-text-blue">help?</a></p>
      </div>
    </div>
  </div>

</body>
</html>