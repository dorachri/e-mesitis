<?php
	session_start();

	if (empty($_SESSION['userid'])) {
		header("Location: login.php");
	}
	elseif ($_SESSION['isadmin'] == '1') {
		$_SESSION['msg'] = "Δεν μπορείτε να κάνετε καταχώρηση αγγελιών ως διαχειριστής της ιστοσελίδας!";
		header("Location: error.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Καταχώρηση αγγελίας</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="includes/StyleSheet.css" media="screen"/>
	<link rel="shortcut icon" href="includes/images/favicon.ico">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="includes/sliding.form.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="includes/jquery.plugin.js"></script>
	<script src="includes/jquery.datepick.js"></script>
	<script>
		$(function() {
		$('#popupDatepicker').datepick();
		$('#inlineDatepicker').datepick({onSelect: showDate});
		});

		function showDate(date) {
		alert('The date chosen is ' + date);
		}
	</script>
	<script>
		function handleFileSelect(evt) {
		var files = evt.target.files; // FileList object

		// files is a FileList of File objects. List some properties.
		var output = [];
		for (var i = 0, f; f = files[i]; i++) {
		  output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ') - ',
					  f.size, ' bytes, last modified: ',
					  f.lastModifiedDate ? f.lastModifiedDate.toLocaleDateString() : 'n/a',
					  '</li>');
		}
		document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
		}

		document.getElementById('files').addEventListener('change', handleFileSelect, false);
	</script>
</head>
<body>

	<!----   LOGO    ---->
	<div id="logo">
		<a href="home.php"><img src="includes/images/logo.png" alt="logo" style="width:327px;height:91px;"></a>
		<div id="user">
			<?php
				if (isset($_SESSION['userid'])) {
					echo  "<h4> Welcome </h4>" .$_SESSION['username'];
				}
			?>
		</div>
	</div>


	<!----   MENU    ---->
	<div id="menuWrapper">
		<ul id="menu">
	    <li><a href="home.php">Home</a></li>
	    <li><a href="">Ενοικιάσεις</a>
		    <ul class="submenu">
		      <li><a href="rent_house.php">Ενοικιάσεις Κατοικιών</a></li>
		      <li><a href="rent_workplace.php">Ενοικιάσεις Επαγγελματικών Χώρων</a></li>
		      <li><a href="rent_land.php">Ενοικιάσεις Γης</a></li>
		    </ul>
	    </li>
	    <li><a href="">Πωλήσεις</a>
		    <ul class="submenu">
		      <li><a href="buy_house.php">Πωλήσεις Κατοικιών</a></li>
		      <li><a href="buy_workplace.php">Πωλήσεις Επαγγελματικών Χώρων</a></li>
		      <li><a href="buy_land.php">Πωλήσεις Γης</a></li>
		    </ul>
	    </li>
			<li><a class="active" href="new_ad.php">Καταχώρηση Αγγελίας</a></li>
	    <li><a href="about.php">About</a></li>
			<li><a href="mailto:info@e-mesitis.gr">Επικοινωνία</a></li>
	      <?php
					if (isset($_SESSION['userid'])) {
						echo "<li class='rightMenu'><a href='includes/logout.php'>Έξοδος</a></li>
							  	<li class='rightMenu'><a href='profile.php'>My profile</a></li>";
						if ($_SESSION['isadmin'] == '1') {
							echo "<li class='rightMenu'><a href='admin_page.php'>Admin page</a></li>";
						}
						else {
							echo "<li class='rightMenu'><a href='my_ads.php'>Οι αγγελίες μου</a></li>";
						}
					}
					else {
						echo "<li class='rightMenu'><a href='login.php'>Είσοδος</a></li>
		        			<li class='rightMenu'><a href='register.php'>Εγγραφή</a></li>";
					}
				?>
	  </ul>
	</div>


	<!----   CONTENT    ---->
	<div id="textWrapper">
		<h1>Για να καταχωρήσετε την αγγελία σας</h1>
		<h3 align="center">Συμπληρώστε την παρακάτω φόρμα</h3><br/><br/>
	</div>


	<!----   AD-FORM    ---->
	<div id="content">
  	<div id="wrapper">
    	<div id="steps">
				<form id="formElem" name="formElem" action="includes/insert_ad.php" method="post">
          <fieldset class="step">
            <legend>Στοιχεία αγγελίας</legend>
            <p>
              <label for="phone">Τηλέφωνο</label>
              <input id="phone" name="phone" type="text" AUTOCOMPLETE=OFF/>
            </p>
						<p>
              <label for="ad_type">Τύπος αγγελίας</label>
              <select id="ad_type" name="ad_type">
                <option>Sale</option>
                <option>Rent</option>
              </select>
            </p>
          </fieldset>
          <fieldset class="step">
            <legend>Στοιχεία ακινήτου</legend>
            <p>
              <label for="category">Κατηγορία ακινήτου</label>
							<select id="category" name="category">
                <option>Property</option>
                <option>Business Property</option>
                <option>Land</option>
              </select>
            </p>
            <p>
              <label for="surface">Εμβαδό</label>
              <input id="surface" name="surface" type="text" AUTOCOMPLETE=OFF/>
            </p>
            <p>
              <label for="price">Τιμή</label>
              <input id="price" name="price" type="text" AUTOCOMPLETE=OFF/>
            </p>
						<p>
              <label for="available">Διαθέσιμο από</label>
              <input id="popupDatepicker" name="available" type="text">
            </p>
          </fieldset>
          <fieldset class="step">
            <legend>Επιπλέον πληροφορίες</legend>
            <p>
              <label for="bedrooms">Υπνοδωματια</label>
              <input id="bedrooms" name="bedrooms" type="number" value="0" min="0" step="1" AUTOCOMPLETE=OFF/>
            </p>
            <p>
              <label for="bathrooms">Μπάνια</label>
              <input id="bathrooms" name="bathrooms" type="number" value="0" min="0" step="1" AUTOCOMPLETE=OFF/>
            </p>
            <p>
              <label for="wc">WC</label>
              <input id="wc" name="wc" type="number" value="0" min="0" step="1" AUTOCOMPLETE=OFF/>
            </p>
						<p>
              <label for="levels">Επίπεδα</label>
              <input id="levels" name="levels" type="number" value="0" min="0" step="1" AUTOCOMPLETE=OFF/>
            </p>
            <p>
              <label for="floor">Όροφος</label>
              <input id="floor" name="floor" type="text" value="0" AUTOCOMPLETE=OFF/>
            </p>
						<p>
              <label for="year">Έτος κατασκευής</label>
              <input id="year" name="year" type="text" value="0" AUTOCOMPLETE=OFF/>
            </p>
          </fieldset>
					<fieldset class="step">
            <legend>Τοποθεσία ακινήτου</legend>
	          <p>
	            <label for="geo">Γεωγραφικό διαμέρισμα</label>
							<select id="geo" name="geo">
	              <option>Attica</option>
	              <option>Epirus</option>
	              <option>Thessaly</option>
								<option>Salonika</option>
								<option>Thrace</option>
								<option>Crete</option>
								<option>Macedonia</option>
								<option>Aegean Islands</option>
								<option>Ionian Islands</option>
								<option>Peloponnese</option>
								<option>Central Greece</option>
	            </select>
	          </p>
	          <!--<p>
	            <label for="region">Περιοχή</label>
	            <input id="region" name="region" type="text" AUTOCOMPLETE=OFF />
	          </p>-->
	          <p>
	            <label for="commune">Δήμος</label>
	            <input id="commune" name="commune" type="text" AUTOCOMPLETE=OFF/>
	          </p>
	          <p>
	            <label for="address">Διεύθυνση</label>
	            <input id="address" name="address" type="text" AUTOCOMPLETE=OFF/>
	          </p>
						<p>
	            <label for="post_code">Ταχ. Κώδικας</label>
	            <input id="post_code" name="post_code" type="text" AUTOCOMPLETE=OFF/>
	          </p>
          </fieldset>
          <!--<fieldset class="step">
            <legend>Ανάρτηση φωτογραφιών</legend>
	          <p>
	            <label for="files">Φωτογραφίες</label>
	            <input type="file" id="files" name="files[]" multiple/>
							<output id="list"></output>
	          </p>
						<p>
	            <label for="youtube">Eισαγωγή συνδέσμου youtube</label>
	            <input id="youtube" name="youtube" type="text" AUTOCOMPLETE=OFF/>
	          </p>
          </fieldset>-->
					<fieldset class="step">
            <legend>Επιβεβαίωση καταχώρησης</legend>
						<p>
							Όλα τα πεδία της φόρμας συμπληρώθηκαν σωστά
							εάν όλα τα βήματα έχουν ένα πράσινο εικονίδιο.
							Εάν υπάρχει κόκκινο εικονίδιο σημαίνει ότι
							κάποιο πεδίο λείπει ή είναι συμπληρωμένο με άκυρα
							στοιχεία. Σε αυτό το βήμα πρέπει να επιβεβαιώσετε
							την υποβολή της φόρμας.
						</p>
	          <p class="submit"><button id="registerButton" name="insert_bt" type="submit">Επιβεβαίωση</button></p>
          </fieldset>
        </form>
      </div>
			<div id="navigation" style="display:none;">
        <ul>
					<li class="selected"><a href="#">Αγγελία</a></li>
          <li><a href="#">Ακίνητο</a></li>
          <li><a href="#">Extra</a></li>
          <li><a href="#">Τοποθεσία</a></li>
					<!--<li><a href="#">Φωτογραφίες</a></li>-->
					<li><a href="#">Επιβεβαίωση</a></li>
    		</ul>
      </div>
    </div>
	</div>

	<br/><br/><br/>


	<!----   FOOTER    ---->
	<div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
