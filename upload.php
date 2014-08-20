<?php
include_once('php/animolibroerrorhandler.php');
require_once('php/db_config.php');
include('php/SimpleImage.php');

session_start(); 
$type = $_SESSION['upload_type'];

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','svg');
//file upload size limit
$limit_size = 5000;

if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
	echo 'hello';
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	$db = database::getInstance();
	
	if (!in_array(strtolower($extension), $allowed) || S_FILES['upl']['size']>$limit_size) {
		echo '{"status":"error"}';
		exit;
	}
	
	$name = rand(1,99999).".".end(explode(".",$_FILES["upl"]["name"]));
	
	$image = new SimpleImage();
	$image->load($_FILES['upl']['tmp_name']);
	$image->thumbnail(195,250);
	$image->save('uploads/'.$name);
		
	//if (move_uploaded_file($name, 'uploads/'.$name)) {
	$image_query = $db->dbh->prepare("INSERT INTO Image (type, href) VALUES (:type, :name)");
	$image_query->bindParam(':type', $type);
	$image_query->bindParam(':name', $name);

	// INSERT IMAGE LOCATION INTO DATABASE
	if ($image_query->execute()) {

		$_SESSION["imagename"] = $name;
		echo '{"status":"success"}';
	}
	exit;
	//}
}

echo '{"status":"error"}';
/* Log error uploading image TODO */
exit;