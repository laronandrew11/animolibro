<?php
	 include('php/SimpleImage.php');

 include('php/dbConnect.php');
	session_start(); 
	$type=$_SESSION['upload_type'];
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','svg');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
	
	$name = rand(1,99999).".".end(explode(".",$_FILES["upl"]["name"]));
	
	$image = new SimpleImage();
	$image->load($_FILES['upl']['tmp_name']);
	$image->thumbnail(195,250);
	$image->save('uploads/'.$name);
		
	//if(move_uploaded_file($name, 'uploads/'.$name)){
	$queryString ="INSERT INTO Image (type, href)
        VALUES ($type,'$name')";
		if(mysql_query($queryString)){
		$_SESSION["imagename"]=$name;
		echo '{"status":"success"}';
			}
		
		exit;
	//}
}

echo '{"status":"error"}';
exit;