<?php
	session_start();
	include 'includes/db_connection.php';

	if (empty($_SESSION['region'])) {
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Αποτελέσματα</title>
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
    <h1>Αποτελέσματα Αναζήτησης</h1>
		<br/><br/><br/><br/><br/><br/>

    	<?php

    		$salerent = $_SESSION['salerent'];
    		$category = $_SESSION['category'];
				$geo = $_SESSION['geo'];
    		$region = $_SESSION['region'];
    		$minprice = $_SESSION['minprice'];
    		$minarea = $_SESSION['mintm'];
    		$maxprice = $_SESSION['maxprice'];
    		$maxarea = $_SESSION['maxtm'];

				if (empty($minprice) && empty($maxprice) && empty($minarea) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'";
				}
				elseif (empty($maxprice) && empty($minarea) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price>='$minprice'";
				}
				elseif (empty($minprice) && empty($minarea) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price<='$maxprice'";
				}
				elseif (empty($minprice) && empty($maxprice) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND surface>='$minarea'";
				}
				elseif (empty($minprice) && empty($maxprice) && empty($minarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND surface<='$maxarea'";
				}
				elseif (empty($minprice) && empty($minarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price<='$maxprice' AND surface<='$maxarea'";
				}
				elseif (empty($maxprice) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price>='$minprice' AND surface>='$minarea'";
				}
				elseif (empty($minprice) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price<='$maxprice' AND surface>='$minarea'";
				}
				elseif (empty($maxprice) && empty($minarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND price>='$minprice' AND surface<='$maxarea'";
				}
				elseif (empty($minprice) && empty($maxprice)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND (surface>='$minarea' AND surface<='$maxarea')";
				}
				elseif (empty($minarea) && empty($maxarea)) {
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND (price>='$minprice' AND price<='$maxprice')";
				}
				else{
					$query = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
										AND (price>='$minprice' AND price<='$maxprice') AND (surface>='$minarea' AND surface<='$maxarea')";
				}


				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_array($result);

				$num_rows = mysqli_num_rows($result);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				else {

					if ($salerent == 'Rent') {
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
					else {
						echo "<div id=".$row['ad_id']." class='ad-container'>
										<img src=".$row['image']." alt='No image available'/>
										<div class='text-container'>
											<h3>FOR SALE</h3>
											<h4>Location: ".$row['commune']."</h4>
											<h4>Price: &euro;".$row['price']."</h4>
											<h4>Area: ".$row['surface']." m<sup>2</sup></h4>
										</div>
										<div class='button'>
											<form action='includes/show_ad.php' method='POST'>
												<button name='show_bt' type='submit' value=".$row['ad_id'].">Show more</button>
											</form>
										</div>
								  </div>";

					}

					while ($row = mysqli_fetch_array($result)) {

						if ($salerent == 'Rent') {
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
						else {
							echo "<div id=".$row['ad_id']." class='ad-container'>
											<img src=".$row['image']." alt='No image available'/>
											<div class='text-container'>
												<h3>FOR SALE</h3>
												<h4>Location: ".$row['commune']."</h4>
												<h4>Price: &euro;".$row['price']."</h4>
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
				}
    	?>
  </div>


	<!----   FOOTER    ---->
  <div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
