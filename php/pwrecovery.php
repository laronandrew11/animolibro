<?php 
	 
if(isset($_POST['forgotpassword'])){ 
   include('dbConnect.php');
   $email = mysql_real_escape_string($_POST['email']);
   
   $query = "SELECT * FROM UserAccount WHERE email='$email' LIMIT 1";
   
   if(mysql_query($query)) {
		$to = $email;
		echo $to;
		$subject = "AnimoLibro Password Recovery";
		$message = "You're receiving this e-mail because you or someone else has requested a password for your user account.\nIt can be safely ignored if you did not request a password reset. Click the link below to reset your password.\n";
		$message .= "http://localhost/animolibro/resetpassword.php?email='.$email.'";
		
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