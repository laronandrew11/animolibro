<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");


if(isset($_POST['submit'])){  
    include('dbConnect.php');
    $db = database::getInstance(); 
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

//	$sellerrow=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller'  LIMIT 1"));
	$sellerrow = $db->dbh->prepare("SELECT * FROM UserAccount WHERE username = :seller LIMIT 1");
	$sellerrow->execute(array(':seller' => $seller));
	$sellrow = $sellerrow->fetch(PDO::FETCH_ASSOC);
	$sellid=mysql_real_escape_string((int)$sellrow['id']);

 //   $result = mysql_query("SELECT COUNT(seller_id) FROM ad WHERE submitted_at = '$currDate'");
    
    $result = $db->dbh->prepare("SELECT COUNT(seller_id) FROM ad WHERE submitted_at = :currDate");
	$result->execute(array(':currDate' => $currDate));
	$row = $result->fetch(PDO::FETCH_ASSOC);

   // $row = mysql_fetch_array($result);

    //limit to 5 posts per day
    if($row['COUNT(seller_id)'] > 133) {
        echo "Submitted ". $row['COUNT(seller_id)'] . " times today. Try again in 24hours"; 
    }
    else {
	    /*Check if book has already been added to DB*/
	//	$check_book="SELECT id FROM Book WHERE isbn= $isbn";
		$check_book=$db->dbh->prepare("SELECT id FROM Book WHERE isbn= :isbn");
		$check_book->execute(array(':isbn' => $isbn));

		$check_query=$check_book->fetchAll();

		if(count($check_query) == 1){
			$check_row= $check_book->fetch(PDO::FETCH_ASSOC); 
			//$title= mysql_real_escape_string((int)$row['title']);
			$bookID=$check_row['id'];
			$add_book="Book already added";
			echo $add_book;
		}

		else{
			/*get cover picture*/
			if(!empty($_SESSION['imagename'])) {
				$coverpic_name = $_SESSION['imagename'];
			
				//$get_coverpic = "SELECT id FROM Image WHERE href = '$coverpic_name'";

				$get_coverpic=$db->dbh->prepare("SELECT id FROM Image WHERE href = :coverpicname");
				$get_coverpic->execute(array(':coverpicname' => $coverpic_name));

				$cover_query=$get_coverpic->fetchAll();
				if(count($cover_query) == 1) {
					$cover_row= $get_coverpic->fetch(PDO::FETCH_ASSOC); 
					$cover_id= mysql_real_escape_string((int)$cover_row['id']);
		
					/*add book to DB if necessary*/
					$add_book =$db->dbh->prepare("INSERT INTO Book (title, authors, publisher, isbn, category,cover_pic_id) VALUES ('$title','$authors','$publisher','$isbn','$category',$cover_id)");
					//later on, add a way to save and reference categories and subjects
				}
			}
			else {
				$add_book =$db->dbh->prepare("INSERT INTO Book (title, authors, publisher, isbn, category) VALUES ('$title','$authors','$publisher','$isbn','$category')");
			}
			
			//get book ID for subject table update
			/*$check_book="SELECT id FROM Book WHERE isbn= $isbn";
			$check_query=mysql_query($check_book);
			$check_row= mysql_fetch_array($check_query); 
			$bookID=$check_row['id'];*/
		}
		
		
	//	$seller_row=mysql_fetch_array(mysql_query("SELECT * FROM UserAccount WHERE username = '$seller'  LIMIT 1"));
	//	$sellerid=mysql_real_escape_string((int)$seller_row['id']);

		$seller_row=$db->dbh->prepare("SELECT * FROM UserAccount WHERE username = :seller LIMIT 1");
		$seller_row->execute(array(':seller' => $seller));
		$sellrow = $seller_row->fetch(PDO::FETCH_ASSOC);
		$sellerid=mysql_real_escape_string((int)$sellrow['id']);

		if($sellerid!=0) {
			echo $add_book;
			if($add_book=="Book already added"||$add_book->execute()) {

				/* Log newly added book into action database */
				$last_bookID = mysql_insert_id();

				//$log_insert_book = "INSERT INTO `log_actions` (`user_id`, `action_type_id`) VALUES ('$sellerid', 2)";

				$log_insert_book = $db->dbh->prepare("INSERT INTO log_actions (user_id, action_type_id) VALUES (:user_id, :action_type_id)");

				if ($log_insert_book->execute(array(':user_id' => $sellerid, 2))) {
					/* Main log successful */
					$last_logID = mysql_insert_id();
					//$log_insert_book_log = "INSERT INTO `log_actions_book` (`log_id`, `book_id`) VALUES ('$last_logID', '$last_bookID')";
					
					$log_insert_book_log = $db->dbh->prepare("INSERT INTO log_actions_book (log_id, book_id) VALUES (:log_id, :book_id)");
				    $log_insert_book_log->bindParam(':log_id', $last_logID);
				    $log_insert_book_log->bindParam(':book_id', last_bookID);


					if ($log_insert_book_log->execute()) {
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


				//$get_book_id=mysql_query("SELECT id FROM Book WHERE isbn='$isbn'");
				$get_book_id= $db->dbh->prepare("SELECT id FROM Book WHERE isbn=:isbn");
				

				if($get_book_id->execute(array(':isbn' => $isbn))) {
					$row= $get_book_id->fetch(PDO::FETCH_BOTH); 
					$bookid= mysql_real_escape_string((int)$row['id']);

					echo $bookid;
					/*
					//add subjects to book
					foreach ($subjects as $subject) {
						//$getSubjectID="SELECT id FROM Subject WHERE code = '$subject'";
						$getSubjectID = $db->dbh->prepare("SELECT id FROM Subject WHERE code = :subject");
						$getSubjectID->execute(array(':subject' => $subject));

						//$subjectIDquery=mysql_query($getSubjectID);
						//$subjectIDrow=mysql_fetch_array($subjectIDquery);
						$subjectIDrow=$getSubjectID->fetch(PDO::FETCH_BOTH); 
						$subjectID=$subjectIDrow['id'];

						//$checkDuplicate="SELECT * FROM Subject_uses_Book WHERE Book_id=$bookid, Subject_id=$subjectID";
						$checkDuplicate= $db->dbh->prepare("SELECT * FROM Subject_uses_Book WHERE Book_id=:bookid AND Subject_id=:subjectID");
						$checkDuplicate->execute(array(':bookid' => $bookid, ':subjectID'=>$subjectID));
						//$dupliQuery=mysql_query($checkDuplicate);
						if(count($checkDuplicate->fetchAll()) == 0) {
						//if(empty($dupliQuery)||mysql_num_rows($dupliQuery) == 0) {

							//$addsubject="INSERT INTO Subject_uses_Book (Book_id, Subject_id) VALUES ($bookid, $subjectID)";
							$addsubject=$db->dbh->prepare("INSERT INTO Subject_uses_Book (Book_id, Subject_id) VALUES (:bookid, :subjectID)");
							$addsubject->bindParam(':bookid', $bookid);
    						$addsubject->bindParam(':subjectid', $subjectID);
							if($addsubject->execute()){
							//if(mysql_query($addsubject)) {
								
							}
			
						}
			
					}
*/
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
					$stmt = $db->dbh->prepare("INSERT INTO ad (cost, meetup, copy_condition, negotiable, status, description, seller_id, Book_id, submitted_at) 
						VALUES (:cost,:meetup,:copy_condition,:negotiable,:status,:description,:seller_id,:book_id,CURDATE())");

				//	$add_ad = "INSERT INTO Ad (cost, meetup, copy_condition, negotiable,  status, description, seller_id, book_id, submitted_at) VALUES ($price,'$meetup','$condition',$negotiable,0,'$description',$sellerid,$bookid,CURDATE())";
					echo $bookid;
					if($stmt->execute(array(':cost' => $price,
										':meetup' => $meetup,
										':copy_condition' => $condition,
										':negotiable' => $negotiable,
										':status' => 0,
										':description' => $description,
										':seller_id' => $sellerid,
										':book_id' => $bookid))){
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