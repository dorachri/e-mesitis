<?php

	$ldaphost = "ldap://localhost:389/c=EL";
	
	// Connecting to LDAP
	$ldapconn = ldap_connect($ldaphost)
					or die("Could not connect to {$ldaphost}!");

?>
