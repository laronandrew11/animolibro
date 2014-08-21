<?php 
include_once('animolibroerrorhandler.php');
require_once('db_config.php');

function confirmIPAddress($value) {
	$db = database::getInstance();

	$attempt_query = $db->dbh->prepare("SELECT attempt, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL 5 MINUTE)>NOW() then 1 else 0 end) as Denied FROM loginattempts WHERE ip = :value");
	$attempt_query->bindParam(':value', $value);
	$attempt_query->execute();
	if ($attempt_query->rowcount() == 1) {
		$attempt_row = $attempt_query->fetch(PDO::FETCH_ASSOC);
		if ($attempt_row["attempt"] >= 5) {
			if($attempt_row["Denied"] == 1) {
				return 1; 
			}
			else {
				clearLoginAttempts($value);
			}
		}
	}
	return 0;
} 

function addLoginAttempt($value) {
	$db = database::getInstance();

	//Increase number of attempts. Set last login attempt if required.

	$attempt_query = $db->dbh->prepare("SELECT * FROM `loginattempts` WHERE ip = :value");
	$attempt_query->bindParam(':value', $value);
	$attempt_query->execute();
	
	if ($attempt_query->rowcount() > 0) {
		$attempt_row = $attempt_query->fetch(PDO::FETCH_ASSOC);
		$attempt = $data["Attempt"] + 1;			

		$attempt_update_query = $db->dbh->prepare("UPDATE `loginattempts` SET Attempt = :attempt, lastlogin = NOW() WHERE ip = :value");
		$attempt_update_query->bindParam(':attempt', $attempt);
		$attempt_update_query->bindParam(':value', $value);
		$attempt_update_query->execute();
	}
	else {
		$attempt_update_query = $db->dbh->prepare("INSERT `loginattempts` (IP, Attempt) VALUES (:value, 1)");
		$attempt_update_query->bindParam(':value', $value);
		$attempt_update_query->execute();
	}
}

function clearLoginAttempts($value) {
	$db = database::getInstance();
	$attempt_update_query = $db->dbh->prepare("UPDATE `loginattempts` SET Attempt = 0, lastlogin = NOW() WHERE ip = :value");
	$attempt_update_query->bindParam(':value', $value);
	$attempt_update_query->execute();
}

// PAGE IS ACCESSED VIA POST
if(isset($_POST['submit'])) { 
	$db = database::getInstance();

	//check if it's a spam IP
	$ip = $_SERVER["REMOTE_ADDR"];
	$isBlocked = confirmIPAddress($ip);
	
	// IF BLOCKED IP, BLOCK
	if($isBlocked == 1) {
		session_start();
		$_SESSION['bad_login_message'] = "Incorrect username or password. <b>Your IP address has been blocked, please try again after 5 minutes</b>";
		header("Location: ../login_page.php");
		exit;
	}

	// IP IS NOT BLOCKED, ALLOW TO CHECK FOR LOGIN
	else {
		//Lets search the databse for the user name and password 
		//Choose some sort of password encryption, I choose sha256 
		//Password function (Not In all versions of MySQL). 
		session_start();
		$email = $_POST['user_email'];
		$password = $_POST['user_password'];

		$user_query = $db->dbh->prepare("SELECT * FROM UserAccount WHERE email = :email LIMIT 1");
		$user_query->bindParam(':email', $email);

		if ($user_query->execute()) {
			// IF EMAIL HAS ACCOUNT
			if ($user_query->rowcount() == 1) {
				$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
				$stored_password_hash = $user_row['passwordhash'];
				$stored_salt = $user_row['salt'];
				$password_hash = hash("sha256", $password.$stored_salt);

				// IF PASSWORD FOR EMAIL IS CORRECT
				if ($password_hash == $stored_password_hash) {
					clearLoginAttempts($ip);

					// IF EMAIL IS VALIDATED
					if($user_row['Com_code']==null) {echo 'validated<br />';
						$_SESSION['animolibrousername'] = $user_row['username'];
						$_SESSION['animolibroid'] = $user_row['id'];
						$_SESSION['logged'] = true;

						/* Log login into action database */
						$user_id = $_SESSION['animolibroid'];
						$log_insert_query = $db->dbh->prepare("INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES (:user_id, 28)");
						$log_insert_query->bindParam(':user_id', $user_id);

						if ($log_insert_query->execute()) {
							/* Main log successful */
						}
						/* End of logging */

						header("Location: ../home.php");
						exit;
					}
					// IF ACCOUNT IS NOT VALIDATED
					else {echo 'not validated<br />';
						$_SESSION['bad_login_message'] = "Please activate your account via e-mail";
						header("Location: ../login_page.php"); 
						exit;
					}
				}
				// IF EMAIL OR PASSWORD IS INCORRECT
				else {echo 'returned rows != 1<br />';
					$_SESSION['bad_login_message'] = "Incorrect username or password";
				 	addLoginAttempt($ip);
					header("Location: ../login_page.php"); 
					exit;
				}
			}
		}
	}
}

// PAGE WAS NOT ACCESSED THROUGH A FORM
//If the form button wasn't submitted go to the index page, or login page 
else {	 
	 header("Location: ../home.php");		
	 exit; 
} 

?>