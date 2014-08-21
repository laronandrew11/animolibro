<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");	 

if(isset($_POST['submit'])) {
   $db = database::getInstance(); 

   $email = $_POST['user_email'];
   
   $user_query = $db->dbh->prepare("SELECT * FROM UserAccount WHERE email = :email LIMIT 1");
   $user_query->bindParam(':email', $email);
   
   if($user_query->execute()) {
		$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
		$password_hash = $user_row['passwordhash'];
		$to = $email;
		echo $to;
		$subject = "AnimoLibro Password Recovery";
		$message = "You're receiving this e-mail because you or someone else has requested a password for your user account.\nIt can be safely ignored if you did not request a password reset. Click the link below to reset your password.\n";
		$password_message .= "http://localhost/animolibro/resetpassword.php?email='.$email.'&hash='.$hash.'";
		
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
		header("Location: ../portal.php");
	}else{ echo "Password Recovery failed";}
    exit; 
}   
else {echo "Not submitted!";}
?> 