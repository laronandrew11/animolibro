<?php

if(isset($_POST['isbn'])) {
include('dbConnect.php');
	
	$isbn = $_POST['isbn'];
	$isbn_query = mysql_query("Select * from Book  WHERE isbn LIKE '%$isbn%'");
	$array=[];							
	while($row2 = mysql_fetch_assoc($isbn_query)) {
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