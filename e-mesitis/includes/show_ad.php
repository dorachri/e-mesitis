<?php
	session_start();
	include 'db_connection.php';


	if (isset($_POST['show_bt'])) {

		$id = $_POST['show_bt'];

		$sql_request = "SELECT * FROM ads WHERE ad_id='$id'";

		$result = mysqli_query($conn, $sql_request);
		$row = mysqli_fetch_array($result);

		if (!$conn) {
			die("Query failed! " .mysqli_error('$conn'));
		}
		else {
			$_SESSION['ad_id'] = $row['ad_id'];
			header("Location: ../ad_details.php");
		}
	}
	else{
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
