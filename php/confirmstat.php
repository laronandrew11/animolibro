<?php 
if(isset($_POST['submit1'])&&$_POST['myprofile']==true){ 
   include('dbConnect.php');
     
    $adid = mysql_real_escape_string($_POST['adid']);  //change to number instead of string?
	$status = mysql_real_escape_string($_POST['submit1']);
	session_start(); 
	$buyerid =  $_SESSION['animolibroid']; //not sure if this is right
	if($status == "Accept")
	{
		$update_ad ="UPDATE Ad SET status = 2 WHERE id = $adid"; 
	}
	else
	{
		$update_ad ="UPDATE Ad SET status = 3 WHERE id = $adid";
	}
	
	if(mysql_query($update_ad)){
		header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION['animolibrousername']);
	}
	else echo "ERROR";
        //session_start(); 
        //$_SESSION['username'] = $row['username'];
        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 
    exit; 

}else{    //If the form button wasn't submitted go to the index page, or login page 
	header("Location: http://localhost/animolibro/home.php");     
    exit; 
}
?>