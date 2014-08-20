<?php
include_once('php/animolibroerrorhandler.php');
require_once('php/db_config.php');
session_start(); 
$_SESSION['upload_type'] = 1; //so upload.php knows that we are uploading a user profile pic
?>
<!doctype html>
<html>
<?php
include('head.php');
?>
  <body>
<link href="css/upload.css" rel="stylesheet" />
<?php
include('navbar_out.php');
?>
	<div class="container">
	
	<div class="row">
	<div class="col-sm-8 col-md-8">
	<!--div class="alert alert-success" id="success-alert">
		Registration successful!
	</div-->
				<legend style="margin-left: -15px">Registration</legend>

		<p style="margin-left: -15px"> <font size="2" color="red">Fields marked with * are required</font></p>
				
		
		<form action="php/register.php" class="form-horizontal" id="registerHere" method="post">
		
		
		
		<fieldset>

	
		
		<div class="form-group">
		<label class="control-label">Name*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="user_name" name="user_name" rel="popover" data-content="Enter your first and last name." data-original-title="Full Name">
		</div>
		</div>

		<div class="form-group">
		<label class="control-label">E-mail*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="user_email" name="user_email" rel="popover" data-content="What’s your email address?" data-original-title="Email">
		</div>
		</div>
		
		<!--sql currently requires course and contact no-->		
		<div class="form-group">
		<label class="control-label">Contact Number*</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="user_contactno" name="user_contactno" rel="popover" data-content="What’s your contact number?" data-original-title="Contact Number">
		</div>
		</div>
		
			<!--div class="form-group">
		<label class="control-label">Course (optional)</label> 
		<div class="controls">
		<input type="text" class="input-xlarge form-control pop" id="user_course" name="user_course" rel="popover" data-content="What’s your course?" data-original-title="Email">
		</div>
		</div-->
		
		<div class="form-group">
		<label class="control-label">Course*</label> 
		<div class="controls">
		<select name="course">
<?php
$db = database::getInstance();
$course_query = $db->dbh->prepare("SELECT * FROM course");

if($course_query->execute()) { 
	while($course_row = $course_query->fetch(PDO::FETCH_ASSOC)) {
		$course_id = $course_row['id'];
		$course_code = $course_row['code'];
		echo '<option value='.$course_id.'>'.$course_code.'</option>';
	}
}
?>
		</select>
		</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" >Profile Picture (optional)</label>
			<div id="upload2" >
				<div class="col-lg-10 center" id="drop">
				Drop Profile Pic Here Or
				<a  class="btn btn-primary" >Browse</a>
				<!--input type="file" name="upl" /-->
			</div>
			<ul>
				<!-- The file uploads will be shown here -->
			</ul>
			</div>
		</div>

		<div class="form-group">
		<label class="control-label">Password*</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control pop" id="user_password" name="user_password" rel="popover" data-content="Enter a password." data-original-title="Password">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Confirm Password*</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control pop" id="confirm_password" name="confirm_password" rel="popover" data-content="Re-enter your password." data-original-title="Confirm Password">
		</div>
		</div>
		
		
		
		<div class="form-group">
		<label class="control-label"></label>
		<div class="controls">
		<button type="submit" class="btn btn-success" name="submit">Create My Account</button>
		<!--a href="home.html" role="button" class="btn btn-success" id="btn-home">Create My Account</a-->
		</div>
		</div>

		</fieldset>
		
		</form>
		<!--/form-->
		
			<form class="hidden" id="upload" method="post" action="upload.php" enctype="multipart/form-data">
				<input type="file" id="upl" name="upl" />
		</form>
	</div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstraps JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
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
	<!--script src="js/dropdown.js"></script-->
	<script src="js/jquery.validate.js"></script>
	<script src="js/register.js"></script>
	
  
</body></html>