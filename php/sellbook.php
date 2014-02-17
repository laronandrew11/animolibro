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
     
    $isbn = mysql_real_escape_string($_POST['book_isbn']);  //change to number instead of string?
    $title = mysql_real_escape_string($_POST['book_title']); 
	$authors = mysql_real_escape_string($_POST['book_authors']);
	$publisher = mysql_real_escape_string($_POST['book_publisher']);
	$category = mysql_real_escape_string($_POST['category']); //implement w/ Category table later
	$subjects = mysql_real_escape_string($_POST['book_subject']); //implement properly later
	$condition = mysql_real_escape_string($_POST['conditionRadios']);
	$description = mysql_real_escape_string($_POST['book_description']);
	$price =mysql_real_escape_string($_POST['book_price']);
	if(isset($_POST['negotiable'])) {
	$negotiable = mysql_real_escape_string(true);
	}
	else {$negotiable=mysql_real_escape_string(0);}
	$meetup = mysql_real_escape_string($_POST['meetup_place']);
	$password = mysql_real_escape_string($_POST['user_password']); //hashing to be added in future
	
	session_start(); 
	$seller =  $_SESSION['username']; //not sure if this is right
	
	$add_book ="INSERT INTO Book (title, authors, publisher, isbn, category, subjects)
        VALUES ('$title','$authors','$publisher',$isbn,'$category','$subjects')"; //later on, add a way to save and reference categories and subjects
	
	$seller_row=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller' AND 
        passwordhash='$password'  LIMIT 1"));
				$sellerid=mysql_real_escape_string((int)$seller_row['id']);
		if($sellerid!=0)
		{
		if(mysql_query($add_book)){
			$get_book_id=mysql_query("SELECT * FROM Book WHERE title='$title'");
			if(mysql_num_rows($get_book_id) == 1){
				$row= mysql_fetch_array($get_book_id); 
				$bookid= mysql_real_escape_string((int)$row['id']);
				
				/*echo $bookid;
				echo $price;
				echo $negotiable;
				echo $condition;*/
					$add_ad = "INSERT INTO Ad (cost, meetup, copy_condition, negotiable,  status, description, seller_id, book_id) 
        VALUES ($price,'$meetup','$condition',$negotiable,0,'$description',$sellerid,$bookid)"; //insert seller id 0 until we get sessions figured out
			echo $add_ad;
				if(mysql_query($add_ad)){
					echo "SUCCESS";
				}else {echo "failed to add ad";}
			}
			else{echo "failed to query book id";}
		}
		else {echo "failed to add book";}
		}
		else echo "Invalid user or password";
		
					
			
		//TODO: add password validation

		

        //session_start(); 
        //$_SESSION['username'] = $row['username'];
        //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 

        exit; 

}else{    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: index.php");     
    exit; 
} 
?>