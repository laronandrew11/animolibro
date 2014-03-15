<?php 
if(isset($_POST['submit'])){ 
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
     
    $adid = mysql_real_escape_string($_POST['adid']);  //change to number instead of string?
	$url = mysql_real_escape_string($_POST['url']);
	
	session_start(); 
	$buyerid =  $_SESSION['animolibroid']; //not sure if this is right
	
	$update_ad ="UPDATE Ad SET status = 1, buyer_id = $buyerid WHERE id = $adid"; //later on, add a way to save and reference categories and subjects
	
	if(mysql_query($update_ad)){
		
		header("Location: http://localhost$url");
	}
	else echo "ERROR";
        //session_start(); 
        //$_SESSION['username'] = $row['username'];
        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
    exit; 

}else{    //If the form button wasn't submitted go to the index page, or login page 
	header("Location: index.php");     
    exit; 
} 
?>