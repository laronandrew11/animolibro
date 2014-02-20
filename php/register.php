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
     
	$name = mysql_real_escape_string($_POST['full_name']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$contact = mysql_real_escape_string($_POST['contact_number']);
	$course = mysql_real_escape_string($_POST['course']);
	$password = mysql_real_escape_string($_POST['password']);
	$re_password = mysql_real_escape_string($_POST['re_password']);
	
	$sql = mysql_query($query); 
    $row = mysql_fetch_array($sql);
	
	if($row||empty($_POST['full_name'])|| empty($_POST['user_email'])||empty($_POST['contact_number'])||empty($_POST['password'])|| empty($_POST['re_password'])||$_POST['password']!=$_POST['re_password']){ 
        // if a field is empty, or the passwords don't match make a message 
		 $error = '<p>'; 
        if(empty($_POST['full_name'])){ 
            $error .= 'Name can\'t be empty<br>'; 
        } 
        if(empty($_POST['user_email'])){ 
            $error .= 'Email can\'t be empty<br>'; 
        } 
        if(empty($_POST['contact_number'])){ 
            $error .= 'Contact Number can\'t be empty<br>'; 
        } 
        if(empty($_POST['password'])){ 
            $error .= 'Password can\'t be empty<br>'; 
        } 
        if(empty($_POST['re_password'])){ 
            $error .= 'Please re-type password<br>'; 
        } 
        if($_POST['password']!=$_POST['re_password']){ 
            $error .= 'Passwords don\'t match<br>'; 
        } 
        $error .= '</p>' 
	 }else{ 
        // If all fields are not empty, and the passwords match, 
        // create a session, and session variables, 
        $query = sprintf("INSERT INTO UserAccount(`username`,`email`,`contactnumber`,`Course_id`,`passwordhash`) 
            VALUES('$name','$email','$contact','$course','$password')";
        $sql = mysql_query($query);  
        exit; 
    } 
} 	

?> 