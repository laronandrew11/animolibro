<?php 
if(isset($_POST['submit'])){ 
   include('php/dbConnect.php');
     
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