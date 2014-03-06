<?php
	session_start();
		if(isset($_POST["submit0"])){ 
		$passed_title = $_POST["loc"];
		}else {$passed_title="";}
	echo '<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="css/customized-components.css" rel="stylesheet">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>';
	echo '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">AnimoLibro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
             <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
			<li><a href="sellbookpage.php">Sell</a></li>
			<li class="active"><a href="#">Find</a></li>
          </ul>
         <ul class="nav navbar-nav navbar-right">
			  <!--<li><a href="userprofile.html"><span class="glyphicon glyphicon-user"></span>  Andrew Laron</a></li>-->';
	echo '<li><a href="userprofile.php"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></li>';
	echo '<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
				    <li><a href="php/logout.php">Log-out</a></li>
				  <li class="divider"></li>
				  <li><a href="#"></a></li>
				</ul>
			  </li>
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>';
	echo '<div class="container">
<div class="row">
		<form action="findbooks.php" class="form-horizontal" role="form" id="searchForm" method="post" >
				
		<div class="col-lg-8 center">


	
	<div class="col-lg-6 center">
		
			
			<div class="form-group">
			<label class="control-label">Search by Title, ISBN, Author, Publisher, Category, or Subject:</label>
			<div class="controls">
			<input type="text" class="input-xlarge form-control" id="book_title" name="book_title" rel="popover" data-content="Enter your search keywords." data-original-title="Title">
			</div>
		    <div class="controls">
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
			<option value="choice5">Subject</option>
			</select>
			</div>
		
			</div-->	
	</div>	
		
		</div>
		
		</form>
	</div>
	</div>
    </div>
	<div class="row">
        <div class="col-lg-4 center">
			<h4>Search Results</h4>';

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

    $keywords = mysql_real_escape_string($_POST['book_title']); 
	$keywordarray= explode(" ", $keywords);
	$i=0;
	$listedIDs=[];
	foreach($keywordarray as $keyword)
	{
	$query ="SELECT * FROM Book  
        WHERE title LIKE '%$keyword%'
		OR isbn LIKE '%$keyword%' OR authors LIKE '%$keyword%' 
		OR subjects LIKE'%$keyword%' 
		OR category LIKE '%$keyword%' 
		OR publisher LIKE '%$keyword%'";
		//echo $query;
		
	
	$sql = mysql_query($query);
    if(mysql_num_rows($sql) >= 1){ 
		
		while($row = mysql_fetch_array($sql))
		{
		
			$bookid=$row['id'];
			$isbn=$row['isbn'];
			$title=$row['title'];
			$category=$row['category'];
			$authors=$row['authors'];
			$copyquery =mysql_query("SELECT COUNT(*) AS numcopies FROM Ad WHERE Book_id = $bookid");
			$copy_row=mysql_fetch_array($copyquery);
			$numcopies=$copy_row['numcopies'];
			$publisher=$row['publisher'];
			$subject=$row['subjects'];
			if(in_array($bookid, $listedIDs)==false){
			$listedIDs[$i] = $bookid;
			$i ++;
			
			
			
			//echo $row['title'] . " " . $row['LastName'];
			// "<br>";
			echo ' <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
					echo $title;
					echo'</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookcoversmall.jpg"  alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Category: ';
					echo $category;
					echo '<p>Author: ';
					echo $authors;
					
					echo'<p>Copies Available: ';
					echo $numcopies;
					
					$hrefstring= 'bookprofile.php?isbn='. $isbn .'&bookid='.$bookid.'&title=' . $title.'&category='.$category.'&subject='.$subject.'&authors='.$authors.'&publisher='.$publisher.'&numcopies='.$numcopies;
					
					echo '<a role="button" href = "';
					echo $hrefstring;
					echo'" class="btn btn-primary pull-right" role=>View</a>
				</div>
			</div>';
			}
		}
	
		
        //exit; 
    }else{ 
        //echo "No results found";
        //exit; 
    } 
	}
		//print_r( $listedIDs);
}else{    //If the form button wasn't submitted go to the index page, or login page 
  
} 
	
	
?>
	
          <!--div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookcoversmall.jpg"  alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Category: Information Technology
					<p>Author: Bob
					<p>Copies Available: 4
					<a role="button" href = "bookprofile.html" class="btn btn-primary pull-right" role=>View</a>
				</div>
			</div>
			   <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">This Book Is Full of Spiders</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookcover2small.jpg"  alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Category: Survival
					<p>Author: D. Wong
					<p>Copies Available: 9
					<a role="button" href = "bookprofile.html" class="btn btn-primary pull-right" role=>View</a>
				</div>
			</div>

       

      </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>