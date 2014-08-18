<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
if(isset($_POST['submit1'])&&$_POST['myprofile']==true){ 
   include('dbConnect.php');
   $db = database::getInstance(); 
     
    $adid = mysql_real_escape_string($_POST['adid']);  //change to number instead of string?
	$status = mysql_real_escape_string($_POST['submit1']);
	session_start(); 
	$buyerid =  $_SESSION['animolibroid']; //not sure if this is right
	if($status == "Accept")
	{
		$stmt = $db->dbh->prepare("UPDATE Ad SET status = :status WHERE id = :adid");
	
		if($stmt->execute(array(':status' => 2,':id' => $_POST['adid']))){
		header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION['animolibrousername']);
		}
		else header("Location: http://localhost/errorpage.php"); 
	        //session_start(); 
	        //$_SESSION['username'] = $row['username'];
	        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
	    exit; 
	//	$update_ad ="UPDATE Ad SET status = 2 WHERE id = $adid"; 
	}
	else
	{
		$stmt = $db->dbh->prepare("UPDATE Ad SET status = :status WHERE id = :adid");
		
		if($stmt->execute(array(':status' => 3,':id' => $_POST['adid']))){
		header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION['animolibrousername']);
		}
		else header("Location: http://localhost/errorpage.php"); 
	        //session_start(); 
	        //$_SESSION['username'] = $row['username'];
	        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
	    exit; 
	//	$update_ad ="UPDATE Ad SET status = 3 WHERE id = $adid";
	}
	/*
	if(mysql_query($update_ad)){
		header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION['animolibrousername']);
	}
	else header("Location: http://localhost/errorpage.php"); 
        //session_start(); 
        //$_SESSION['username'] = $row['username'];
        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
    exit; */

}else{    //If the form button wasn't submitted go to the index page, or login page 
	header("Location: http://localhost/animolibro/home.php");     
    exit; 
}
?>