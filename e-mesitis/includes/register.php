<?php
	session_start();
	include 'db_connection.php';
	include 'ldap_connection.php';

	if (isset($_POST['register_bt'])) {

		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$pass2 = $_POST['password2'];

		$name = mysqli_real_escape_string($conn, $name);
		$surname = mysqli_real_escape_string($conn, $surname);
		$username = mysqli_real_escape_string($conn, $username);
		$email = mysqli_real_escape_string($conn, $email);
		$pass = mysqli_real_escape_string($conn, $pass);
		$pass2 = mysqli_real_escape_string($conn, $pass2);

		if (empty($name) || empty($surname)|| empty($username) || empty($email)|| empty($pass) || empty($pass2)) {
			$_SESSION['msg'] = "Παρακαλώ συμπληρώστε όλα τα πεδία!";
			header("Location: ../error.php");
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['msg'] = "Το email που δώσατε δεν είναι έγκυρο! Παρακαλώ συμπληρώστε ένα έγκυρο email.";
			header("Location: ../error.php");
		}
		elseif (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $pass) == 0) {
			$_SESSION['msg'] = "Ο κωδικός σας πρέπει να περιέχει τουλάχιστον ένα κεφαλαίο και ένα μικρό γράμμα, ένα ψηφίο και να έχει μήκος τουλάχιστον 8 χαρακτήρες!";
			header("Location: ../error.php");
		}
		elseif ($pass != $pass2) {
			$_SESSION['msg'] = "Οι κωδικοί πρόσβασης δεν ταιριάζουν! Παρακαλώ επαναλάβετε την διαδικασία.";
			header("Location: ../error.php");
		}
		elseif (empty($_POST['terms'])) {
			$_SESSION['msg'] = "Πρέπει να αποδεχτείτε τους όρους χρήσης για να συνεχίσετε!";
			header("Location: ../error.php");
		}
		else {
			$sql_request = "SELECT * FROM users WHERE username='$username'";
			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif ($username == $row['username']) {
				$_SESSION['msg'] = "Το username υπάρχει ήδη! Παρακαλώ επιλέξτε κάποιο άλλο.";
				header("Location: ../error.php");
			}
			else {
				$sql_insert = "INSERT INTO users(name, surname, username, email)
											 VALUES('$name', '$surname', '$username', '$email')";

				$result2 = mysqli_query($conn, $sql_insert);

				if (!$conn) {
					die("Query failed! " .mysqli_error('$conn'));
				}
				elseif (!$ldapconn) {
					die("LDAP Connenction failed!");
				}
				else {
					$ldaprootdn = 'cn=Manager,c=EL';
					$ldapbindroot = ldap_bind($ldapconn, $ldaprootdn, 'ellas');

					if (!$ldapbindroot) {
						$_SESSION['msg'] = "Αποτυχία σύνδεσης με τον LDAP server!";
						header("Location: ../error.php");
					}
					else {
						$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',4)),0,4);
	 					$hash = '{ssha}' . base64_encode(sha1($pass.$salt, TRUE). $salt);

				    // prepare data
				    $record["cn"] = $username;
				    $record["sn"] = $surname;
						$record["userPassword"] = $hash;
						$record["ou"] = "registeredUsers";
				    $record["objectclass"][0] = "top";
						$record["objectclass"][1] = "organizationalPerson";
						$record["objectclass"][2] = "person";

				    // add data to directory
						$ldapdn = 'cn='.$username.',OU=registeredUsers,O=e-mesitis,c=EL';
						$r = ldap_add($ldapconn, $ldapdn, $record);
						ldap_close($ldapconn);

						header("Location: ../login.php");
					}
				}
			}
		}
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
