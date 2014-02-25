<?php
	session_start();
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
			<li class="active"><a href="#">Sell</a></li>
			<li><a href="findbooks.php">Find</a></li>
          </ul>
         <ul class="nav navbar-nav navbar-right">
			  <!--<li><a href="userprofile.html"><span class="glyphicon glyphicon-user"></span>  Andrew Laron</a></li>-->';
	echo '<li><a href="userprofile.php"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></li>';
	echo '<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
				  <li><a href="#">Hey</a></li>
				  <li><a href="#"></a></li>
				  <li><a href="#"></a></li>
				  <li class="divider"></li>
				  <li><a href="#"></a></li>
				</ul>
			  </li>
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>';
	
?>
<script src="sellbookpage.php"></script>
<div class="container">
	<div class="row">
	<div class="col-sm-8 col-md-8">
	<div class="alert alert-success" id="success-alert">
		Registration successful!
	</div>
		<form action="php/sellbook.php" class="form-horizontal" role="form" id="sellForm" method="post" >
		<fieldset>
		
		<legend>Put up a Book</legend>

		<div class="form-group">
		<label class="control-label">ISBN</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_isbn" name="book_isbn" rel="popover" data-content="Enter the book's ISBN number to automatically fill out other information." data-original-title="ISBN">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Title</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_title" name="book_title" rel="popover" data-content="Enter the book's full title." data-original-title="Title">
		</div>
		</div>

		<div class="form-group">
		<label class="control-label">Authors</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_authors" name="book_authors" rel="popover" data-content="Enter the book's authors." data-original-title="Authors">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Publisher</label> <!--honestly not essential-->
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
		<label class="control-label">Category</label> 
		<div class="controls">
		<select name="category">
		<option value="Computer">Computer</option>
		<option value="Law">Law</option>
		<option value="Mathematics">Mathematics</option>
		<option value="Science">Science</option>
		</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Used in Subject:</label> <!--change to combobox?-->
		<div class="controls">
		<!--input type="text" class="input-xlarge form-control" id="book_subject" name="book_subject" rel="popover" data-content="Enter the subjects where this book is used." data-original-title="Subjects"-->
		<select name="book_subject">
			<option value="ALGOCOM">ALGOCOM</option>
			<option value="HCIFACE">HCIFACE</option>
			<option value="PROFSWD">PROFSWD</option>
			<option value="STRESME">STRESME</option>
			<option value="WEBAPPS">WEBAPPS</option>
			</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Condition</label>
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
		<label class="control-label">Description</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_description" name="book_description" rel="popover" data-content="Enter a description." data-original-title="Description">
		</div>
		</div>
		
		</fieldset>
		<fieldset>
		<legend>Selling Preferences</legend>
		
		<div class="form-group">
		<label class="control-label">Preferred Price</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="book_price" name="book_price" rel="popover" data-content="Set your asking price for this book." data-original-title="Book Price">
		 <div class="checkbox">
    <label>
      <input type="checkbox" name="negotiable"> Negotiable
    </label>
  </div>
		</div>
		
			<div class="form-group">
		<label class="control-label">Preferred Meetup Place</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="meetup_place" name="meetup_place" rel="popover" data-content="Where do you want to meet your buyers?" data-original-title="Meetup Place">
		</div>
		</div>
		
			<div class="form-group">
		<label class="control-label">Password</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control" id="user_password" name="user_password" rel="popover" data-content="Enter a password." data-original-title="Password">
		</div>
		</div>
	
		
		
		<div class="form-group">
		<label class="control-label"></label>
		<div class="controls">
		<input type="submit" class="btn btn-success" role="button" name = "submit" value = "Post Advertisement">
		<!--a type="submit" class="btn btn-success" href="userprofile.html" id="btn-submit">Post Advertisement</a-->
		
		</div>
		</div>
		</div></fieldset>
		</form>
	</div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	<script src="js/sellbook.js"></script>
  
</body></html>