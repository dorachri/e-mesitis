<?php
	session_start();
	include 'includes/db_connection.php';

	unset ($_SESSION['region']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ενοικιάσεις επαγ. χώρων</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="includes/StyleSheet.css"/>
	<link rel="shortcut icon" href="includes/images/favicon.ico">
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
	    <li><a class="active" href="">Ενοικιάσεις</a>
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
	    <li><a href="new_ad.php">Καταχώρηση Αγγελίας</a></li>
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
		<h1>Βρες εύκολα το επόμενο ακίνητό σου</h1>
		<h3 align="center">Όλες οι αγγελίες ακινήτων της Ελλάδας</h3>
  </div>


	<!----   SEARCH    ---->
	<div id="searchWrapper">
		<div id="searchBox">
			<br/><br/>
			<form class="search" action="includes/search.php" method="GET">
				<select class="" name="salerent">
					<option value="Sale">Buy</option>
					<option value="Rent" selected>Rent</option>
				</select>
				<select name="category">
					<option value="Property">Property</option>
					<option value="Business Property" selected>Business Property</option>
					<option value="Land">Land</option>
				</select>
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
				<br/>
				<input id="region" name="region" pattern="^[A-Za-z]+$" placeholder="π.χ. Αθήνα, Καλλιθέα, Γλυφάδα" type="text" style="width:65%;" AUTOCOMPLETE=OFF maxlength="15" required="required"/>
				<br/>
				<input type="text" pattern="^[0-9]+$" placeholder="€ από" name="minprice" maxlength="6"/>
				<input type="text" pattern="^[0-9]+$" placeholder="€ έως" name="maxprice" maxlength="6"/>
				<input type="text" pattern="^[0-9]+$" placeholder="τ.μ. από" name="mintm" maxlength="4"/>
				<input type="text" pattern="^[0-9]+$" placeholder="τ.μ. έως" name="maxtm" maxlength="4"/>
				<br/><br/>
				<input type="submit" name="search_bt" value="Αναζήτηση">
				<br/><br/><br/>
			</form>
		</div>
	</div>


	<!----   CONTENT    ---->
  <div id="textWrapper">
    <h1>Επαγ. Χώροι προς ενοικίαση</h1>
		<br/><br/><br/>

    	<?php
    		$query = "SELECT * FROM ads WHERE type='Rent' AND category='Business Property' ORDER BY ad_id DESC LIMIT 6";
				$result = mysqli_query($conn, $query);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				else{
					while ($row = mysqli_fetch_array($result)) {
					    echo "<div id=".$row['ad_id']." class='ad-container'>
						        	<img src=".$row['image']." alt='No image available'/>
						        	<div class='text-container'>
												<h3>TO RENT</h3>
												<h4>Location: ".$row['commune']."</h4>
												<h4>Price: &euro;".$row['price']."/month</h4>
												<h4>Area: ".$row['surface']." m<sup>2</sup></h4>
											</div>
											<div class='button'>
												<form action='includes/show_ad.php' method='POST'>
													<button name='show_bt' type='submit' value=".$row['ad_id'].">Show more</button>
												</form>
											</div>
								  	</div>";
					}
				}
    	?>
  </div>


	<!----   FOOTER    ---->
  <div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
