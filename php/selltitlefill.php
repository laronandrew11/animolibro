<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['title']))
{
	
	include('dbConnect.php');
	$db = database::getInstance(); 
	$title = $_POST['title'];
	$title_query = mysql_query("Select * from Book ");
	$title_query =  $db->dbh->prepare("Select * from Book");
	$title_query->execute();

	$array=[];							
	while($row = $title_query->fetch(PDO::FETCH_ASSOC)) {
	//if(in_array($row['authors'],$array)==false&&in_array($row['subjects'],$array)==false&&in_array($row['category'],$array)==false&&in_array($row['publisher'],$array)==false)
	//{
		$array[] = $row['title'];
		//$array[] = $row['isbn'];
		//$array[] = $row['authors'];
		//$array[] = $row['subjects'];
		//$array[] = $row['category'];
		//$array[] = $row['publisher'];
		//}
	}
	
	echo json_encode($array);
}


?>