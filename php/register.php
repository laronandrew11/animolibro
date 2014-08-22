<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
define("MAX_LENGTH", 6);

if (isset($_POST['submit'])) {
	$db = database::getInstance();
	session_start();

	$salt = substr(md5(uniqid(rand(), true)), 0, 10);
	$com_code = md5(uniqid(rand()));
	$passwordhash = hash("sha256", $_POST['user_password'].$salt);

	if (isset($_SESSION['imagename'])) {
		$profile_pic_name = $_SESSION['imagename'];
	
		$profile_pic_query = $db->dbh->prepare("SELECT id FROM Image WHERE href = :profpicname");
		$profile_pic_query = bindParam(':profpicname', $profile_pic_name);
		$profile_pic_query->execute();

		if ($profile_pic_query->rowcount() > 0) {
			$profile_pic_row = $profile_pic_query->fetch(PDO::FETCH_ASSOC);
			$profile_pic_id = $profile_pic_row['id'];

			$user_insert_query = $db->dbh->prepare("INSERT INTO UserAccount (
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
			$user_insert_query->bindParam(':name', $_POST['user_name']);
			$user_insert_query->bindParam(':email', $_POST['user_email']);
			$user_insert_query->bindParam(':contact', $_POST['user_contactno']);
			$user_insert_query->bindParam(':course', $_POST['course']);
			$user_insert_query->bindParam(':passwordhash', $passwordhash);
			$user_insert_query->bindParam(':salt', $salt);
			$user_insert_query->bindParam(':profile_id', $profile_pic_id);
			$user_insert_query->bindParam(':com_code', $com_code);
		}
	}
	else{
		$user_insert_query = $db->dbh->prepare("INSERT INTO UserAccount (
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
		$user_insert_query->bindParam(':name', $_POST['user_name']);
		$user_insert_query->bindParam(':email', $_POST['user_email']);
		$user_insert_query->bindParam(':contact', $_POST['user_contactno']);
		$user_insert_query->bindParam(':course', $_POST['course']);
		$user_insert_query->bindParam(':passwordhash', $passwordhash);
		$user_insert_query->bindParam(':salt', $salt);
		$user_insert_query->bindParam(':com_code', $com_code);

	}
	
	try {
		if (($user_insert_query->execute())) {
			$user_query = $db->dbh->prepare("SELECT id FROM UserAccount WHERE username = :username");
			$user_query->bindParam(':username', $_POST['user_name']);
		
			if ($user_query->execute()) {
				$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
				$user_id = $user_row['id'];
				$user_email = $_POST['user_email'];
				
				$subject = "AnimoLibro Registration Confirmation";
				$header = "AnimoLibro: Confirmation from AnimoLibro";
				$message = "Please click the link to verify and activate your account: \n";
				$message = "http://localhost/animolibro/activationpage.php?passkey=$com_code";

				$sentmail = mail($user_email, $subject, $message);
				
				if ($sentmail) {
					$_SESSION['confirmationsent'] = true;
					//echo "Your Confirmation link Has Been Sent To Your E-mail Address.";
				}
				else {
					$_SESSION['confirmationsent'] = false;
					//echo "Cannot send Confirmation link to your E-mail Address";
				}
				$_SESSION['activation_code'] = $com_code;
			}
		}
		header("Location: ../portal.php");
		exit;
	}
	catch (Exception $e) {
		$_SESSION['bad_message'] = 'Sorry! That username or email is already in use. Please try again.';
	}
	header("Location: ../registerpage.php");
	exit;
} 	
else {
	echo "Not submitted!";
}

?> 