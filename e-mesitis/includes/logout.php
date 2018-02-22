<?php
	session_start();
	session_unset();
	session_destroy();
	ldap_close($ldapconn);
	header("Location: ../login.php");
?>
