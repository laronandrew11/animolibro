<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
require_once('check_password.php');

if (isset($_POST['confirmation']) && $_POST['myprofile'] == true) {
	session_start();
	$db = database::getInstance();

	$ad_id = $_POST['ad_id'];
	$status = $_POST['confirmation'];
	$password = $_POST['password'];
	
	if (!is_password_correct($password)) {
		$_SESSION['bad_message'] = "Sorry, we failed to " . strtolower($status) . " the ad. Please try again?";
		header("Location: ../userprofile.php");
		exit;
	}
	
	$buyerid = $_SESSION['animolibroid']; //not sure if this is right
	
	if ($status == "Accept") {
		$status_id = 2;
	}
	else if ($status == "Reject") {
		$status_id = 3;
	}
	
	$stmt = $db->dbh->prepare("UPDATE Ad SET status = :status WHERE id = :ad_id");
	$stmt->bindParam(':ad_id', $ad_id);
	$stmt->bindParam(':status', $status_id);

	if ($stmt->execute()) {
		header("Location: ../userprofile.php");
		exit;
	}
	else {
		header("Location: ../errorpage.php");
	}
	exit;
}

else{
	//If the form button wasn't submitted go to the index page, or login page 
	header("Location: ../home.php");	 
	exit;
}
?>