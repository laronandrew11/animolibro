
	<!DOCTYPE html>
<html>
<?php
include_once('php/animolibroerrorhandler.php');

	include('head.php');
	session_start();
	$_SESSION['upload_type']=0; //so upload.php knows that we are uploading a cover image for the book
?>

  <body>
  <link href="css/upload.css" rel="stylesheet" />
	<?php
	include('navbar.php');
	?>
		
	
	

<!--script src="sellbookpage.php"></script-->
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
		<input type="text" class="input-xlarge form-control pop" id="book_isbn" name="book_isbn" rel="popover" data-content="Enter the book's ISBN number." data-original-title="ISBN">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Title*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_title" name="book_title" rel="popover" data-content="Enter the book's full title." data-original-title="Title">
		</div>
		</div>
		


		<div class="form-group">
		<label class="control-label">Authors*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_authors" name="book_authors" rel="popover" data-content="Enter the book's authors." data-original-title="Authors">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Publisher*</label> <!--honestly not essential-->
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_publisher" name="book_publisher" rel="popover" data-content="Enter the book's publisher." data-original-title="Publisher">
		</div>
		</div>
		
		<!--div class="form-group">
		<label class="control-label">Category</label>  
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_category" name="book_category" rel="popover" data-content="Select the book's category." data-original-title="Full Name">
		</div>
		</div-->
		
		<div class="form-group">
		<label class="control-label">Category*</label> 
		<div class="controls">
		<select name="category">
			<?php
			include('php/dbConnect.php');
     
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
		<option value="Computer">Computer</option>
		<option value="Law">Law</option>
		<option value="Mathematics">Mathematics</option>
		<option value="Science">Science</option>
		</select>
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Used in Subject: *</label> <!--change to combobox-->
		<p>Use Ctrl+Click to select multiple subjects
		<div class="controls">
		<!--input type="text" class="input-xlarge form-control pop" id="book_subject" name="book_subject" rel="popover" data-content="Enter the subjects where this book is used." data-original-title="Subjects"-->
		<select multiple name="book_subject[]">
		
			<?php
			
     
	 $queryString=/*"SELECT DISTINCT subjects FROM Book"; */"SELECT code FROM Subject";
	 $query=mysql_query($queryString);
	 if(mysql_num_rows($query) >= 1){ 
		
		while($row = mysql_fetch_array($query))
		{
			$subject=$row['code'];
		
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
		<label class="control-label">Copy Description*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_description" name="book_description" rel="popover" data-content="Enter a brief description of your copy of the book." data-original-title="Description">
		</div>
		</div>
		
	
		</fieldset>
		<fieldset>
		<legend style="margin-left: -15px">Selling Preferences</legend>
		
		<div class="form-group">
		<label class="control-label">Preferred Price*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="book_price" name="book_price" rel="popover" data-content="Set your asking price for this book." data-original-title="Book Price">
		 <div class="checkbox">
    <label>
      <input type="checkbox" name="negotiable"> Negotiable
      <br />
    </label>
  </div>
		</div>
		</div>
		
			<div class="form-group">
		<label class="control-label">Preferred Meetup Place*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="meetup_place"  name="meetup_place" rel="popover" data-content="Where do you want to meet your buyers?" data-original-title="Meetup Place">
		</div>
		</div>
		
			<!--div class="form-group">
		<label class="control-label" style="margin-left: 15px">Password</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control pop" id="user_password" style="margin-left: 15px" name="user_password" rel="popover" data-content="Enter a password." data-original-title="Password">
		</div>
		</div-->
	
			<div class="form-group">
			<label class="control-label"> Cover Picture (optional)</label>
			
			<div id="upload2" >
				<div class="col-lg-10 center" id="drop">
				Drop Cover Pic Here Or
				<a  class="btn btn-primary" >Browse</a>
				<!--input type="file" name="upl" /-->
			</div>
			<ul>
				<!-- The file uploads will be shown here -->
			</ul>
			</div>
			</div>
		
		<div class="form-group">
		<label class="control-label"></label>
		<div class="controls">
		<input type="submit" class="btn btn-success"  role="button" name = "submit" value = "Post Advertisement">
		<!--a type="submit" class="btn btn-success" href="userprofile.html" id="btn-submit">Post Advertisement</a-->
		
		</div>
		</div>
		</fieldset>
		</form>
		
			<form class="hidden" id="upload" method="post" action="upload.php" enctype="multipart/form-data">	
				<input type="file" id="upl" name="upl" />
		</form>
		
				
	</div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
	
		<script src="js/upload/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="js/upload/jquery.ui.widget.js"></script>
		<script src="js/upload/jquery.iframe-transport.js"></script>
		<script src="js/upload/jquery.fileupload.js"></script>
		<script>$(function () {
		$(".pop")
			.popover().blur(function () {
				$(this).popover('hide');
			});
		});</script>
		<script src="js/upload/script.js"></script>
		
	<script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	<script src="dist/js/bootstrap.js"></script>
	<script src="js/sellbook.js"></script>
	<script src="js/sellautofill.js"></script>


  
</body></html>