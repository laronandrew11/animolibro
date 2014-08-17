
	<!DOCTYPE html>
<html>
<?php
include_once('php/animolibroerrorhandler.php');
	include('head.php');
	session_start();
	//$_SESSION['upload_type']=0; //so upload.php knows that we are uploading a cover image for the book
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
	<?php
	if(extension_loaded('imagick')) {
    $imagick = new Imagick();
    print_r($imagick->queryFormats());
}
else {
    echo 'ImageMagick is not available.';
}
	?>
	<h1>Error Page</h1>
	<h2>Congratulations! You broke something.</h2>
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