<?php
	session_start();
	include 'db_connection.php';

	if (isset($_POST['update_bt'])) {

		$email = $_POST['email'];
		$id = $_POST['update_bt'];

		$email = mysqli_real_escape_string($conn, $email);

		if (empty($email)) {
			$_SESSION['msg'] = "Παρακαλώ συμπληρώστε τα απαραίτητα πεδία!";
			header("Location: ../error.php");
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['msg'] = "Το email που δώσατε δεν είναι έγκυρο! Παρακαλώ συμπληρώστε ένα έγκυρο email.";
			header("Location: ../error.php");
		}
		else {
			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			else {
				$sql_request = "UPDATE users SET email='$email' WHERE userid='$id'";
				$result = mysqli_query($conn, $sql_request);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				else {
					header("Location: ../profile.php");
				}
			}
		}
	}
	else {
		header("Location: ../password.php");
	}

?>
