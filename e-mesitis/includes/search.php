<?php
	session_start();
	include 'db_connection.php';


	if (isset($_GET['search_bt'])) {

		$salerent = $_GET['salerent'];
		$category = $_GET['category'];
		$geo = $_GET['geo'];
		$region = $_GET['region'];
		$minprice = $_GET['minprice'];
		$maxprice = $_GET['maxprice'];
		$mintm = $_GET['mintm'];
		$maxtm = $_GET['maxtm'];

		$region = mysqli_real_escape_string($conn, $region);
		$minprice = mysqli_real_escape_string($conn, $minprice);
		$maxprice = mysqli_real_escape_string($conn, $maxprice);
		$mintm = mysqli_real_escape_string($conn, $mintm);
		$maxtm = mysqli_real_escape_string($conn, $maxtm);

		if (empty($region)) {
			$_SESSION['msg'] = "Παρακαλώ συμπληρώστε τα απαραίτητα πεδία!";
			header("Location: ../error.php");
		}
		elseif (empty($minprice) && empty($maxprice) && empty($mintm) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region) {
				$_SESSION['region'] = $region;
				header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($maxprice) && empty($mintm) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price>='$minprice'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] < $minprice) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($mintm) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price<='$maxprice'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] > $maxprice) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($maxprice) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND surface>='$mintm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['surface'] < $mintm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($maxprice) && empty($mintm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND surface<='$maxtm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['surface'] > $maxtm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($mintm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price<='$maxprice' AND surface<='$maxtm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] > $maxprice || $row['surface'] > $maxtm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($maxprice) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price>='$minprice' AND surface>='$mintm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] < $minprice || $row['surface'] < $mintm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($maxtm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price<='$maxprice' AND surface>='$mintm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] > $maxprice || $row['surface'] < $mintm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($maxprice) && empty($mintm)) {
			$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
											AND price>='$minprice' AND surface<='$maxtm'";

			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
							|| $row['price'] < $minprice || $row['surface'] > $maxtm) {
								$_SESSION['region'] = $region;
								header("Location: ../no_results.php");
			}
			else{
				$_SESSION['salerent'] = $row['type'];
				$_SESSION['category'] = $row['category'];
				$_SESSION['geo'] = $row['geo'];
				$_SESSION['region'] = $row['commune'];
				$_SESSION['minprice'] = $minprice;
				$_SESSION['mintm'] = $mintm;
				$_SESSION['maxprice'] = $maxprice;
				$_SESSION['maxtm'] = $maxtm;
				header("Location: ../results.php");
			}
		}
		elseif (empty($minprice) && empty($maxprice)) {

			if ($maxtm < $mintm) {
				$_SESSION['msg'] = "Παρακαλώ συμπληρώστε αποδεκτές τιμές!";
				header("Location: ../error.php");
			}
			else {
				$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
												AND surface>='$mintm' AND surface<='$maxtm'";

				$result = mysqli_query($conn, $sql_request);
				$row = mysqli_fetch_array($result);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
								|| $row['surface'] < $mintm || $row['surface'] > $maxtm) {
									$_SESSION['region'] = $region;
									header("Location: ../no_results.php");
				}
				else{
					$_SESSION['salerent'] = $row['type'];
					$_SESSION['category'] = $row['category'];
					$_SESSION['geo'] = $row['geo'];
					$_SESSION['region'] = $row['commune'];
					$_SESSION['minprice'] = $minprice;
					$_SESSION['mintm'] = $mintm;
					$_SESSION['maxprice'] = $maxprice;
					$_SESSION['maxtm'] = $maxtm;
					header("Location: ../results.php");
				}
			}
		}
		elseif (empty($mintm) && empty($maxtm)) {

			if ($maxprice < $minprice) {
				$_SESSION['msg'] = "Παρακαλώ συμπληρώστε αποδεκτές τιμές!";
				header("Location: ../error.php");
			}
			else {
				$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
												AND price>='$minprice' AND price<='$maxprice'";

				$result = mysqli_query($conn, $sql_request);
				$row = mysqli_fetch_array($result);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
								|| $row['price'] < $minprice || $row['price'] > $maxprice) {
									$_SESSION['region'] = $region;
									header("Location: ../no_results.php");
				}
				else{
					$_SESSION['salerent'] = $row['type'];
					$_SESSION['category'] = $row['category'];
					$_SESSION['geo'] = $row['geo'];
					$_SESSION['region'] = $row['commune'];
					$_SESSION['minprice'] = $minprice;
					$_SESSION['mintm'] = $mintm;
					$_SESSION['maxprice'] = $maxprice;
					$_SESSION['maxtm'] = $maxtm;
					header("Location: ../results.php");
				}
			}
		}
		else{

			if ($maxprice < $minprice || $maxtm < $mintm) {
				$_SESSION['msg'] = "Παρακαλώ συμπληρώστε αποδεκτές τιμές!";
				header("Location: ../error.php");
			}
			else {
				$sql_request = "SELECT * FROM ads WHERE type='$salerent' AND category='$category' AND geo='$geo' AND commune='$region'
												AND (price>='$minprice' AND price<='$maxprice') AND (surface>='$mintm' AND surface<='$maxtm')";

				$result = mysqli_query($conn, $sql_request);
				$row = mysqli_fetch_array($result);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				elseif ($row['type'] != $salerent || $row['category'] != $category || $row['geo'] != $geo || $row['commune'] != $region
								|| $row['price'] < $minprice || $row['price'] > $maxprice
								|| $row['surface'] < $mintm || $row['surface'] > $maxtm) {
									$_SESSION['region'] = $region;
									header("Location: ../no_results.php");
				}
				else{
					$_SESSION['salerent'] = $row['type'];
					$_SESSION['category'] = $row['category'];
					$_SESSION['geo'] = $row['geo'];
					$_SESSION['region'] = $row['commune'];
					$_SESSION['minprice'] = $minprice;
					$_SESSION['mintm'] = $mintm;
					$_SESSION['maxprice'] = $maxprice;
					$_SESSION['maxtm'] = $maxtm;
					header("Location: ../results.php");
				}
			}
		}
	}
	else{
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
