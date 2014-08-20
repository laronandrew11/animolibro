<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['submit'])){ 
   include('dbConnect.php');
	$db = database::getInstance(); 

   $email = mysql_real_escape_string($_POST['email']);
   $hash = mysql_real_escape_string($_POST['hash']);
   $newpass = mysql_real_escape_string($_POST['newpass']);
   $newpassagain = mysql_real_escape_string($_POST['newpassagain']);
   if($newpass == $newpassagain){
		$pwhash = md5($newpass);
	   
		$stmt = $db->dbh->prepare("UPDATE UserAccount SET passwordhash=:passwordhash WHERE email=:email AND passwordhash=:hash");
	   
	    if($stmt->execute(array(':passwordhash' => $pwhash, ':email' => $_POST['email'], ':passwordhash' => $_POST['hash']))) {
			$_SESSION['pwchange']=true;
			header("Location: http://localhost/animolibro/portal.php");
		}else { 
			$_SESSION['pwchange']=false;
			header("Location: http://localhost/animolibro/portal.php");
		}
		exit; 
	}
	else{echo "Change Password failed";}
}   
else {echo "Not submitted!";}
?>