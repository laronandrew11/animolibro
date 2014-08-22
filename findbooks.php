<?php
include_once('php/animolibroerrorhandler.php');
session_start();
if(isset($_POST["submit0"])){ 
	$passed_title = $_POST["loc"];
}
else {
	$passed_title="";
}
echo '<!DOCTYPE html>
	<html>';

include('head.php');

echo' <body>';
include('navbar.php');
echo '<div class="container">
	<div class="row">
	<form action="findbooks.php" class="form-horizontal" role="form" id="searchForm" method="post" >
	<div class="col-lg-8 center">
	<div class="col-lg-10 center">
	<div class="form-group">
	<legend>Find a Book</legend>
	<div class="controls">
	<input type="text" placeholder="Search by Title, ISBN, Author, Publisher, or Category:" class=" form-control form-control_inline input-xlarge" id="typeahead" name="typeahead" rel="popover" data-provide="typeahead" data-content="Enter your search keywords." data-original-title="Title">
	<input type="submit" class="btn btn-success" role="button" name = "submit" value = "Search">
	</div>
	</div>
	</div>	
	<!--div class="form-group">
		<label class="control-label">Sort By</label> 
		<div class="controls">
		<select name="sortby">
			<option value="choice1">Date Added</option>
			<option value="choice2">Number of Copies</option>
			<option value="choice3">Title</option>
			<option value="choice4">Category</option>
		</select>
		</div>
	</div-->	
	</div>	
	</div>
	</form>
	</div>
	</div>
  </div>';

if(isset($_POST['submit'])){ 
	$db = database::getInstance();
	echo'<div class="row">
    <div class="col-lg-8 center">
		<h4>Search Results</h4>';
  $keywords = $_POST['typeahead'];
	
	$keywordarray= explode(" ", $keywords);
	array_unshift($keywordarray, $keywords);
	$i = 0;
	$listedIDs = [];
	$j = 0;
	$extraBookIDs = [];
	foreach($keywordarray as $keyword) {
		/*//multi-subject stuff
		$subjectquery=mysql_query("SELECT id from Subject WHERE code LIKE '%$keyword%'");
		while($subjectrow=mysql_fetch_array($subjectquery)) {
			$subjectid = $subjectrow['id'];
			$subjectbookquery="SELECT DISTINCT Book_id FROM Subject_uses_Book WHERE Subject_id = $subjectid";
			$subjectbooks= mysql_query($subjectbookquery);
			
			while($subjectbookrow=mysql_fetch_array($subjectbooks)) {
				$extraBookIDs[$j] = $subjectbookrow['Book_id'];
				$j ++;	
			}
		}*/
	
		$book_query_statement = "SELECT * FROM book ".
								"WHERE (title LIKE :keyword1 ".
								"OR isbn LIKE :keyword2 ".
								"OR authors LIKE :keyword3 ".
								"OR category LIKE :keyword4 ".
								"OR publisher LIKE :keyword5";
		$extraCounter = 0;
		while ($extraCounter < count($extraBookIDs)) {
			$book_query_statement .= " OR id = :extraID".$extraCounter;
			$extraCounter++;
		}
		$book_query_statement .= ") ORDER BY TITLE;";
		
		$keyword = '%' . $keyword . '%';

		$book_query = $db->dbh->prepare($book_query_statement);
		$book_query->bindParam(':keyword1', $keyword);
		$book_query->bindParam(':keyword2', $keyword);
		$book_query->bindParam(':keyword3', $keyword);
		$book_query->bindParam(':keyword4', $keyword);
		$book_query->bindParam(':keyword5', $keyword);
		$extraCounter = 0;
		foreach($extraBookIDs as $extraID) {
			$book_query->bindParam(':extraID'.$extraCounter, $extraID);
			$extraCounter++;
		}

		/* Query failed */
		if ($book_query->execute() === FALSE) {
			echo "<br />No results found";
			exit;
		}
		else {
			if($book_query->rowcount() >= 1){ 
				while($book_row = $book_query->fetch(PDO::FETCH_ASSOC)) {
					$book_id = $book_row['id'];
					$isbn = $book_row['isbn'];
					$title = $book_row['title'];
					$category = $book_row['category'];
					$authors = $book_row['authors'];
					$publisher = $book_row['publisher'];

					$book_copy_query = $db->dbh->prepare("SELECT COUNT(*) AS numcopies FROM Ad WHERE Book_id = :book_id AND (status=0 OR status=3)");
					$book_copy_query->bindParam(':book_id', $book_id);
					$book_copy_query->execute();
					$book_copy_row = $book_copy_query->fetch(PDO::FETCH_ASSOC);
					$numcopies = $book_copy_row['numcopies'];

					$coverpic_id = $book_row['cover_pic_id'];
					$coverpic_query = $db->dbh->prepare("SELECT href FROM Image WHERE id = :coverpic_id");
					$coverpic_query->bindParam(':coverpic_id', $coverpic_id);
					if($coverpic_query->execute()) {
						if($coverpic_query->rowcount() > 0) {
							$coverpic_row = $coverpic_query->fetch(PDO::FETCH_ASSOC);
							$coverpic_filename = $coverpic_row['href'];
						}
						else{
							$coverpic_filename = "placeholder.gif";
						}
					}
					else{
						$coverpic_filename = "placeholder.gif";
					}
					
					if(in_array($book_id, $listedIDs) == false){
						$listedIDs[$i] = $book_id;
						$i ++;
						//echo $book_row['title'] . " " . $book_row['LastName'];
						// "<br>";
						echo ' <div class="col-lg-6 col-md-6 col-sm-6"><div class="panel panel-default">
							<div class="panel-heading">
							<h3 class="panel-title">';
						echo $title;
						echo'</h3>
							</div>
							<div class="panel-body">
							<div class="col-sm-4 col-md-4 col-lg-4">
		            <img src="uploads/'.$coverpic_filename.'" alt="" class="img-rounded img-responsive" />
		          </div>
							<div class="card_info">
							<p>Category: ';
						echo $category;
						echo '<p>Author: ';
						echo $authors;
							
						echo'<p>Copies Available: ';
						echo $numcopies.'</div>';
						echo'<form action="bookprofile.php" id="viewBook" method="post">
						<input type="text" class="hidden" id="isbn" name="isbn" value="'.$isbn.'"/>
						<input type="text" class="hidden" id="bookid" name="bookid" value="'.$book_id.'"/>
						<input type="text" class="hidden" id="title" name="title" value="'.$title.'"/>
						<input type="text" class="hidden" id="category" name="category" value="'.$category.'"/>
						<input type="text" class="hidden" id="authors" name="authors" value="'.$authors.'"/>
						<input type="text" class="hidden" id="publisher" name="publisher" value="'.$publisher.'"/>
						<input type="text" class="hidden" id="numcopies" name="numcopies" value="'.$numcopies.'"/>
						<button type="submit" class="btn btn-primary pull-right" name="submit">View Sellers</button>
						</form>
						</div>
							</div></div>';
					}
				}
			
		    //exit;
		  }
		}
	}
		//print_r( $listedIDs);
}
else{  //If the form button wasn't submitted go to the index page, or login page 
 
}
?>
	


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://code.jquery.com/jquery.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="dist/js/bootstrap.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	 <script src="js/autofill.js">
		
	</script>
 </body>
</html>