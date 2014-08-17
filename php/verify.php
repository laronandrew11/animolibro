<?php 


function confirmIPAddress($value) { 

  $q = "SELECT attempt, 
  (CASE when lastlogin is not NULL and DATE_ADD(LastLogin, INTERVAL 5 MINUTE)>NOW() then 1 else 0 end) as Denied 
  FROM LoginAttempt
  WHERE ip = '$value'"; 

  $result = mysql_query($q); 
  $data = mysql_fetch_array($result); 

  //Verify that at least one login attempt is in database 

  if (!$data) { 
    return 0; 
  } 
  if ($data["attempt"] >= 5) 
  { 
    if($data["Denied"] == 1) 
    { 
      return 1; 
    } 
    else 
    { 
      clearLoginAttempts($value); 
      return 0; 
    } 
  } 
  return 0; 
} 

function addLoginAttempt($value) {

   //Increase number of attempts. Set last login attempt if required.

   $q = "SELECT * FROM LoginAttempt WHERE ip = '$value'"; 
   $result = mysql_query($q);
   $data = mysql_fetch_array($result);
   
   if($data)
   {
     $attempt = $data["Attempt"]+1;         

     if($attempt==5) {
       $q = "UPDATE LoginAttempt SET Attempt=".$attempt.", lastlogin=NOW() WHERE ip = '$value'";
       $result = mysql_query($q);
     }
     else {
       $q = "UPDATE LoginAttempt SET Attempt=".$attempt." WHERE ip = '$value'";
       $result = mysql_query($q);
     }
   }
   else {
     $q = "INSERT INTO LoginAttempt (Attempt,IP,lastlogin) values (1, '$value', NOW())";
     $result = mysql_query($q);
   }
}

function clearLoginAttempts($value) {
  $q = "UPDATE LoginAttempt SET Attempt = 0 WHERE ip = '$value'"; 
  return mysql_query($q);
}

function InvalidMessage($message){
	echo "<script type='text/javascript'>
		window.alert('$message');
		window.location.href='http://localhost/animolibro/login_page.php'</script>";
    exit; 
}


if(isset($_POST['submit'])){ 
   	include('dbConnect.php');

   	//check if it's a spam IP
	$ip = $_SERVER["REMOTE_ADDR"];

	$isBlocked = confirmIPAddress($ip);

	//if failed
	if($isBlocked == 1){
		InvalidMessage("The IP has been blocked. Please try after 5 minutes.");
		//addLoginAttempt($ip);

		$_SESSION['accountactivated']=false;
		$_SESSION['correctlogin']=false;
	}

	else
	{

	    //Lets search the databse for the user name and password 
	    //Choose some sort of password encryption, I choose sha256 
	    //Password function (Not In all versions of MySQL). 
	    $email = mysql_real_escape_string($_POST['user_email']); 
	    $pas = mysql_real_escape_string($_POST['user_password']); 
		$pas_hash = hash("sha256", $pas);
	    $test = "SELECT * FROM UserAccount  
	        WHERE email='$email' AND 
	        concat(passwordhash,salt) = concat('$pas_hash', salt)
	        LIMIT 1";

		$sql = mysql_query($test); /*AND
			com_code IS NULL*/
		session_start(); 

		//if user & pass correct 
	    if(mysql_num_rows($sql) == 1)
	    { 
	        $row = mysql_fetch_array($sql); 
			$_SESSION['correctlogin']=true;
			clearLoginAttempts($value); 
			//if account is validated
			if($row['Com_code']==null)
			{
		        $_SESSION['animolibrousername'] = $row['username'];
				$_SESSION['animolibroid'] = $row['id'];
				//$_SESSION["external_profile"]=false;
				$_SESSION['logged'] = true;
		        //header("Location: http://localhost/animolibro/php/users_page.php"); 
				$_SESSION['accountactivated']=true;

				header("Location: http://localhost/animolibro/home.php");

				/* Log newly added book into action database */
				$user_id = $_SESSION['animolibroid'];
				$log_logged_in = "INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES ('$user_id', 28)";

				if (mysql_query($log_logged_in)) {
					/* Main log successful */
				}
				else {
					/* Main log error TODO */
				}
				/* End of logging */

		        exit; 
			}
			//if account is not validated
			else
			{
				$_SESSION['accountactivated']=false;
				header("Location: http://localhost/animolibro/login_page.php"); 
				
			}
			
	    }
	    else{ 
	    	addLoginAttempt($ip);
			InvalidMessage("Invalid EMAIL or PASSWORD!");
			$_SESSION['accountactivated']=false;
			$_SESSION['correctlogin']=false;
	    } 
	}
}

//If the form button wasn't submitted go to the index page, or login page 
else
{    
    header("Location: index.php");     
    exit; 
} 

?>