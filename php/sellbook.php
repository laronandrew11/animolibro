<?php 
include_once('animolibroerrorhandler.php');
require_once("db_config.php");


if(isset($_POST['submit'])) {
	$db = database::getInstance();

	$isbn = $_POST['book_isbn'];
	$title = $_POST['book_title']; 
	$authors = $_POST['book_authors'];
	$publisher = $_POST['book_publisher'];
	$category = $_POST['category']; //implement w/ Category table later
	$subjects = $_POST['book_subject'];
	$condition = $_POST['conditionRadios'];
	$description = $_POST['book_description'];
	$price = $_POST['book_price'];
	$meetup = $_POST['meetup_place'];
	
	if(isset($_POST['negotiable']) && $_POST['negotiable'] == true) {
		$negotiable = 1;
	}
	else {
		$negotiable = 0;
	}
	
	//$password = $_POST['user_password']); //hashing to be added in future
	// TODO ASK FOR PASSWORD BEFORE POSTING

	session_start(); 
	$seller_id = $_SESSION['animolibroid'];

	$currDate = date('Y-m-d');

	$user_nsubmissions_query = $db->dbh->prepare("SELECT COUNT(seller_id) AS nSubmissions FROM ad WHERE submitted_at = :currDate");
	$user_nsubmissions_query->bindParam(':currDate', $currDate);
	$user_nsubmissions_query->execute();
	$user_nsubmissions_row = $user_nsubmissions_query->fetch(PDO::FETCH_ASSOC);

	// limit to 5 posts per day
	if($user_nsubmissions_row['nSubmissions'] > 133) {
		echo "Submitted " . $user_nsubmissions_row['nSubmissions'] . " times today. Try again in 24hours"; 
	}
	else {
		/*Check if book has already been added to DB*/
		$check_book_exists_query = $db->dbh->prepare("SELECT id FROM Book WHERE isbn= :isbn");
		$check_book_exists_query->bindParam(':isbn', $isbn);
		$check_book_exists_query->execute();

		if($check_book_exists_query->rowcount() > 0){
			$check_book_exists_row = $check_book_exists_query->fetch(PDO::FETCH_ASSOC); 
			$book_id = $check_book_exists_row['id'];
			$book_exists = true;
		}

		else{
			/*get cover picture*/
			if(isset($_SESSION['imagename'])) {
				$coverpic_name = $_SESSION['imagename'];

				$coverpic_query = $db->dbh->prepare("SELECT id FROM Image WHERE href = :coverpicname");
				$coverpic_query->bindParam(':coverpicname', $coverpic_name);
				$coverpic_query->execute();

				if($coverpic_query->rowcount() > 0) {
					$coverpic_row = $coverpic_query->fetch(PDO::FETCH_ASSOC); 
					$coverpic_id = (int)$coverpic_row['id'];
		
					/*add book to DB if necessary*/
					$insert_book_query = $db->dbh->prepare("INSERT INTO Book (title, authors, publisher, isbn, category,cover_pic_id) VALUES ('$title','$authors','$publisher','$isbn','$category',$coverpic_id)");
					//later on, add a way to save and reference categories and subjects
				}
			}
			else {
				$insert_book_query = $db->dbh->prepare("INSERT INTO Book (title, authors, publisher, isbn, category) VALUES ('$title','$authors','$publisher','$isbn','$category')");
			}
			
			//get book ID for subject table update
			/*$check_book_exists_query="SELECT id FROM Book WHERE isbn= $isbn";
			$check_book_exists_rowset=mysql_query($check_book_exists_query);
			$check_book_exists_row= mysql_fetch_array($check_book_exists_rowset); 
			$book_id=$check_book_exists_row['id'];*/
		}

		if(isset($_SESSION['animolibroid'])) {
			if ($book_exists == false && $insert_book_query->execute()) {
				$log_book_insertion = true;
			}
			if($book_exists == true) {
				$log_book_insertion = false;

				$book_id_query = $db->dbh->prepare("SELECT id FROM Book WHERE isbn=:isbn");
				$book_id_query->bindParam(':isbn', $isbn);
				if($book_id_query->execute()) {
					$book_id_row = $book_id_query->fetch(PDO::FETCH_ASSOC); 
					$book_id = (int)$book_id_row['id'];

					foreach ($subjects as $subject) {
						$subject_id_query = $db->dbh->prepare("SELECT id FROM Subject WHERE code = :subject");
						$subject_id_query->bindParam(':subject', $subject);
						if ($subject_id_query->execute()) {
							$subject_id_row = $subject_id_query->fetch(PDO::FETCH_ASSOC);
							$subject_id = $subject_id_row['id'];

							$book_subject_insert_query = $db->dbh->prepare("INSERT IGNORE INTO Subject_uses_Book (Book_id, Subject_id) VALUES (:book_id, :subject_id)");
							$book_subject_insert_query->bindParam(':book_id', $book_id);
							$book_subject_insert_query->bindParam(':subject_id', $subject_id);
							$book_subject_insert_query->execute();
						}
					}
						
					/*Add advertisement to DB*/
					$ad_insert_query = $db->dbh->prepare("INSERT INTO ad (cost, meetup, copy_condition, negotiable, status, description, seller_id, Book_id, submitted_at) VALUES (:cost, :meetup, :copy_condition, :negotiable, :status, :description, :seller_id, :book_id, CURDATE())");
					$ad_insert_query->bindParam(':cost', $price);
					$ad_insert_query->bindParam(':meetup', $meetup);
					$ad_insert_query->bindParam(':copy_condition', $condition);
					$ad_insert_query->bindParam(':negotiable', $negotiable);
					$ad_insert_query->bindValue(':status', 0, PDO::PARAM_INT);
					$ad_insert_query->bindParam(':description', $description);
					$ad_insert_query->bindParam(':seller_id', $seller_id);
					$ad_insert_query->bindParam(':book_id', $book_id);

					if($ad_insert_query->execute()) {
						header("Location: ../userprofile.php");
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

			if ($log_book_insertion == true) {
				/* Log newly added book into action database */
				$log_insert_book = $db->dbh->prepare("INSERT INTO log_actions (user_id, action_type_id) VALUES (:user_id, :action_type_id)");
				$log_insert_book->bindParam(':user_id', $seller_id);
				$log_insert_book->bindValue(':action_type_id', 2, PDO::PARAM_INT);

				if ($log_insert_book->execute()) {
					/* Main log successful */
					$last_insert_id = lastInsertId();

					$log_insert_book_log = $db->dbh->prepare("INSERT INTO log_actions_book (log_id, book_id) VALUES (:log_id, :book_id)");
					$log_insert_book_log->bindParam(':log_id', $last_insert_id);
					$log_insert_book_log->bindParam(':book_id', $last_bookID);
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
			}
		}
		else {
			echo "Invalid user or password";
			header("Location: index.php");
		}
		exit; 
	}

}
else {	//If the form button wasn't submitted go to the index page, or login page 
	header("Location: index.php");	 
	exit; 
} 
?>