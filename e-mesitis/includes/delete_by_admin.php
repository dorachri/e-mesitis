<?php
	session_start();
	include 'db_connection.php';
	include 'ldap_connection.php';

	if (isset($_POST['delete_bt'])) {

		$id = $_POST['delete_bt'];
		$sql_request = "DELETE FROM ads WHERE ad_id='$id'";
		$result = mysqli_query($conn, $sql_request);
		header("Location: ../admin_page.php");
	}
	elseif (isset($_POST['delete_bt2'])) {

		$id2 = $_POST['delete_bt2'];

		// Για να έχουμε πρόσβαση στο username
		$sql_request2 = "SELECT * FROM users WHERE userid='$id2'";
		$result2 = mysqli_query($conn, $sql_request2);
		$row = mysqli_fetch_array($result2);
		$userid = $row['userid'];
		$username = $row['username'];
		$isadmin = $row['isadmin'];

		if ($userid != $_SESSION['userid']) {
			$sql_request3 = "DELETE FROM users WHERE userid='$id2'";
			$result3 = mysqli_query($conn, $sql_request3);

			$ldaprootdn = 'cn=Manager,c=EL';
			$ldapbindroot = ldap_bind($ldapconn, $ldaprootdn, 'ellas');
			$ldapdn = 'cn='.$username.',OU=registeredUsers,O=e-mesitis,c=EL';
			ldap_delete($ldapconn, $ldapdn);

			if ($isadmin == '1') {
				$ldaptree = 'OU=admins,O=e-mesitis,c=EL';
				$justthis = array("ou");
				$result = ldap_search($ldapconn, $ldaptree, "(cn=$username)", $justthis);
				$entry = ldap_first_entry($ldapconn, $result);
				$value = ldap_get_values($ldapconn, $entry, "ou");
				$ou = $value["count"];
				if (isset($ou)) {
					$ldapdn2 = 'cn='.$username.',OU=admins,O=e-mesitis,c=EL';
					ldap_delete($ldapconn, $ldapdn2);
				}
			}
			ldap_close($ldapconn);
			header("Location: ../admin_page.php");
		}
		else {
			$_SESSION['msg'] = "Δεν μπορείτε να διαγράψετε ο ίδιος τον λογαριασμό σας! Παρακαλώ απευθυνθείτε σε κάποιον άλλον διαχειριστή για την λειτουργία αυτή.";
			header("Location: ../error.php");
		}
	}
	else {
		$_SESSION['msg'] = "Έγινε κάποιο λάθος στην υποβολή της φόρμας! Παρακαλώ επαναλάβετε την διαδικασία.";
		header("Location: ../error.php");
	}

?>
