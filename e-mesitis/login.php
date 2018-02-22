<?php
	session_start();

	if (isset($_SESSION['userid'])) {
		header("Location: home.php");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Είσοδος</title>
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
						echo "<li class='rightMenu'><a class='active' href='login.php'>Είσοδος</a></li>
		        			<li class='rightMenu'><a href='register.php'>Εγγραφή</a></li>";
					}
				?>
	  </ul>
	</div>


	<!----   CONTENT    ---->
	<div id="textWrapper">
		<h2>Είσοδος στο e-mesitis</h2><br/><br/>
   	<form action="includes/login.php" method="POST">
			<h3>Username:</h3>
			<input type="text" pattern="^[0-9a-zA-Z]+$" maxlength="20" name="username" required="required"/>
			<h3>Κωδικός:</h3>
			<input type="password" pattern="^[0-9a-zA-Z]+$" maxlength="20" name="password" required="required" autocomplete="off"/><br/><br/>
			<input type="submit" name="login_bt" value="Είσοδος">
		  <br/><br/>
	  </form>
  </div>


	<!----   FOOTER    ---->
	<div id="footer">
		Copyright 2016 <a href="http://www.unipi.gr/unipi/el/"> Πανεπιστήμιο Πειραιώς</a> - <a href="http://www.cs.unipi.gr/">Τμήμα Πληροφορικής </a>
	</div>

</body>
</html>
