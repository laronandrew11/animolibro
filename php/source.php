<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['query'])) {
	$db = database::getInstance(); 
	$query = $_POST['query'];
	//$mysql_query = mysql_query("Select * from Book  WHERE title LIKE '%$query%'
	//							OR isbn LIKE '%$query%' OR authors LIKE '%$query%' 
	//							OR subjects LIKE'%$query%' OR category LIKE '%$query%' 
	//							OR publisher LIKE '%$query%'");

	$mysql_query = $db->dbh->prepare("Select * from Book  WHERE title LIKE ?
								OR isbn LIKE ? OR authors LIKE ?
								OR subjects LIKE ? OR category LIKE ? 
								OR publisher LIKE ?");
	$mysql_query->execute(array("%$query%", "%$query%", "%$query%","%$query%", "%$query%", "%$query%"))

	$array=[];							
	while($row = $mysql_query->fetch(PDO::FETCH_ASSOC)) {
	if(in_array($row['authors'],$array)==false&&in_array($row['subjects'],$array)==false&&in_array($row['category'],$array)==false&&in_array($row['publisher'],$array)==false)
	{
		$array[] = $row['title'];
		$array[] = $row['isbn'];
		$array[] = $row['authors'];
		$array[] = $row['subjects'];
		$array[] = $row['category'];
		$array[] = $row['publisher'];
		}
	}
	
	echo json_encode($array);
}

?>