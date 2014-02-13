<?php 
if(isset($_POST['submit'])){ 
    $dbHost = "localhost";        //Location Of Database usually its localhost 
    $dbUser = "root";            //Database User Name 
    $dbPass = "";            //Database Password 
    $dbDatabase = "animolibro";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the databasse 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
    //Selects the database 
     
    /* 
    The Above code can be in a different file, then you can place include'filename.php'; instead. 
    */ 
     
    //Lets search the databse for the user name and password 
    //Choose some sort of password encryption, I choose sha256 
    //Password function (Not In all versions of MySQL). 
    $isbn = mysql_real_escape_string($_POST['book_isbn']);  //change to number instead of string?
    $title = mysql_real_escape_string($_POST['book_title']); 
	$authors = mysql_real_escape_string($_POST['book_authors']);
	$publisher = mysql_real_escape_string($_POST['book_publisher']);
	$category = mysql_real_escape_string($_POST['category']);
	$subjects = mysql_real_escape_string($_POST['book_subject']); //implement later
	$condition = mysql_real_escape_string($_POST['conditionRadios']);
	$description = mysql_real_escape_string($_POST['book_description']);
	$price = mysql_real_escape_string($_POST['book_price']);
	$price = mysql_real_escape_string($_POST['negotiable']);//change to boolean
	$meetup = mysql_real_escape_string($_POST['meetup_place']);
	$password = mysql_real_escape_string($_POST['user_password']);
	$seller =  $_SESSION['username']; //not sure if this is right
	
	
	$sql = mysql_query("INSERT INTO Ad (cost, meetup, condition, negotiable,  status, description, seller_id) 
        VALUES ('$price','$meetup','$condition',$negotiable,0,'$description','$seller')"); 
    /*if(mysql_num_rows($sql) == 1){ 
        $row = mysql_fetch_array($sql); 
        session_start(); 
        $_SESSION['username'] = $row['username'];
        header("Location: home.html"); // Modify to go to the page you would like 
        exit; 
    }else{ 
        header("Location: login_page.php"); 
        exit; */
    } 
}else{    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: index.php");     
    exit; 
} 
?>