<?php

if(isset($_POST['query'])) {
	$user = "root";
	$pass = "";
	$host = "localhost";
	$db = "animolibrosimple";
	
	$connect = mysql_connect($host, $user, $pass);
	$select = mysql_select_db($db, $connect);
	
	$query = $_POST['query'];
	$mysql_query = mysql_query("Select * from Book  WHERE title LIKE '%$query%'
								OR isbn LIKE '%$query%' OR authors LIKE '%$query%' 
								OR subjects LIKE'%$query%' OR category LIKE '%$query%' 
								OR publisher LIKE '%$query%'");
								
	while($row = mysql_fetch_assoc($mysql_query)) {
		$array[] = $row['title'];
		$array[] = $row['isbn'];
		$array[] = $row['authors'];
		$array[] = $row['subjects'];
		$array[] = $row['category'];
		$array[] = $row['publisher'];
	}
	
	echo json_encode($array);
}

?>