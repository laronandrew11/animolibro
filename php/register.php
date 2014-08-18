<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
define("MAX_LENGTH", 6);
 
function generateHashWithSalt($password) {
    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, MAX_LENGTH);
    return hash("sha256", $password . $salt);
}

if(isset($_POST['submit'])){ 
   include('dbConnect.php');
   $db = database::getInstance(); 

	$name = mysql_real_escape_string($_POST['user_name']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$contact = mysql_real_escape_string($_POST['user_contactno']);
	$course = mysql_real_escape_string($_POST['course']);
	$password = mysql_real_escape_string($_POST['user_password']);
	$salt = substr(md5(uniqid(rand(), true)), 0, 10);
	$com_code = md5(uniqid(rand()));

	$passwordhash = hash("sha256", $password);
	//$re_password = mysql_real_escape_string($_POST['confirm_password']);
	if(!empty($_SESSION['imagename'])){
		$profilepic_name = $_SESSION['imagename'];
	
	//$get_profilepic = "SELECT id FROM Image WHERE href = '$profilepic_name'";

	$get_profilepic=$db->dbh->prepare("SELECT id FROM Image WHERE href = :profpicname");
	$get_profilepic->execute(array(':profpicname' => $profilepic_name));

	$profile_query=$get_profilepic->fetchAll();
	if(count($profile_query) == 1){
				$profile_row= mysql_fetch_array($profile_query); 
				$profile_id= mysql_real_escape_string((int)$profile_row['id']);

		$stmt = $db->dbh->prepare("INSERT INTO UserAccount (
								 	username,
								 	email,
								 	contactnumber,
								 	Course_id,
								 	passwordhash,
								 	salt,
								 	profile_pic_id,
								 	com_code) 
								VALUES (
					            	:name, 
					            	:email, 
					            	:contact, 
					            	:course, 
					            	:passwordhash,
					            	:salt,
					            	:profile_id, 
					            	:com_code)");
	    $stmt->bindParam(':name', $_POST['user_name']);
	    $stmt->bindParam(':email', $_POST['user_email']);
	    $stmt->bindParam(':contact', $_POST['user_contactno']);
	    $stmt->bindParam(':course', $_POST['course']);
	    $stmt->bindParam(':passwordhash', $passwordhash);
	    $stmt->bindParam(':salt', $salt);
	    $stmt->bindParam(':profile_id', $profile_id);
	    $stmt->bindParam(':com_code', $com_code);
	}
	}
	else{
		$stmt = $db->dbh->prepare("INSERT INTO UserAccount (
								 	username,
								 	email,
								 	contactnumber,
								 	Course_id,
								 	passwordhash,
								 	salt,
								 	com_code) 
								VALUES (
					            	:name, 
					            	:email, 
					            	:contact, 
					            	:course, 
					            	:passwordhash,
					            	:salt,
					            	:com_code)");
	    $stmt->bindParam(':name', $_POST['user_name']);
	    $stmt->bindParam(':email', $_POST['user_email']);
	    $stmt->bindParam(':contact', $_POST['user_contactno']);
	    $stmt->bindParam(':course', $_POST['course']);
	    $stmt->bindParam(':passwordhash', $passwordhash);
	    $stmt->bindParam(':salt', $salt);
	    $stmt->bindParam(':com_code', $com_code);

	}
				 
    if(($stmt->execute()))
	{
        //$_SESSION['animolibrousername'] = $name;
		//$_SESSION["external_profile"]=false;
		//$id_query = "SELECT id FROM UserAccount WHERE username= '$name'";

		$stmt = $db->dbh->prepare("SELECT id FROM UserAccount WHERE username=:username");
		$stmt->execute(array(':username' => $_POST['user_name']));
		$row = $stmt->fetchAll();
		$id= $row['id'];
		//$_SESSION['animolibroid'] = $row['id'];
		//$_SESSION['logged'] = true;
		$to = $email;
		
		$subject = "AnimoLibro Registration Confirmation";
		$header = "AnimoLibro: Confirmation from AnimoLibro";
		$message = "Please click the link to verify and activate your account: \n";
		$message .= "http://localhost/animolibro/activationpage.php?passkey=$com_code";

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
		}
		header("Location: http://localhost/animolibro/portal.php");
	}else{ echo "Registration failed";}
    exit; 
} 	
else {echo "Not submitted!";}

?> 