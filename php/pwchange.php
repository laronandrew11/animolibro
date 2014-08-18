<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
if(isset($_POST['submit'])){ 
   include('dbConnect.php');
   $db = database::getInstance(); 

   $currpass = mysql_real_escape_string($_POST['currpass']);
   $newpass = mysql_real_escape_string($_POST['newpass']);
   $newpassagain = mysql_real_escape_string($_POST['newpassagain']);
   session_start();
   $username=$_SESSION['animolibrousername'];
   if($newpass == $newpassagain){
		$pwhash = md5($newpass);
	   	
	   	$stmt = $db->dbh->prepare("UPDATE UserAccount SET passwordhash = :passwordhash WHERE username = :username");
	   	
	    if($stmt->execute(array(':passwordhash' => $pwhash, ':username' => $username))) {
			$_SESSION['pwchange']=true;
			header("Location: http://localhost/animolibro/home.php");
		}else { 
			$_SESSION['pwchange']=false;
			header("Location: http://localhost/animolibro/home.php");
		}
		exit; 
	}
	else{echo "Change Password failed";}
}   
else {echo "Not submitted!";}
?>