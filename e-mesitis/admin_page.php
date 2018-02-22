<?php
	session_start();
	include 'includes/db_connection.php';

	if ($_SESSION['isadmin'] != '1') {
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="includes/StyleSheet.css">
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
							echo "<li class='rightMenu'><a class='active' href='admin_page.php'>Admin page</a></li>";
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

		<h1>Admin page</h1>
		<h3 align="center">Διαχείριση του Website</h3>
		<br/><br/><br/><br/><br/>

		<h1>Πίνακας αγγελιών</h1>
		<br/><br/>

		<?php
			$query = "SELECT * FROM ads";
			$result = mysqli_query($conn, $query);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
 		?>

		<table class="table">
			<tr>
    		<th>Ad-ID</th>
				<th>Owner-ID</th>
    		<th>Available</th>
    		<th>Type</th>
    		<th>Location</th>
    		<th>Address</th>
    		<th>Price</th>
    		<th>Area</th>
				<th>Details</th>
    		<th>Action</th>
    	</tr>

		<?php
			while ($row = mysqli_fetch_array($result)) {
				$tmp = $row['ad_id'];
				$tmp2 = $row['type'];

    		echo "<tr>
					  	<td>".$row['ad_id']."</td>
							<td>".$row['userid']."</td>";

				if ($tmp2 == 'Rent') {
					echo "<td>To Rent</td>";
				}
				else {
					echo "<td>For Sale</td>";
				}
				echo "<td>".$row['category']."</td>
							<td>".$row['commune']."</td>
							<td>".$row['address']."</td>
							<td>&euro;".$row['price']."</td>
							<td>".$row['surface']."m<sup>2</sup></td>
							<td>
								<form action='includes/show_ad.php' method='POST'>
									<button name='show_bt' type='submit' value=".$tmp.">Show</button>
								</form>
							</td>
							<td>
								<form action='includes/delete_by_admin.php' method='POST'>
									<button name='delete_bt' type='submit' value=".$tmp.">Delete</button>
								</form>
							</td>
							</tr>";
	    }
	    echo "</table>
					  <br/><br/><br/><br/><br/><br/>";
		?>

		<h1>Πίνακας χρηστών</h1>
		<br/><br/>

		<?php
			$query2 = "SELECT * FROM users";
			$result2 = mysqli_query($conn, $query2);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
 		?>

    <table class="table">
    	<tr>
    		<th>ID</th>
				<th>Status</th>
				<th>Name</th>
    		<th>Surname</th>
    		<th>Username</th>
    		<th>Email</th>
    		<th>Action</th>
    	</tr>

		<?php
			while ($row2 = mysqli_fetch_array($result2)) {

			$tmp3 = $row2['isadmin'];
    	$tmp4 = $row2['userid'];

    	echo "<tr>
					  <td>".$row2['userid']."</td>";

			if ($tmp3 == '1') {
				echo "<td>admin</td>";
			}
			else {
				echo "<td>user</td>";
			}
			echo "<td>".$row2['name']."</td>
						<td>".$row2['surname']."</td>
						<td>".$row2['username']."</td>
						<td>".$row2['email']."</td>
						<td>
							<form action='includes/delete_by_admin.php' method='POST'>
								<button name='delete_bt2' type='submit' value=".$tmp4.">Delete</button>
							</form>
						</td>
						</tr>";
	    }
	    echo "</table>";
    ?>
  </div>


  <!----   FOOTER    ---->
	<div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
