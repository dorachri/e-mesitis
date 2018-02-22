<?php
	session_start();
	include 'db_connection.php';
	include 'ldap_connection.php';

	if (isset($_POST['change_bt'])) {

		$old = $_POST['old_pass'];
		$new = $_POST['new_pass'];
		$new2 = $_POST['new_pass2'];
		$username = $_POST['change_bt'];
		//$username = $_SESSION['username'];

		if (empty($old) || empty($new)|| empty($new2)) {
			$_SESSION['msg'] = "Παρακαλώ συμπληρώστε όλα τα πεδία!";
			header("Location: ../error.php");
		}
		elseif (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $new) == 0) {
			$_SESSION['msg'] = "Ο κωδικός σας πρέπει να περιέχει τουλάχιστον ένα κεφαλαίο και ένα μικρό γράμμα, ένα ψηφίο και να έχει μήκος τουλάχιστον 8 χαρακτήρες!";
			header("Location: ../error.php");
		}
		elseif ($new != $new2) {
			$_SESSION['msg'] = "Οι κωδικοί πρόσβασης δεν ταιριάζουν! Παρακαλώ επαναλάβετε την διαδικασία.";
			header("Location: ../error.php");
		}
		else {
			//$sql_request = "SELECT * FROM users WHERE userid='$id'";
			//$result = mysqli_query($conn, $sql_request);
			//$row = mysqli_fetch_array($result);

			// Για να επαληθεύσουμε το παλιό password
			$ldapdn = 'cn='.$username.',OU=registeredUsers,O=e-mesitis,c=EL';
			$ldapbind = ldap_bind($ldapconn, $ldapdn, $old);

			// Για να μπορέσουμε να τροποποιήσουμε την εγγραφή
			$ldaprootdn = 'cn=Manager,c=EL';
			$ldapbindroot = ldap_bind($ldapconn, $ldaprootdn, 'ellas');

			if (!$ldapbindroot) {
				$_SESSION['msg'] = "Αποτυχία σύνδεσης με τον LDAP server!";
				header("Location: ../error.php");
			}
			elseif (!$ldapbind) {
				$_SESSION['msg'] = "Λάθος κωδικός πρόσβασης!";
				header("Location: ../error.php");
			}
			else {
				//$sql_request2 = "UPDATE users SET password='$new' WHERE userid='$id'";
				//$result2 = mysqli_query($conn, $sql_request2);

				$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',4)),0,4);
				$hash = '{ssha}' . base64_encode(sha1($new.$salt, TRUE). $salt);
				$newval["userPassword"] = $hash;
				ldap_modify($ldapconn, $ldapdn, $newval);
				ldap_close($ldapconn);

				$_SESSION['msg'] = "Η αλλαγή του κωδικού σας έγινε με επιτυχία!";
				header("Location: ../success.php");
			}
		}
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
