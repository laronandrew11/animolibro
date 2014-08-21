<?php
include_once('animolibroerrorhandler.php');
require_once("db_config.php");

if(isset($_POST['submit'])){
	$db = database::getInstance(); 
	
	$search = $_POST['Search']; 
	
	$stmt = $db->dbh->prepare("SELECT * FROM Book WHERE title like ? OR authors like ? OR isbn = ?");
	$stmt->execute(array("%$search%", "%$search%", "%$search%"))

	if(count($stmt->fetchAll()) > 0) {
		$results = array(); // the result array
         $i = 1;
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = "{$i}: {$row['title']}<br />{$row['authors']}<br />{$row['isbn']}<br /><br />";
            $i++;
		}
	}
	else echo 'NO SEARCH FOUND';
}
?>