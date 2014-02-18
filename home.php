<?php
	session_start();
	echo '<h1>WELCOME</h1>';
	echo '<div>';
	echo '<a href="userprofile.html">';
	echo '<span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></div>';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
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
          <a class="navbar-brand" href="#">AnimoLibro</a>
		  <script src ="home.php"></script>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
             <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
			<li><a href="sellbook.html">Sell</a></li>
			<li><a href="findbooks.html">Find</a></li>
			
          </ul>
         <ul class="nav navbar-nav navbar-right">
			  <!--<li><a href="userprofile.html"><span class="glyphicon glyphicon-user"></span>  Andrew Laron</a></li>-->
			  <li class="dropdown">
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
    </div>
	<div class="jumbotron">
	<h1>Sell a book</h1>
		<p>Done with your old textbooks? Let them continue to serve their purpose.</p>
		<p><a class="btn btn-primary btn-lg" role="button" href="sellbook.html">Sell a textbook</a></p>
	</div>
	<div class="jumbotron">
	<h1>Find a book</h1>
		<p>Need a textbook? Start your search here.</p>
		<p><div class="row">
        <div class="col-lg-4">
            <form method="get" action="/" class="form-inline" >
                <input name="loc" class="span5" type="text"  placeholder="Find a textbook by title...">
                <!--button type="submit" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></button-->
				 <a role="button" href="findbooks.html" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></a>
            </form>
        </div></p>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>