<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
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
            <li class="active"><a href="#">Home</a></li>
            <!--li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li-->
          </ul>
          <form action="php/verify.php" class="navbar-form navbar-right" role="form" method = "post">
            <div class="form-group">
              <input type="text" name="Email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="Password" placeholder="Password" class="form-control">
            </div>
            <!--button type="submit" class="btn btn-success">Sign in</button-->
			<input type="submit" class="btn btn-success" role="button" name = "submit" value = "Sign-in">
			<a role="button" href = "registerpage.php" class="btn btn-primary" role=>Register</a>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>