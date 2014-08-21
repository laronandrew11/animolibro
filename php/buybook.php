<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['submit'])) { 
	$db = database::getInstance(); 

	$adid = $_POST['adid'];
	$server = $_SERVER['SERVER_ADDR'];
	$path = $_POST['url'];

	session_start();
	$buyerid =  $_SESSION['animolibroid']; //not sure if this is right
	
	//$update_ad ="UPDATE Ad SET status = 1, buyer_id = $buyerid WHERE id = $adid"; //later on, add a way to save and reference categories and subjects
	$status = 1;
	$stmt = $db->dbh->prepare("UPDATE Ad SET status = :status, buyer_id = :buyerid WHERE id = :adid");
	$stmt->bindValue(':status', $status, PDO::PARAM_INT);
	$stmt->bindValue(':buyerid', $buyerid, PDO::PARAM_INT);
	$stmt->bindValue(':adid', $adid, PDO::PARAM_INT);

	//if(mysql_query($update_ad)) {
	if($stmt->execute()) {
		header("Location: ../userprofile.php"); 
		exit;
	}
	else 
		header("Location: ../errorpage.php"); 
		//$_SESSION['username'] = $row['username'];
		//header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
	exit; 

}
else{
	//If the form button wasn't submitted go to the index page, or login page 
	header("Location: index.php");	 
	exit; 
} 

?>