<?php 
	 
if(isset($_POST['submit'])){ 
   include('dbConnect.php');
	$name = mysql_real_escape_string($_POST['user_name']);
	$email = mysql_real_escape_string($_POST['user_email']);
	$contact = mysql_real_escape_string($_POST['user_contactno']);
	$course = mysql_real_escape_string($_POST['course']);
	$password = mysql_real_escape_string($_POST['user_password']);
	$com_code = md5(uniqid(rand()));
	$passwordhash=md5($password);
	//$re_password = mysql_real_escape_string($_POST['confirm_password']);
	if(!empty($_SESSION['imagename'])){
		$profilepic_name = $_SESSION['imagename'];
	
	$get_profilepic = "SELECT id FROM Image WHERE href = '$profilepic_name'";
	$profile_query=mysql_query($get_profilepic);
	if(mysql_num_rows($profile_query) == 1){
				$profile_row= mysql_fetch_array($profile_query); 
				$profile_id= mysql_real_escape_string((int)$profile_row['id']);
				 $query = "INSERT INTO UserAccount(username,email,contactnumber,Course_id,passwordhash,profile_pic_id,com_code) 
            VALUES('$name','$email',$contact,$course,'$passwordhash', $profile_id, '$com_code')";
				}
	}
	else{
		$query = "INSERT INTO UserAccount(username,email,contactnumber,Course_id,passwordhash,com_code) 
            VALUES('$name','$email',$contact,$course,'$passwordhash','$com_code')";
	}
				 
    if(mysql_query($query))
	{

			
        //$_SESSION['animolibrousername'] = $name;
		//$_SESSION["external_profile"]=false;
		$id_query = "SELECT id FROM UserAccount WHERE username= '$name'";
		$row = mysql_fetch_array(mysql_query($id_query));
		$id= $row['id'];
		//$_SESSION['animolibroid'] = $row['id'];
		//$_SESSION['logged'] = true;
		$to = $email;
		
		$subject = "AnimoLibro Registration Confirmation";
		$header = "AnimoLibro: Confirmation from AnimoLibro";
		$message = "Please click the link to verify and activate your account: \n";
		$message .= "http://localhost/animolibro/activationpage.php?passkey=$com_code";

		$sentmail = mail($to,$subject,$message);
		
		if($sentmail)
        {
			$_SESSION['confirmationsent']=true;
			//echo "Your Confirmation link Has Been Sent To Your E-mail Address.";
		}
		else
        {
			$_SESSION['confirmationsent']=false;
			//echo "Cannot send Confirmation link to your E-mail Address";
		}
		header("Location: http://localhost/animolibro/portal.php");
	}else{ echo "Registration failed";}
    exit; 
} 	
else {echo "Not submitted!";}

?> 