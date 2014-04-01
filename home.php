<?php
	session_start();
	echo '<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="css/customized-components.css" rel="stylesheet">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>';
include ('navbar.php');
	
?>
	<script src ="home.php"></script>
	<div class="jumbotron">
	<h1>Sell a book</h1>
		<p>Done with your old textbooks? Let them continue to serve their purpose.</p>
		<p><a class="btn btn-primary btn-lg" role="button" href="sellbookpage.php">Sell a textbook</a></p>
	</div>
	<div class="jumbotron">
	<h1>Find a book</h1>
		<p>Need a textbook? Start your search here.</p>
		<p><div class="row">
        <div class="col-lg-4">
            <form name=search action="findbooks.php" method="post"  class="form-inline" >
                <input name="loc" class="span5" type="text"  placeholder="Find a textbook by title...">
                <button type="submit" name="submit0" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></button>
				 <!--a name = "submit0" type="submit" role="button" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></a-->
            </form>
        </div></p>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>