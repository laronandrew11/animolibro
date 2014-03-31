<?php
	session_start();
	$_SESSION['upload_type']=0; //so upload.php knows that we are uploading a cover image for the book
?>
	<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="css/customized-components.css" rel="stylesheet">
<!-- Google web fonts -->


		<!-- The main CSS file -->
		<link href="css/upload.css" rel="stylesheet" />

      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!--[endif]-->
  </head>
  <body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Animo&#9734Libro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
             <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
			<li class="active"><a href="#">Sell</a></li>
			<li><a href="findbooks.php">Find</a></li>
          </ul>
         <ul class="nav navbar-nav navbar-right">
		 <?php
	echo '<li><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	?>
	</a></li>
	<li class="dropdown">
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
    </div>
	

<script src="sellbookpage.php"></script>
<div class="container">
	<div class="row">
	<div class="col-sm-8 col-md-8">
	<!--div class="alert alert-success" id="success-alert">
		Registration successful!
	</div-->
	
		<legend style="margin-left: -15px">Put up a Book</legend>

		<p style="margin-left: -15px"> <font size="2" color="red">Fields marked with * are required</font></p>
		
					

			


		
		<form action="php/sellbook.php" class="form-horizontal" role="form" id="sellForm" method="post" >
		<fieldset>		
	
		<div class="form-group">
		<label class="control-label">ISBN*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_isbn" name="book_isbn" rel="popover" data-content="Enter the book's ISBN number to automatically fill out other information." data-original-title="ISBN">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Title*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_title" name="book_title" rel="popover" data-content="Enter the book's full title." data-original-title="Title">
		</div>
		</div>
		


		<div class="form-group">
		<label class="control-label">Authors*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_authors" name="book_authors" rel="popover" data-content="Enter the book's authors." data-original-title="Authors">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Publisher*</label> <!--honestly not essential-->
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_publisher" name="book_publisher" rel="popover" data-content="Enter the book's publisher." data-original-title="Publisher">
		</div>
		</div>
		
		<!--div class="form-group">
		<label class="control-label">Category</label>  
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_category" name="book_category" rel="popover" data-content="Select the book's category." data-original-title="Full Name">
		</div>
		</div-->
		
		<div class="form-group">
		<label class="control-label">Category*</label> 
		<div class="controls">
		<select name="category">
			<?php
			$dbHost = "localhost";        //Location Of Database usually its localhost 
    $dbUser = "root";            //Database User Name 
    $dbPass = "";            //Database Password 
    $dbDatabase = "animolibrosimple";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the databasse 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
    //Selects the database 
     
	 $queryString="SELECT DISTINCT category FROM Book";
	 $query=mysql_query($queryString);
	 if(mysql_num_rows($query) >= 1){ 
		
		while($row = mysql_fetch_array($query))
		{
			$category=$row['category'];
		
			echo '<option value='.$category.'>'.$category.'</option>';
		}
	}
		?>
		<!--option value="Computer">Computer</option>
		<option value="Law">Law</option>
		<option value="Mathematics">Mathematics</option>
		<option value="Science">Science</option-->
		</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Used in Subject: *</label> <!--change to combobox?-->
		<div class="controls">
		<!--input type="text" class="input-xlarge form-control" id="book_subject" name="book_subject" rel="popover" data-content="Enter the subjects where this book is used." data-original-title="Subjects"-->
		<select name="book_subject">
		
			<?php
			
     
	 $queryString="SELECT DISTINCT subjects FROM Book";
	 $query=mysql_query($queryString);
	 if(mysql_num_rows($query) >= 1){ 
		
		while($row = mysql_fetch_array($query))
		{
			$subject=$row['subjects'];
		
			echo '<option value='.$subject.'>'.$subject.'</option>';
		}
	}
		?>
			<!--option value="ALGOCOM">ALGOCOM</option>
			<option value="HCIFACE">HCIFACE</option>
			<option value="PROFSWD">PROFSWD</option>
			<option value="STRESME">STRESME</option>
			<option value="WEBAPPS">WEBAPPS</option-->
			</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Condition*</label>
		<div class="controls">
			<div class="radio-inline">
				<label>
				<input type="radio" name="conditionRadios" id="conditionRadios1" value="excellent" checked="">
					Excellent
				</label>
			</div>
			<div class="radio-inline">
			<label>
			<input type="radio" name="conditionRadios" id="conditionRadios2" value="good">
				Good
			</label>
			</div>
			<div class="radio-inline">
			<label>
			<input type="radio" name="conditionRadios" id="conditionRadios3" value="worn">
				Worn
			</label>
			</div>
			<div class="radio-inline">
			<label>
			<input type="radio" name="conditionRadios" id="conditionRadios4" value="marked">
				Damaged/Marked
			</label>
			</div>
		</div>
		</div>
		
			<div class="form-group">
		<label class="control-label">Description*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_description" name="book_description" rel="popover" data-content="Enter a description." data-original-title="Description">
		</div>
		</div>
		
	
		</fieldset>
		<fieldset>
		<legend style="margin-left: -15px">Selling Preferences</legend>
		
		<div class="form-group">
		<label class="control-label">Preferred Price*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_price" name="book_price" rel="popover" data-content="Set your asking price for this book." data-original-title="Book Price">
		 <div class="checkbox">
    <label>
      <input type="checkbox" name="negotiable"> Negotiable*
      <br />
    </label>
  </div>
		</div>
		
			<div class="form-group">
		<label class="control-label" style="margin-left: 15px">Preferred Meetup Place*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="meetup_place" style="margin-left: 15px" name="meetup_place" rel="popover" data-content="Where do you want to meet your buyers?" data-original-title="Meetup Place">
		</div>
		</div>
		
			<!--div class="form-group">
		<label class="control-label" style="margin-left: 15px">Password</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control" id="user_password" style="margin-left: 15px" name="user_password" rel="popover" data-content="Enter a password." data-original-title="Password">
		</div>
		</div-->
	
		
		
		<div class="form-group">
		<label class="control-label"></label>
		<div class="controls">
		<input type="submit" class="btn btn-success" style="margin-left: 15px" role="button" name = "submit" value = "Post Advertisement">
		<!--a type="submit" class="btn btn-success" href="userprofile.html" id="btn-submit">Post Advertisement</a-->
		
		</div>
		</div>
		</div></fieldset>
		</form>
			<div class="form-group">
			<label style="margin-left: -15px"class="control-label">Cover Picture (optional)</label>
			<form style="margin-left: -15px"id="upload" method="post" action="upload.php" enctype="multipart/form-data">
			<div class="col-lg-6 center" id="drop">
				Drop Cover Pic Here Or
				<a  class="btn btn-primary" >Browse</a>
				<input type="file" name="upl" />
			</div>
		<ul>
				<!-- The file uploads will be shown here -->
			</ul>
		</form>
		
				</div>
	</div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	
		<script src="js/upload/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="js/upload/jquery.ui.widget.js"></script>
		<script src="js/upload/jquery.iframe-transport.js"></script>
		<script src="js/upload/jquery.fileupload.js"></script>
		
		<script src="js/upload/script.js"></script>
		
	<script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	<script src="js/sellbook.js"></script>

  
</body></html>