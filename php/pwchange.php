<?php
if(isset($_POST['submit'])){ 
   include('dbConnect.php');
   $currpass = mysql_real_escape_string($_POST['currpass']);
   $newpass = mysql_real_escape_string($_POST['newpass']);
   $newpassagain = mysql_real_escape_string($_POST['newpassagain']);
   session_start();
   $username=$_SESSION['animolibrousername'];
   if($newpass == $newpassagain){
		$pwhash = md5($newpass);
	   
	    $query = "UPDATE UserAccount SET passwordhash='$pwhash' WHERE username='$username'";
	   
	    if(mysql_query($query)) {
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