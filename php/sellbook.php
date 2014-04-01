<?php 
if(isset($_POST['submit'])){ 
   include('php/dbConnect.php');
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
	//$password = mysql_real_escape_string($_POST['user_password']); //hashing to be added in future
	
	session_start(); 
	$seller =  $_SESSION['animolibrousername']; //not sure if this is right
	
	/*Check if book has already been added to DB*/
	$check_book="SELECT title FROM Book WHERE isbn= $isbn";
	$check_query=mysql_query($check_book);

		
		if(!empty($check_query)&&mysql_num_rows($check_query) == 1){
		//$row= mysql_fetch_array($check_query); 
				//$title= mysql_real_escape_string((int)$row['title']);
		$add_book="Book already added";
		echo $add_book;
		}
		

	else{
	/*get cover picture*/
	if(!empty($_SESSION['imagename'])){
	$coverpic_name = $_SESSION['imagename'];
	
	$get_coverpic = "SELECT id FROM Image WHERE href = '$coverpic_name'";
	$cover_query=mysql_query($get_coverpic);
	if(mysql_num_rows($cover_query) == 1){
				$cover_row= mysql_fetch_array($cover_query); 
				$cover_id= mysql_real_escape_string((int)$cover_row['id']);
	
	/*add book to DB if necessary*/
	$add_book ="INSERT INTO Book (title, authors, publisher, isbn, category, subjects,cover_pic_id)
        VALUES ('$title','$authors','$publisher',$isbn,'$category','$subjects',$cover_id)"; //later on, add a way to save and reference categories and subjects
	}
	}
	else $add_book ="INSERT INTO Book (title, authors, publisher, isbn, category, subjects)
        VALUES ('$title','$authors','$publisher',$isbn,'$category','$subjects')"; 
	}
	$seller_row=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller'  LIMIT 1"));
				$sellerid=mysql_real_escape_string((int)$seller_row['id']);
		if($sellerid!=0)
		{
		if($add_book=="Book already added"||mysql_query($add_book)){
			
			$get_book_id=mysql_query("SELECT id FROM Book WHERE isbn='$isbn'");
			if(mysql_num_rows($get_book_id) == 1){
				$row= mysql_fetch_array($get_book_id); 
				$bookid= mysql_real_escape_string((int)$row['id']);
				
				/*echo $bookid;
				echo $price;
				echo $negotiable;
				echo $condition;*/
				
				/*Add advertisement to DB*/
					$add_ad = "INSERT INTO Ad (cost, meetup, copy_condition, negotiable,  status, description, seller_id, book_id) 
        VALUES ($price,'$meetup','$condition',$negotiable,0,'$description',$sellerid,$bookid)"; 
			echo $add_ad;
				if(mysql_query($add_ad)){

					header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION["animolibrousername"]); 
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