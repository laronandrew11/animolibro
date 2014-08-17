<!DOCTYPE html>
<html>
<?php
include('php/animolibroerrorhandler.php');
  include('head.php');
  ?>
  <body>
<?php
	include('navbar_out.php');
?>
	<div class="container">
	
	<?php
	session_start();
	if(!empty($_SESSION['confirmationsent']))
	{
		if($_SESSION['confirmationsent']==true)
		{
			echo '<div class="alert alert-success" id="success-alert">Your confirmation link has been sent to your e-mail address.</div>';
		}
		else{
			echo '<div class="alert alert-danger" id="failure-alert">Cannot send confirmation link to your e-mail address.</div>';
		}
	}
	if(!empty($_SESSION['pwchange']))
	{
		if($_SESSION['pwchange']==true)
		{
			echo '<div class="alert alert-success" id="success-alert">Your password has been changed.</div>';
		}
		else{
			echo '<div class="alert alert-danger" id="failure-alert">Cannot change password.</div>';
		}
	}
	?>
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Buy and sell used textbooks in a few clicks.</h1>
        <p>AnimoLibro is a platform for De La Salle University students to buy, sell or lend used books.</p>
        <p>Joining is easy.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="registerpage.php" role="button">Register now &raquo;</a>
        </p>
      </div>

    </div>
	 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>