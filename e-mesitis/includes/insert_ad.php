<?php
	session_start();
	include 'db_connection.php';

	if (isset($_POST['insert_bt'])) {
		if (isset($_SESSION['userid'])) {

			$userid = $_SESSION['userid'];
			$phone = $_POST['phone'];
			$ad_type = $_POST['ad_type'];
			$category = $_POST['category'];
			$surface = $_POST['surface'];
			$price = $_POST['price'];
			$available = $_POST['available'];
			$bedrooms = $_POST['bedrooms'];
			$bathrooms = $_POST['bathrooms'];
			$wc = $_POST['wc'];
			$levels = $_POST['levels'];
			$floor = $_POST['floor'];
			$year = $_POST['year'];
			$geo = $_POST['geo'];
			$commune = $_POST['commune'];
			$address = $_POST['address'];
			$post_code = $_POST['post_code'];

			$phone = mysqli_real_escape_string($conn, $phone);
			$surface = mysqli_real_escape_string($conn, $surface);
			$price = mysqli_real_escape_string($conn, $price);
			$available = mysqli_real_escape_string($conn, $available);
			$bedrooms = mysqli_real_escape_string($conn, $bedrooms);
			$bathrooms = mysqli_real_escape_string($conn, $bathrooms);
			$wc = mysqli_real_escape_string($conn, $wc);
			$levels = mysqli_real_escape_string($conn, $levels);
			$floor = mysqli_real_escape_string($conn, $floor);
			$year = mysqli_real_escape_string($conn, $year);
			$commune = mysqli_real_escape_string($conn, $commune);
			$address = mysqli_real_escape_string($conn, $address);
			$post_code = mysqli_real_escape_string($conn, $post_code);


			//$photos = $_POST['files[]'];
			//$youtubelink = $_POST['youtube'];

			$sql_insert = "INSERT INTO ads(phone, type, category, surface, price, available, bedrooms, bathrooms, wc, levels, floor, year, geo, commune, address, post_code, userid)
						   VALUES('$phone', '$ad_type', '$category', '$surface', '$price', '$available', '$bedrooms', '$bathrooms', '$wc', '$levels', '$floor', '$year', '$geo', '$commune', '$address', '$post_code', $userid)";


			$result = mysqli_query($conn, $sql_insert);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			else  {
				$_SESSION['msg'] = "Η αγγελία σας δημοσιεύτηκε με επιτυχία! Μεταφερθείτε στην καρτέλα \"Οι αγγελίες μου\" για να μπορέσετε να την δείτε.";
				header("Location: ../success.php");
			}

		}
		else {
			header("Location: ../login.php");
		}
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
