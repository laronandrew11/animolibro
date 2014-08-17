<?php
include('animolibroerrorhandler.php');
//include('php/authenticator.php');
$dbHost = "localhost";        //Location Of Database usually its localhost 
    $dbUser = "root";            //Database User Name 
    $dbPass = "root";            //Database Password 
    $dbDatabase = "animolibrosimple";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the databasse 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
    //Selects the database 
	?>