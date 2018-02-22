<?php
	session_start();
	include 'db_connection.php';
	include 'ldap_connection.php';

	if (isset($_POST['login_bt'])) {

		$username = $_POST['username'];
		$pass = $_POST['password'];

		$username = mysqli_real_escape_string($conn, $username);
		$pass = mysqli_real_escape_string($conn, $pass);

		if (empty($username) || empty($pass)) {
			$_SESSION['msg'] = "Παρακαλώ συμπληρώστε όλα τα πεδία!";
			header("Location: ../error.php");
		}
		else {
			$sql_request = "SELECT * FROM users WHERE username='$username'";
			$result = mysqli_query($conn, $sql_request);
			$row = mysqli_fetch_array($result);

			if (!$conn) {
				die("Query failed! " .mysqli_error('$conn'));
			}
			elseif (!$ldapconn) {
				die("LDAP Connenction failed!");
			}
			elseif ($row['username'] != $username) {
				$_SESSION['msg'] = "Λάθος username! Παρακαλώ προσπαθήστε ξανά.";
				header("Location: ../error.php");
			}
			elseif ($row['isadmin'] == '1') {
				$ldaprootdn = 'cn=Manager,c=EL';
				$ldapbindroot = ldap_bind($ldapconn, $ldaprootdn, 'ellas');

				$ldaptree = 'OU=admins,O=e-mesitis,c=EL';
				$justthis = array("userCertificate;binary");
				$result = ldap_search($ldapconn, $ldaptree, "(cn=$username)", $justthis);
				$entry = ldap_first_entry($ldapconn, $result);
				$value = ldap_get_values_len($ldapconn, $entry, "userCertificate;binary");
				$cer = $value["count"];

				if (!$ldapbindroot) {
					$_SESSION['msg'] = "Αποτυχία σύνδεσης με τον LDAP server!";
					header("Location: ../error.php");
				}
				elseif (isset($cer)) {
					$ldapdn = 'cn='.$username.',OU=registeredUsers,O=e-mesitis,c=EL';
					$ldapbind = ldap_bind($ldapconn, $ldapdn, $pass);

					if (!$ldapbind) {
						$_SESSION['msg'] = "Λάθος κωδικός πρόσβασης! Παρακαλώ προσπαθήστε ξανά.";
						header("Location: ../error.php");
					}
					else {
						$_SESSION['username'] = $row['username'];
						$_SESSION['isadmin'] = $row['isadmin'];
						$_SESSION['userid'] = $row['userid'];
						ldap_close($ldapconn);
						header("Location: ../admin_page.php");
					}
				}
				else {
					$_SESSION['msg'] = "Πρέπει να έχετε πιστοποιηθεί για να συνδεθείτε ως διαχειριστής!";
					header("Location: ../error.php");
				}
			}
			else {
				$ldaprootdn = 'cn=Manager,c=EL';
				$ldapbindroot = ldap_bind($ldapconn, $ldaprootdn, 'ellas');

				$ldapdn = 'cn='.$username.',OU=registeredUsers,O=e-mesitis,c=EL';
				$ldapbind = ldap_bind($ldapconn, $ldapdn, $pass);

				if (!$ldapbindroot) {
					$_SESSION['msg'] = "Αποτυχία σύνδεσης με τον LDAP server!";
					header("Location: ../error.php");
				}
				elseif (!$ldapbind) {
					$_SESSION['msg'] = "Λάθος κωδικός πρόσβασης! Παρακαλώ προσπαθήστε ξανά.";
					header("Location: ../error.php");
				}
				else {
					$_SESSION['username'] = $row['username'];
					$_SESSION['isadmin'] = $row['isadmin'];
					$_SESSION['userid'] = $row['userid'];
					ldap_close($ldapconn);
					header("Location: ../my_ads.php");
				}
			}
		}
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
