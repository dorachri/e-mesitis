<?php
	session_start();
	include 'db_connection.php';

	if (isset($_POST['delete_bt'])) {
		$id = $_POST['delete_bt'];	
		$sql_request = "DELETE FROM ads WHERE ad_id='$id'";
		$result = mysqli_query($conn, $sql_request);
		header("Location: ../my_ads.php");
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>