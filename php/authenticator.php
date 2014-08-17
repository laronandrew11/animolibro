<?php

if(!($_SESSION['animolibrousername'])){
	//reject the user
		
		header("Location: http://localhost/animolibro/portal.php");
		//echo '<li><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
		}
	else 
	//accept the user
	{
		//echo '<li  class="active"><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';

	}
	?>