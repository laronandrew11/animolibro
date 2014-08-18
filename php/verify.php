<?php 
include_once('animolibroerrorhandler.php');


function confirmIPAddress($value) {
	$q = "SELECT attempt, (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL 5 MINUTE)>NOW() then 1 else 0 end) as Denied 
		FROM LoginAttempt
		WHERE ip = '$value'"; 

	$result = mysql_query($q); 
	$data = mysql_fetch_array($result); 

	//Verify that at least one login attempt is in database 

	if (!$data) {
		return 0; 
	} 
	if ($data["attempt"] >= 5) { 
		if($data["Denied"] == 1) { 
			return 1; 
		}
		else { 
			clearLoginAttempts($value); 
			return 0; 
		} 
	}
	return 0; 
} 

function addLoginAttempt($value) {

	//Increase number of attempts. Set last login attempt if required.

	$q = "SELECT * FROM `loginattempts` WHERE ip = '$value'"; 
	$result = mysql_query($q);
	$data = mysql_fetch_array($result);
	
	if($data) {
		$attempt = $data["Attempt"]+1;			

		if($attempt==5) {
		 $q = "UPDATE `loginattempts` SET Attempt=".$attempt.", lastlogin=NOW() WHERE ip = '$value'";
		 $result = mysql_query($q);
		}
		else {
		 $q = "UPDATE `loginattempts` SET Attempt=".$attempt." WHERE ip = '$value'";
		 $result = mysql_query($q);
		}
	}
	else {
		$q = "INSERT INTO `loginattempts` (IP, Attempt) VALUES ('$value', 1)";
		$result = mysql_query($q);
	}
}

function clearLoginAttempts($value) {
	$q = "UPDATE `loginattempts` SET Attempt = 0 WHERE ip = '$value'"; 
	return mysql_query($q);
}

// PAGE IS ACCESSED VIA POST
if(isset($_POST['submit'])) { 
	include('dbConnect.php');

	//check if it's a spam IP
	$ip = $_SERVER["REMOTE_ADDR"];
	$isBlocked = confirmIPAddress($ip);
	
	// IF BLOCKED IP, BLOCK
	if($isBlocked == 1) {
		session_start();
		$_SESSION['bad_login_message'] = "Incorrect username or password; your IP address has been blocked, please try again after 5 minutes";
		header("Location: ../login_page.php");
		exit;
	}

	// IP IS NOT BLOCKED, ALLOW TO CHECK FOR LOGIN
	else {
		//Lets search the databse for the user name and password 
		//Choose some sort of password encryption, I choose sha256 
		//Password function (Not In all versions of MySQL). 
		session_start();
		$email = mysql_real_escape_string($_POST['user_email']); 
		$pas = mysql_real_escape_string($_POST['user_password']); 
		$pas_hash = hash("sha256", $pas);
		$test = "SELECT * FROM UserAccount	
				WHERE email='$email' AND 
				concat(passwordhash,salt) = concat('$pas_hash', salt)
				LIMIT 1";

		$sql = mysql_query($test);

		// IF EMAIL AND PASSWORD ARE CORRECT
		if(mysql_num_rows($sql) == 1) { 
		 	
		 	$row = mysql_fetch_array($sql);
			clearLoginAttempts($value);

			// IF EMAIL IS VALIDATED
			if($row['Com_code']==null) {
				$_SESSION['animolibrousername'] = $row['username'];
				$_SESSION['animolibroid'] = $row['id'];
				$_SESSION['logged'] = true;

				/* Log newly added book into action database */
				$user_id = $_SESSION['animolibroid'];
				$log_logged_in = "INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES ('$user_id', 28)";

				if (mysql_query($log_logged_in)) {
					/* Main log successful */
				}
				/* End of logging */
					
				//$_SESSION["external_profile"]=false;
				//header("Location: http://localhost/animolibro/php/users_page.php"); 
				//header("Location: ../home.php");
					exit; 
			}
			// IF ACCOUNT IS NOT VALIDATED
			else {
				$_SESSION['bad_login_message'] = "Please activate your account via e-mail";
				header("Location: ../login_page.php"); 
				exit;
			}
		 }
		// IF EMAIL OR PASSWORD IS INCORRECT
		else {
			$_SESSION['bad_login_message'] = "Incorrect username or password";
		 	addLoginAttempt($ip);
			header("Location: ../login_page.php"); 
			exit;
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