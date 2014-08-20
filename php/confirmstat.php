<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");
if (isset($_POST['submit1']) && $_POST['myprofile'] == true) {
	$db = database::getInstance();
	
	$adid = $_POST['adid'];
	$status = $_POST['submit1'];
	
	session_start();
	$buyerid = $_SESSION['animolibroid']; //not sure if this is right
	
	if ($status == "Accept") {
		$status_id = 2;
	}
	else if ($status == "Reject") {
		$status_id = 3;
	}
	
	$stmt = $db->dbh->prepare("UPDATE Ad SET status = :status WHERE id = :adid");
	$stmt->bindParam(':adid', $adid);
	$stmt->bindParam(':status', $status_id);

	if ($stmt->execute()) {
		header("Location: ../userprofile.php?user=".$_SESSION['animolibrousername']);
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