<?php
$db = database::getInstance();
$course_query = $db->dbh->prepare("SELECT * FROM course");

if($course_query->execute()) { 
	while($course_row = $course_query->fetch(PDO::FETCH_ASSOC)) {
		$course_id = $course_row['id'];
		$course_code = $course_row['code'];
		echo '<option value='.$course_id.'>'.$course_code.'</option>';
	}
}
?>