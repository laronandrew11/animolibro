<!DOCTYPE html>
<html>
<?php
include('php/animolibroerrorhandler.php');
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
		$email=$_GET['email'];
		$hash=$_GET['hash'];
	?>
	
      <!-- Main component for a primary marketing message or call to action -->
      <div class="container">
      <div class="row">
      <div class="col-lg-3 col-md-3">
        <form action="php/pwreset.php" class ="form-signin" role = "form" method = "post">
			<legend style="margin-left: -15px">Password Reset</legend>
			<?php
				echo '<input type="hidden" id="email" name="email" value="'.$email.'">';
				echo '<input type="hidden" id="hash" name="hash" value="'.$hash.'">';
			?>
			<div class="form-group">
				<label class="control-label" style="margin-left: -15px">New Password*</label>
			<div class="controls">
				<input type="password" style="margin-left: -15px" class="input-xlarge form-control" id="newpass" name="newpass" rel="popover" data-content="Enter your New Password." data-original-title="Email">
				<label class="control-label" style="margin-left: -15px">New Password (again)*</label>
			</div>
			<div class="controls">
				<input type="password" style="margin-left: -15px" class="input-xlarge form-control" id="newpassagain" name="newpassagain" rel="popover" data-content="Enter your New Password Again." data-original-title="Email">
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
  </body>
</html>