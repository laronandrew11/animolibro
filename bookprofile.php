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
<link href="css/customized-components.css" rel="stylesheet">
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>';
	echo '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">AnimoLibro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
             <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
			<li><a href="sellbookpage.php">Sell</a></li>
			<li><a href="findbooks.php">Find</a></li>
          </ul>
         <ul class="nav navbar-nav navbar-right">
			  <!--<li><a href="userprofile.html"><span class="glyphicon glyphicon-user"></span>  Andrew Laron</a></li>-->';
	echo '<li><a href="userprofile.php"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></li>';
	echo '<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
				  <li><a href="php/logout.php">Log-out</a></li>
				  <li class="divider"></li>
				  <li><a href="#"></a></li>
				</ul>
			  </li>
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>';
	
    $dbHost = "localhost";        //Location Of Database usually its localhost 
    $dbUser = "root";            //Database User Name 
    $dbPass = "";            //Database Password 
    $dbDatabase = "animolibrosimple";    //Database Name 
     
    $db = mysql_connect($dbHost,$dbUser,$dbPass)or die("Error connecting to database."); 
    //Connect to the databasse 
    mysql_select_db($dbDatabase, $db)or die("Couldn't select the database."); 
    //Selects the database 
     
    /* 
    The Above code can be in a different file, then you can place include'filename.php'; instead. 
    */ 

	//TODO: display relevant book info
	$bookid=$_GET['bookid'];
    $title = $_GET['title']; 
    $isbn = $_GET['isbn']; 
	 $authors = $_GET['authors'];  
	  $subject = $_GET['subject']; 
	 $category = $_GET['category']; 
	  $publisher = $_GET['publisher']; 
	  $numcopies = $_GET['numcopies'];
	
	$query1 ="SELECT * FROM Ad  
        WHERE Book_id= $bookid";
		
	//section for getting ads
	$sql1 = mysql_query($query1);
	
	

	
	
	
	
	echo'<div class="container">
    <div class="row">
	<!--div class="alert alert-success" id="success-alert"-->
	<!--Reservation successful!-->
	</div>
        <div class="col-xs-12 col-sm-6 col-md-6 center">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="assets/bookcover.jpg" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>';
						echo $title;
                            echo'</h4>
                        <small><cite title="ISBN"><i class="glyphicon glyphicon-barcode">
                        </i> ISBN ';
						echo $isbn;
						echo'</cite></small><br>
						

                        <p>
                            <i class="glyphicon glyphicon-briefcase"></i>';
							echo $publisher;
                            echo'<br />
							<i class="glyphicon glyphicon-folder-close"></i> ';
							echo $category;
                            echo'<br />
							<i class="glyphicon glyphicon-pencil"></i>';
							echo $authors;
                            echo'<br />
							<i class="glyphicon glyphicon-info-sign"></i> ';
							echo $numcopies;
							echo ' copies available
                            <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
	
	echo '<div class="row">
        <div class="col-lg-4 center">
			<h4>Sellers</h4>';
	if(mysql_num_rows($sql1) >= 1){ 

		while($ad_row = mysql_fetch_array($sql1))
		{
			//echo $row['title'] . " " . $row['LastName'];
			// "<br>";
			$adid=$ad_row['id'];
			$status=$ad_row['status'];
			$condition=$ad_row['copy_condition'];
			$sellerid=$ad_row['seller_id'];
			$sellerquery=mysql_query("SELECT * from UserAccount WHERE id = '$sellerid'");
			$seller_row=mysql_fetch_array($sellerquery);
			$sellername=$seller_row['username'];
			//$bookauthors=$bookrow['authors'];
			
				echo'<form action = "php/buybook.php" method = "POST">
				<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
					echo $sellername; 
					echo'<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star-empty"></i></h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/profilepicsmall.png" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Condition: ';
					echo $condition;					
					echo '<p>Price: Php ';
					echo $ad_row['cost']; 
					if( $ad_row['negotiable'] ==1)
					{
					echo " (negotiable)";
					}
					else{
					echo " (non-negotiable)";
					}
					echo'<p>Meetup: ';
					echo $ad_row['meetup'];
					echo'<input type="hidden" name="adid" value="';
					echo $adid;
					echo'">';
					echo'<input type="hidden" name="url" value="';
					echo $_SERVER['REQUEST_URI'];
					echo'">';
					if($status == 0)
					echo'<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">';
					else
					{
						echo'<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">';
					}
				echo '</form>
				</div>
			</div>';
			
		}
	}
	
	
	?>


<!--div class="row">
        <div class="col-lg-4 center">
			<h4>Sellers</h4>
         <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Andrew Laron 
					<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star-empty"></i></h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/profilepicsmall.png" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Condition: Good
					<p>Price: Php 450.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-primary pull-right buy-btn" id="btn-submit1">Buy</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Charles Malcaba 
					<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star-empty"></i>
							<i class="glyphicon glyphicon-star-empty"></i></h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Condition: Excellent
					<p>Price: Php 13.37 (non-negotiable)
					<p>Meetup: Mutien Marie Second Floor
					<button type="button" class="btn btn-primary pull-right buy-btn" id="btn-submit2">Buy</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Ronald Lim 
					<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star-empty"></i>
							<i class="glyphicon glyphicon-star-empty"></i></h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Condition: Good
					<p>Price: Php 400.00 (negotiable)
					<p>Meetup: Razon Second Floor
					<button type="button" class="btn btn-primary pull-right buy-btn" id="btn-submit">Buy</button>
				</div>
			</div-->

       

      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="js/bookprofile.js"></script>
  </body>
</html>