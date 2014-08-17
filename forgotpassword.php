<!DOCTYPE html>
<html>
<?php
include_once('php/animolibroerrorhandler.php');
include('head.php');
?>
  <body>

	<?php
	
	include('navbar_out.php');
	session_start();
	if(!empty($_SESSION['correctlogin']))
	{
		if($_SESSION['correctlogin']==true && $_SESSION['accountactivated']==false){
			echo'<div type="danger-alert" class="alert alert-danger" data-dismiss="alert" aria-hidden="true">
		Please activate your account via e-mail.
	</div>';
		}
		else if($_SESSION['correctlogin']==false)
		{
			echo'<div type="danger-alert" class="alert alert-danger" data-dismiss="alert" aria-hidden="true">
		Incorrect username or password.
	</div>';
		}
		}
		if($_SESSION['accountactivated']==true)
		{
		echo'<div type="danger-alert" class="alert alert-success" data-dismiss="alert" aria-hidden="true">
		Account activated. You may now log in.
	</div>';
		}
	?>
	
      <!-- Main component for a primary marketing message or call to action -->
      <div class="container">
      <div class="row">
      <div class="col-lg-3 col-md-3">
        <form action="php/pwrecovery.php" id="loginHere" class ="form-signin" role = "form" method = "post">
			<legend style="margin-left: -15px">Forgot Password</legend>
			<div class="form-group">
    <label class="control-label" style="margin-left: -15px">Email</label>
    <div class="controls">
    <input type="text" style="margin-left: -15px" class="input-xlarge form-control" id="user_email" name="user_email" rel="popover" data-content="Enter your Email Address." data-original-title="Email">
    </div>
    </div>
			<div class="form-group">
    <label class="control-label"></label>
    <div class="controls">
    <input type="submit" class="btn btn-success" style="margin-left: -15px" role="button" name = "submit" value = "Submit">
		</form>
	</div>
    </div>
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
		<script src="js/jquery.validate.js"></script>
	<script src="js/login.js"></script>
  </body>
</html>