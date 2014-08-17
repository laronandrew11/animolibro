<?php
include_once('animolibroerrorhandler.php');
	session_start();
	session_unset();
	session_destroy();
	header("location: http://localhost/animolibro/portal.php");
?>
