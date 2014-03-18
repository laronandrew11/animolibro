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
     session_start(); 
    /* 
    The Above code can be in a different file, then you can place include'filename.php'; instead. 
    */ 
     
	$name = mysql_real_escape_string($_POST['user_name']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$contact = mysql_real_escape_string($_POST['user_contactno']);
	$course = mysql_real_escape_string($_POST['course']);
	$password = mysql_real_escape_string($_POST['user_password']);
	//$re_password = mysql_real_escape_string($_POST['confirm_password']);

		$profilepic_name = $_SESSION['imagename'];
	
	$get_profilepic = "SELECT id FROM Image WHERE href = '$profilepic_name'";
	$profile_query=mysql_query($get_profilepic);
	if(mysql_num_rows($profile_query) == 1){
				$profile_row= mysql_fetch_array($profile_query); 
				$profile_id= mysql_real_escape_string((int)$profile_row['id']);
				}
				
        $query = "INSERT INTO UserAccount(username,email,contactnumber,Course_id,passwordhash,profile_pic_id) 
            VALUES('$name','$email',$contact,$course,$password, $profile_id)";
    if(mysql_query($query))
	{

			
        $_SESSION['animolibrousername'] = $name;
		$id_query = "SELECT id FROM UserAccount WHERE username= '$name'";
		$row = mysql_fetch_array(mysql_query($id_query));
		$id= $row['id'];
		$_SESSION['animolibroid'] = $row['id'];
	
				
		$_SESSION['logged'] = true;

		header("Location: http://localhost/animolibro/home.php");
	}else{ echo "Registration failed";}
    exit; 
} 	
else {echo "Not submitted!";}

?> 