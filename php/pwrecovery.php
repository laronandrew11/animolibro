<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");	 

if(isset($_POST['submit'])){ 
   include('dbConnect.php');
   $db = database::getInstance(); 

   $email = mysql_real_escape_string($_POST['user_email']);
   
   $query = "SELECT * FROM UserAccount WHERE email='$email' LIMIT 1";
   
   $stmt = $db->dbh->prepare("SELECT * FROM UserAccount WHERE email=:email LIMIT 1");
   $stmt->execute(array(':email' => $_POST['user_email'])

   if($hashquery = mysql_query($query)) {
		$hashrow = $stmt->fetchAll();
		$hash = $hashrow['passwordhash'];
		$to = $email;
		echo $to;
		$subject = "AnimoLibro Password Recovery";
		$message = "You're receiving this e-mail because you or someone else has requested a password for your user account.\nIt can be safely ignored if you did not request a password reset. Click the link below to reset your password.\n";
		$message .= "http://localhost/animolibro/resetpassword.php?email='.$email.'&hash='.$hash.'";
		
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