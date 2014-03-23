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
     
    //Lets search the databse for the user name and password 
    //Choose some sort of password encryption, I choose sha256 
    //Password function (Not In all versions of MySQL). 
    $email = mysql_real_escape_string($_POST['Email']); 
    $pas = mysql_real_escape_string($_POST['Password']); 
    $test = "SELECT * FROM UserAccount  
        WHERE email='$email' AND 
        passwordhash='$pas' 
        LIMIT 1";
	$sql = mysql_query("SELECT * FROM UserAccount  
        WHERE email='$email' AND 
        passwordhash='$pas' 
        LIMIT 1"); /*AND
		com_code IS NULL*/
		session_start(); 
    if(mysql_num_rows($sql) == 1){ 
        $row = mysql_fetch_array($sql); 
		$_SESSION['correctlogin']=true;
		if($row['Com_code']==null)
		{
        
        $_SESSION['animolibrousername'] = $row['username'];
		$_SESSION['animolibroid'] = $row['id'];
		//$_SESSION["external_profile"]=false;
		$_SESSION['logged'] = true;
        //header("Location: http://localhost/animolibro/php/users_page.php"); 
		$_SESSION['accountactivated']=true;

		header("Location: http://localhost/animolibro/home.php");

        exit; 
		}
		else{
		$_SESSION['accountactivated']=false;
			header("Location: http://localhost/animolibro/login_page.php"); 
			
		}
		
    }else{ 
	$_SESSION['accountactivated']=false;
	$_SESSION['correctlogin']=false;
	
        header("Location: http://localhost/animolibro/login_page.php"); 
        exit; 
    } 
}else{    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: index.php");     
    exit; 
} 
?>