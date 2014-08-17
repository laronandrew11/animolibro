<?php

include('php/SimpleImage.php');
include('php/dbConnect.php');
session_start(); 
$user = $_SESSION['animolibrousername']; //not sure if this is right
$type = $_SESSION['upload_type'];
$userrow=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$user'  LIMIT 1"));
$userid=mysql_real_escape_string((int)$userrow['id']);

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','svg');

if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	
	if (!in_array(strtolower($extension), $allowed)) {
		echo '{"status":"error"}';
		exit;
	}
	
	$name = rand(1,99999).".".end(explode(".",$_FILES["upl"]["name"]));
	
	$image = new SimpleImage();
	$image->load($_FILES['upl']['tmp_name']);
	$image->thumbnail(195,250);
	$image->save('uploads/'.$name);
		
	//if (move_uploaded_file($name, 'uploads/'.$name)) {
		$queryString ="INSERT INTO Image (type, href) VALUES ($type,'$name')";
		if (mysql_query($queryString)) {
			$_SESSION["imagename"]=$name;
			echo '{"status":"success"}';

			/* Log newly added image into action database */
			$last_imageID = mysql_insert_id();
			$log_insert_image = "INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES ('$userid', 5)";

			if (mysql_query($log_insert_image)) {
				/* Main log successful */
				$last_logID = mysql_insert_id();
				$log_insert_image_log = "INSERT INTO `log_actions_image` (`log_id`, `image_id`) VALUES ('$last_logID', '$last_imageID')";
				
				if (mysql_query($log_insert_image_log)) {
					/* Image log successful */
				}
				else {
					/* Image log error TODO */
				}
			}
			else {
				/* Main log error TODO */
			}
			/* End of logging */
		}
		else {
			/* Log error inserting image location in DB TODO */

		}
			
		exit;
	//}
}

echo '{"status":"error"}';
/* Log error uploading image TODO */
exit;