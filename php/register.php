<?php 
//TO DO: find out why in the @)$!)($)(!$)(@$ ads aren't being added
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
     
	$name = mysql_real_escape_string($_POST['user_name']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$contact = mysql_real_escape_string($_POST['user_contactno']);
	$course = mysql_real_escape_string($_POST['course']);
	$password = mysql_real_escape_string($_POST['user_password']);
	//$re_password = mysql_real_escape_string($_POST['confirm_password']);


        $query = "INSERT INTO UserAccount(username,email,contactnumber,Course_id,passwordhash) 
            VALUES('$name','$email',$contact,$course,$password)";
	echo $query;
    if(mysql_query($query))
	{
	 session_start(); 
        $_SESSION['animolibrousername'] = $row['username'];
		$_SESSION['logged'] = true;
        //header("Location: http://localhost/animolibro/php/users_page.php"); 
		header("Location: http://localhost/animolibro/home.php");
	}else{ echo "Registration failed";}
    exit; 
} 	
else {echo "Not submitted!";}

?> 