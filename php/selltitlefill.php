<?php
include_once('animolibroerrorhandler.php');

if(isset($_POST['title']))
{
	
	include('dbConnect.php');
	
	$title = $_POST['title'];
	$title_query = mysql_query("Select * from Book ");
	$array=[];							
	while($row = mysql_fetch_assoc($title_query)) {
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