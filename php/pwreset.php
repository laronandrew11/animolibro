<?php
if(isset($_POST['submit'])){ 
   include('dbConnect.php');
   $email = mysql_real_escape_string($_POST['email']);
   $newpass = mysql_real_escape_string($_POST['newpass']);
   $newpassagain = mysql_real_escape_string($_POST['newpassagain']);
   if($newpass == $newpassagain){
		$pwhash = md5($newpass);
	   
	    $query = "UPDATE UserAccount SET passwordhash='$pwhash' WHERE email='$email'";
	   
	    if(mysql_query($query)) {
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