<?php

	$conn = mysqli_connect("localhost", "root", "", "mesitiko_grafeio");

	if (!$conn) {
		die("Connenction failed! " .mysqli_connect_error());
	}

?>
