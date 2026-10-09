<?php
	session_start();
	$_SESSION= []; //empties the session variables
	session_destroy();
	header("Location: index.php");
	exit();
?>
