<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['isbn'])) {
	$db = database::getInstance(); 

	$isbn = $_POST['isbn'];
	$stmt = $db->dbh->prepare("SELECT * FROM Book WHERE isbn LIKE ?");
	$stmt->execute(array("%$isbn%"))

	$array=[];							
	while($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
	//if(in_array($row['authors'],$array)==false&&in_array($row['subjects'],$array)==false&&in_array($row['category'],$array)==false&&in_array($row['publisher'],$array)==false)
	//{
		//$array[] = $row['title'];
		$array2[] = $row2['isbn'];
		//$array[] = $row['authors'];
		//$array[] = $row['subjects'];
		//$array[] = $row['category'];
		//$array[] = $row['publisher'];
		//}
	}
	
	echo json_encode($array2);
}



?>