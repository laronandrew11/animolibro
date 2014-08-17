<?php
include_once('animolibroerrorhandler.php');
if(isset($_POST['submit'])){ 
include('dbConnect.php');
	
	$search = mysql_real_escape_string($_POST['Search']); 
	
	$find = "SELECT * FROM Book  
        WHERE title like '%{$search}%' OR 
        authors like '%{$search}%' OR
		isbn = '$search'";
		
	$sql = mysql_query("SELECT * FROM Book  
        WHERE title like '%{$search}%' OR 
        authors like '%{$search}%' OR
		isbn = '$search'");
	if(mysql_num_rows($sql) > 0) {
		$results = array(); // the result array
         $i = 1;
         while ($row = mysql_fetch_assoc($sql)) {
            $results[] = "{$i}: {$row['title']}<br />{$row['authors']}<br />{$row['isbn']}<br /><br />";
            $i++;
		}
	}
	else echo 'NO SEARCH FOUND';
}
?>