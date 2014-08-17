<?php 

if(isset($_POST['submit'])){  
    include('dbConnect.php');
    $isbn = mysql_real_escape_string($_POST['book_isbn']);  //change to number instead of string?
    $title = mysql_real_escape_string($_POST['book_title']); 
	$authors = mysql_real_escape_string($_POST['book_authors']);
	$publisher = mysql_real_escape_string($_POST['book_publisher']);
	$category = mysql_real_escape_string($_POST['category']); //implement w/ Category table later
	//$subjects = mysql_real_escape_string($_POST['book_subject']); //implement properly later
	$subjects = $_POST['book_subject'];
	$condition = mysql_real_escape_string($_POST['conditionRadios']);
	$description = mysql_real_escape_string($_POST['book_description']);
	$price =mysql_real_escape_string($_POST['book_price']);
	if(isset($_POST['negotiable'])) {
		$negotiable = mysql_real_escape_string(true);
	}
	else {
		$negotiable=mysql_real_escape_string(0);
	}
	$meetup = mysql_real_escape_string($_POST['meetup_place']);
	//$password = mysql_real_escape_string($_POST['user_password']); //hashing to be added in future
	
	session_start(); 
	$seller =  $_SESSION['animolibrousername']; //not sure if this is right
	

	$currDate = date('Y-m-d');

	$sellerrow=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller'  LIMIT 1"));
	$sellid=mysql_real_escape_string((int)$sellerrow['id']);

    $result = mysql_query("SELECT COUNT(seller_id) FROM ad WHERE submitted_at = '$currDate'");
    
    $row = mysql_fetch_array($result);
    //limit to 5 posts per day
    if($row['COUNT(seller_id)'] > 5) {
        echo "Submitted ". $row['COUNT(seller_id)'] . " times today. Try again in 24hours"; 
    }
    else {
	    /*Check if book has already been added to DB*/
		$check_book="SELECT id FROM Book WHERE isbn= $isbn";
		$check_query=mysql_query($check_book);

		if(!empty($check_query)&&mysql_num_rows($check_query) == 1){
			$check_row= mysql_fetch_array($check_query); 
			//$title= mysql_real_escape_string((int)$row['title']);
			$bookID=$check_row['id'];
			$add_book="Book already added";
			echo $add_book;
		}

		else{
			/*get cover picture*/
			if(!empty($_SESSION['imagename'])) {
				$coverpic_name = $_SESSION['imagename'];
			
				$get_coverpic = "SELECT id FROM Image WHERE href = '$coverpic_name'";
				$cover_query=mysql_query($get_coverpic);
				if(mysql_num_rows($cover_query) == 1) {
					$cover_row= mysql_fetch_array($cover_query); 
					$cover_id= mysql_real_escape_string((int)$cover_row['id']);
		
					/*add book to DB if necessary*/
					$add_book ="INSERT INTO Book (title, authors, publisher, isbn, category,cover_pic_id) VALUES ('$title','$authors','$publisher','$isbn','$category',$cover_id)";
					//later on, add a way to save and reference categories and subjects
				}
			}
			else {
				$add_book ="INSERT INTO Book (title, authors, publisher, isbn, category) VALUES ('$title','$authors','$publisher','$isbn','$category')";
			}
			
			//get book ID for subject table update
			/*$check_book="SELECT id FROM Book WHERE isbn= $isbn";
			$check_query=mysql_query($check_book);
			$check_row= mysql_fetch_array($check_query); 
			$bookID=$check_row['id'];*/
		}
		
		
		
		
		$seller_row=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller'  LIMIT 1"));
		$sellerid=mysql_real_escape_string((int)$seller_row['id']);

		if($sellerid!=0) {
			echo $add_book;
			if($add_book=="Book already added"||mysql_query($add_book)) {


				/* Log newly added book into action database */
				$last_bookID = mysql_insert_id();
				$log_insert_book = "INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES ('$sellerid', 2)";

				if (mysql_query($log_insert_book)) {
					/* Main log successful */
					$last_logID = mysql_insert_id();
					$log_insert_book_log = "INSERT INTO `log_actions_book` (`log_id`, `book_id`) VALUES ('$last_logID', '$last_bookID')";
					
					if (mysql_query($log_insert_book_log)) {
						/* Book log successful */
					}
					else {
						/* Book log error TODO */
					}
				}
				else {
					/* Main log error TODO */
				}
				/* End of logging */


				$get_book_id=mysql_query("SELECT id FROM Book WHERE isbn='$isbn'");
				if(mysql_num_rows($get_book_id) == 1) {
					$row= mysql_fetch_array($get_book_id); 
					$bookid= mysql_real_escape_string((int)$row['id']);
					
					/*echo $bookid;
					echo $price;
					echo $negotiable;
					echo $condition;*/
					
					//add subjects to book
					foreach ($subjects as $subject) {
						$getSubjectID="SELECT id FROM Subject WHERE code = '$subject'";
						$subjectIDquery=mysql_query($getSubjectID);
						$subjectIDrow=mysql_fetch_array($subjectIDquery);
						$subjectID=$subjectIDrow['id'];
						$checkDuplicate="SELECT * FROM Subject_uses_Book WHERE Book_id=$bookid, Subject_id=$subjectID";
						$dupliQuery=mysql_query($checkDuplicate);
						
						if(empty($dupliQuery)||mysql_num_rows($dupliQuery) == 0) {
							$addsubject="INSERT INTO Subject_uses_Book (Book_id, Subject_id) VALUES ($bookid, $subjectID)";
			
							if(mysql_query($addsubject)) {
								
							}
			
						}
			
					}
						
					$datetoday = date("Y-m-d");
					/*Add advertisement to DB*/
					$add_ad = "INSERT INTO Ad (cost, meetup, copy_condition, negotiable,  status, description, seller_id, book_id, submitted_at) VALUES ($price,'$meetup','$condition',$negotiable,0,'$description',$sellerid,$bookid,CURDATE())";
					echo $add_ad;
					if(mysql_query($add_ad)){
						header("Location: http://localhost/animolibro/userprofile.php?user=".$_SESSION["animolibrousername"]); 
					}
					else {
						echo "failed to add ad";
						/* Error TODO */
					}
				}
				else {
					echo "failed to query book id";
					/* Error TODO */
				}
			}
			else {
				echo "failed to add book";
				/* Error TODO */
			}
		}
		else echo "Invalid user or password";
		
		//TODO: add password validation

		

	    //session_start(); 
	    //$_SESSION['username'] = $row['username'];
	    //header("Location: http://localhost/animolibro/home.html"); // Modify to go to the page you would like 

		exit; 
	}

}
else {    //If the form button wasn't submitted go to the index page, or login page 
    header("Location: index.php");     
    exit; 
} 
?>