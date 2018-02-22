<?php
	session_start();
	include 'includes/db_connection.php';

	if (empty($_SESSION['ad_id'])) {
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Λεπτομέρειες αγγελίας</title>
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
	<br/><br/>

		<?php

			$id = $_SESSION['ad_id'];
			$sql_request = "SELECT * FROM ads WHERE ad_id='$id'";
			$result = mysqli_query($conn, $sql_request);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}

			while ($row = mysqli_fetch_array($result)) {

				$phone = $row['phone'];
				$salerent = $row['type'];
				$category = $row['category'];
				$surface = $row['surface'];
				$price = $row['price'];
				$available = $row['available'];
				$rooms = $row['bedrooms'];
				$baths = $row['bathrooms'];
				$wc = $row['wc'];
				$levels = $row['levels'];
				$floor = $row['floor'];
				$year = $row['year'];
				$geo = $row['geo'];
				$commune = $row['commune'];
				$address = $row['address'];
				$post_code = $row['post_code'];


				if ($salerent == 'Rent')
					echo "<h1 class='ad_details'>To Rent, $category $surface m<sup>2</sup>, $commune, &euro;$price/month</h1>";
				else
					echo "<h1 class='ad_details'>For Sale, $category $surface m<sup>2</sup>, $commune, &euro;$price</h1>";

				echo "<div class='image'>
							<img src=".$row['image']." alt='No image available'/>
					  	</div>";
				echo "<table class='details'>
							<thead>
								<tr>
								  <th scope='col' colspan='5'>General</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Location</td>
									<td>Price</td>
									<td>Area</td>
									<td>Type</td>
									<td>Contact</td>
								</tr>
								<tr>
									<td>$commune</td>
									<td>&euro;$price</td>
									<td>$surface m<sup>2</sup></td>
									<td>$category</td>
									<td>$phone</td>
								</tr>
							</tbody>
							</table>
						<table class='details'>
							<thead>
								<tr>
								  <th scope='col' colspan='7'>Details</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Available since</td>
									<td>Rooms</td>
									<td>Bathrooms</td>
									<td>WC</td>
									<td>Floor</td>
									<td>Levels</td>
									<td>Construction year</td>
								</tr>
								<tr>
									<td>$available</td>
									<td>$rooms</td>
									<td>$baths</td>
									<td>$wc</td>
									<td>$floor</td>
									<td>$levels</td>
									<td>$year</td>
								</tr>
							</tbody>
						</table>
						<table class='details'>
							<thead>
								<tr>
								  <th scope='col' colspan='4'>Location</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Geographical Appartement</td>
									<td>Commune</td>
									<td>Address</td>
									<td>Post code</td>
								</tr>
								<tr>
									<td>$geo</td>
									<td>$commune</td>
									<td>$address</td>
									<td>$post_code</td>
								</tr>
							</tbody>
						</table>";
			}
    	?>
  </div>


	<!----   FOOTER    ---->
  <div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>

<?php
	unset ($_SESSION['ad_id']);
?>
