<?php
include_once('animolibroerrorhandler.php');

if(isset($_POST['query'])) {
include('dbConnect.php');
	
	$query = $_POST['query'];
	$mysql_query = mysql_query("Select * from Book  WHERE title LIKE '%$query%'
								OR isbn LIKE '%$query%' OR authors LIKE '%$query%' 
								OR subjects LIKE'%$query%' OR category LIKE '%$query%' 
								OR publisher LIKE '%$query%'");
	$array=[];							
	while($row = mysql_fetch_assoc($mysql_query)) {
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