<?php
	session_start();
	include 'includes/db_connection.php';
	//include 'includes/ldap_connection.php';

	if (empty($_SESSION['userid'])) {
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Το προφίλ μου</title>
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
							  	<li class='rightMenu'><a class='active' href='profile.php'>My profile</a></li>";
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
		<h2>Το προφίλ μου</h2><br/><br/>

    <?php

			$userid = $_SESSION['userid'];
			$sql_request = "SELECT name, surname, username, email FROM users WHERE userid='$userid'";
			$result = mysqli_query($conn, $sql_request);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}

			while ($row = mysqli_fetch_array($result)) {

				$name = $row['name'];
				$surname = $row['surname'];
				$username = $row['username'];
				$email = $row['email'];

				echo "<form class='table-form' action='includes/update_profile.php' method='POST'>
								<table>
									<tr>
										<td><h3>Όνομα:</h3></td>
										<td><input type='text' name='name' pattern='^[A-Za-z]+$' maxlength='20' value='".$name."' disabled='disabled'/></td>
									</tr>
									<tr>
										<td><h3>Επώνυμο:</h3></td>
										<td><input type='text' name='surname' pattern='^[A-Za-z]+$' maxlength='40' value='".$surname."' disabled='disabled'/></td>
									</tr>
									<tr>
										<td><h3>Username:</h3></td>
										<td><input type='text' name='username' pattern='^[0-9a-zA-Z]+$' maxlength='20' value='".$username."' disabled='disabled'/></td>
									</tr>
									<tr>
										<td><h3>Email:</h3></td>
										<td><input type='email' name='email' maxlength='30' value='".$email."' required='required'/></td>
									</tr>
									<tr>
										<td><br/><br/><br/><button type='submit' name='update_bt' value=".$userid.">Αποθήκευση</button></td>
										<td><br/><br/><br/><a href='password.php'><button>Αλλαγή κωδικού</button></a></td>
									</tr>
								</table>
						  </form>";
							//$_SESSION['username'] = $username;
			}
    ?>
  </div>


  <!----   FOOTER    ---->
  <div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
