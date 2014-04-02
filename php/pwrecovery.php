<?php 
	 
if(isset($_POST['forgotpassword'])){ 
   include('dbConnect.php');
   $email = mysql_real_escape_string($_POST['email']);
   $newpass = md5(uniqid(rand()));
   $pwhash = md5($newpass);
   
   $query = "UPDATE UserAccount SET passwordhash='$pwhash' WHERE email='$email'";
   
   if(mysql_query($query)) {
		$to = $email;
		echo $to;
		$subject = "AnimoLibro Password Recovery";
		$message = "Your new password is: \n";
		$message .= "$newpass";
		
		$sentmail = mail($to,$subject,$message);
		
		if($sentmail)
        {
			$_SESSION['confirmationsent']=true;
			//echo "Your Confirmation link Has Been Sent To Your E-mail Address.";
		}
		else
        {
			$_SESSION['confirmationsent']=false;
			//echo "Cannot send Confirmation link to your E-mail Address";
		};
		header("Location: http://localhost/animolibro/portal.php");
	}else{ echo "Password Recovery failed";}
    exit; 
}   
else {echo "Not submitted!";}
?> 