<?php 
if(isset($_POST['submit'])){ 
   include('dbConnect.php');
    //Lets search the databse for the user name and password 
    //Choose some sort of password encryption, I choose sha256 
    //Password function (Not In all versions of MySQL). 
    $email = mysql_real_escape_string($_POST['user_email']); 
    $pas = mysql_real_escape_string($_POST['user_password']); 
	$pas_hash=md5($pas);
    $test = "SELECT * FROM UserAccount  
        WHERE email='$email' AND 
        passwordhash='$pas_hash' 
        LIMIT 1";
		//echo $test;
	$sql = mysql_query($test); /*AND
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
	echo $email.','.$pas;
        //header("Location: http://localhost/animolibro/login_page.php"); 
        exit; 
    } 
}else{    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: index.php");     
    exit; 
} 
?>