<?php


  $dbHost = "localhost";        //Location Of Database usually its localhost 
    $dbUser = "root";            //Database User Name 
    $dbPass = "";            //Database Password 
    $dbDatabase = "animolibrosimple";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the databasse 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
    //Selects the database 
     
    /* 
    The Above code can be in a different file, then you can place include'filename.php'; instead. 
    */ 
	session_start(); 
	$type=$_SESSION['upload_type'];
// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
	
	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	
	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.$_FILES['upl']['name'])){
		$name=$_FILES['upl']['name'];
	$queryString ="INSERT INTO Image (type, href)
        VALUES ($type,'$name')";
		if(mysql_query($queryString)){
		echo '{"status":"success"}';
			}
		exit;
	}
}

echo '{"status":"error"}';
exit;