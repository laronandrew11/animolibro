<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if (isset($_POST['submit'])) {
	$db = database::getInstance(); 

	$email = $_POST['email'];
	$hash = $_POST['hash'];
	$newpass = $_POST['newpass'];
	$newpassagain = $_POST['newpassagain'];

	$password_query = $db->dbh->prepare("SELECT passwordhash, salt FROM UserAccount WHERE email = :email");
	$password_query->bindParam(':email', $email);
	if ($password_query->execute()) {
		$password_row = $password_query->fetch(PDO::FETCH_ASSOC);
		$stored_password_hash = $password_row['passwordhash'];
		$stored_salt = $password_row['salt'];

		if ($hash == $stored_password_hash) {
			if ($newpass == $newpassagain) {
				$newpass_hash = hash("sha256", $newpass.$stored_salt);
					
				$password_update_query = $db->dbh->prepare("UPDATE UserAccount SET passwordhash = :passwordhash WHERE username = :username");
				$password_update_query->bindParam(':passwordhash', $newpass_hash);
				$password_update_query->bindParam(':username', $username);
					
				if($password_update_query->execute()) {
					$_SESSION['pwchange'] = true;
					header("Location: ../home.php");
					exit;
				}
				else {
					$_SESSION['pw_db_failed'] = true;
				}
			}
			else {
				$_SESSION['pw_not_equal'] = true;
			}
		}
		else {
			$_SESSION['pw_wrong'] = true;
		}
	}
	else {
		$_SESSION['pw_db_failed'] = true;
	}
	$_SESSION['pwchange'] = false;
	header("Location: ../resetpassword.php?email=".$email."&hash=".$hash);
	exit;
}	
else {echo "Not submitted!";}
?>