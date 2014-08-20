<?php
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

echo'  <body>';
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
	include('php/dbConnect.php');
    echo'<div class="row">
        <div class="col-lg-8 center">
		<h4>Search Results</h4>';
    $keywords = mysql_real_escape_string($_POST['typeahead']); 
	
	$keywordarray= explode(" ", $keywords);
	array_unshift($keywordarray, $keywords);
	$i=0;
	$listedIDs=[];
	$j=0;
	$extraBookIDs=[];
	foreach($keywordarray as $keyword) {
		/*//multi-subject stuff
		$subjectquery=mysql_query("SELECT id from Subject WHERE code LIKE '%$keyword%'");
		while($subjectrow=mysql_fetch_array($subjectquery)) {
			$subjectid=$subjectrow['id'];
			$subjectbookquery="SELECT DISTINCT Book_id FROM Subject_uses_Book WHERE Subject_id = $subjectid";
			$subjectbooks= mysql_query($subjectbookquery);
			
			while($subjectbookrow=mysql_fetch_array($subjectbooks)) {
				$extraBookIDs[$j] = $subjectbookrow['Book_id'];
				$j ++;	
			}
		}*/
	
		$query ="SELECT * FROM Book  
	        WHERE title LIKE '%$keyword%'
			OR isbn LIKE '%$keyword%' OR authors LIKE '%$keyword%' 
			OR category LIKE '%$keyword%' 
			OR publisher LIKE '%$keyword%' ORDER BY TITLE";
			foreach($extraBookIDs as $extraID) {
				$query.=" OR id = ".$extraID;
			}
			//echo $query;
		$sql = mysql_query($query);
		if ($sql === FALSE) {
			/* Query failed */
			echo $query;
			echo "<br />No results found";
			exit;
		}
		else {
		    if(mysql_num_rows($sql) >= 1){ 
				
				while($row = mysql_fetch_array($sql)) {
				
					$bookid=$row['id'];
					$isbn=$row['isbn'];
					$title=$row['title'];
					$category=$row['category'];
					$authors=$row['authors'];
					$copyquery =mysql_query("SELECT COUNT(*) AS numcopies FROM Ad WHERE Book_id = $bookid AND (status=0 OR status=3) ");
					$copy_row=mysql_fetch_array($copyquery);
					$numcopies=$copy_row['numcopies'];
					$publisher=$row['publisher'];
						
					$coverpic_id=$row['cover_pic_id'];
					$coverquery=mysql_query("SELECT href FROM Image WHERE id = $coverpic_id");
					if(!empty($coverquery)){
						if(mysql_num_rows($coverquery)==1) {
							$cover_row=mysql_fetch_array($coverquery);
							$cover_filename=$cover_row['href'];
						}
						else{
							$cover_filename="placeholder.gif";
						}
					}
					else{
						$cover_filename="placeholder.gif";
					}
					
					if(in_array($bookid, $listedIDs)==false){
						$listedIDs[$i] = $bookid;
						$i ++;
						//echo $row['title'] . " " . $row['LastName'];
						// "<br>";
						echo ' <div class="col-lg-6 col-md-6 col-sm-6"><div class="panel panel-default">
							<div class="panel-heading">
							<h3 class="panel-title">';
						echo $title;
						echo'</h3>
							</div>
							<div class="panel-body">
							<div class="col-sm-4 col-md-4 col-lg-4">
		                        <img src="uploads/'.$cover_filename.'"  alt="" class="img-rounded img-responsive" />
		                    </div>
							<div class="card_info">
							<p>Category: ';
						echo $category;
						echo '<p>Author: ';
						echo $authors;
							
						echo'<p>Copies Available: ';
						echo $numcopies.'</div>';
						echo'<form action="bookprofile.php"  id="viewBook" method="post">
						<input type="text" class="hidden" id="isbn" name="isbn" value="'.$isbn.'"/>
						<input type="text" class="hidden" id="bookid" name="bookid" value="'.$bookid.'"/>
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
else{    //If the form button wasn't submitted go to the index page, or login page 
  
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