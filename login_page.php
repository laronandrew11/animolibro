<!DOCTYPE html>
<html>
  <head>
    <title>Sign in to AnimoLibro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<link href="css/customized-components.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
            <li><a href="portal.php">Home</a></li>
            <!--li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	<?php
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
        <form action="php/verify.php" class ="form-signin" role = "form" method = "post">
			<legend style="margin-left: -15px">Sign In to AnimoLibro</legend>
			<div class="form-group">
    <label class="control-label" style="margin-left: -15px">Email</label>
    <div class="controls">
    <input type="text" style="margin-left: -15px" class="input-xlarge form-control" id="email" name="email" rel="popover" data-content="Enter your Email Address." data-original-title="Email">
    </div>
    </div>
			<div class="form-group">
    <label class="control-label" style="margin-left: -15px">Password</label>
    <div class="controls">
    <input type="text" style="margin-left: -15px" class="input-xlarge form-control" id="password" name="password" rel="popover" data-content="Enter your Password." data-original-title="Password">
    </div>
    </div>
			<div class="form-group">
    <label class="control-label"></label>
    <div class="controls">
    <input type="submit" class="btn btn-success" style="margin-left: -15px" role="button" name = "submit" value = "Sign In">
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