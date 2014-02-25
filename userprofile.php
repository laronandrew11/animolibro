<?php
	session_start();
	echo '<!DOCTYPE html>
<html>
  <head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
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
	echo '<li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></li>';
	echo '<li class="dropdown">
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
    </div>';
	
	
	$username= $_SESSION['animolibrousername'];
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
	
	//query to get current user's info
	$query ="SELECT * FROM UserAccount  
        WHERE username = '$username'";
	$sql = mysql_query($query);
	 if(mysql_num_rows($sql) == 1){ 
		$row = mysql_fetch_array($sql);
		$userid=$row['id'];
		$coursequery = mysql_query("SELECT code from Course WHERE id='$row[Course_id]'");
		$courserow=mysql_fetch_array($coursequery);
		$course=$courserow['code'];

		}
	
	//query to get current user's ads
	$adquery="SELECT * FROM Ad WHERE seller_id = $userid";
	$sql2=mysql_query($adquery);
	 
	//display user profile box: username, location, course, email, contactno
	echo 	'<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 center">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="assets/profilepic.png" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>';
                            echo $row['username'];
							echo'</h4>
                        <small><cite title="Location"><i class="glyphicon glyphicon-map-marker">
                        </i> Quezon City </cite></small><br>
						<small><cite title=" Course"><i class="glyphicon glyphicon-book">
                        </i>';
						echo $course;
						echo'</cite></small>
                        <p>
                            <i class="glyphicon glyphicon-envelope"></i>';
						echo $row['email'];
                            echo'<br />
							<i class="glyphicon glyphicon-earphone"></i>';
							echo $row['contactnumber'];
                            echo'<br />
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star-empty"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
echo'<div class="row">
	<div class="col-lg-8 center">
        <div class="col-lg-6">
			<h4>Selling</h4>';
//display ads
if(mysql_num_rows($sql2) >= 1){ 

		while($ad_row = mysql_fetch_array($sql2))
		{
			//echo $row['title'] . " " . $row['LastName'];
			// "<br>";
			$bookid=$ad_row['Book_id'];
			$bookquery=mysql_query("SELECT * from Book WHERE id = '$bookid'");
			$bookrow=mysql_fetch_array($bookquery);
			$booktitle=$bookrow['title'];
			$bookauthors=$bookrow['authors'];
			echo'<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
					echo $booktitle;
					echo'</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: ';
					echo $bookauthors;
					echo'<p>Condition: ';
					echo $ad_row['copy_condition'];
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
					echo '<button type="button" class="btn btn-primary disabled pull-right">No Buyer Yet</button>
				
				</div>
			</div>';
		}
	}
	
?>

 <!--div class="row">
	<div class="col-lg-8 center">
        <div class="col-lg-6">
			<h4>Selling</h4-->
          <!--div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Human-Computer Interaction</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: J. Lennon, P. McCartney
					<p>Condition: Good
					<p>Price: Php 350 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-primary disabled pull-right">No Buyer Yet</button>
				
				</div>
			</div>

        <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">This Book Is Full of Spiders</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookcover2small.jpg" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: D. Wong
					<p>Condition: Good
					<p>Price: Php 450.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
						<button type="button" class="btn btn-warning pull-right accept-btn">Accept Buyer</button>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: Bob
					<p>Condition: Good
					<p>Price: Php 450.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-warning pull-right accept-btn">Accept Buyer</button>
				</div>
			</div-->
		</div>	
        <div class="col-lg-6">
			<h4>Looking for</h4>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookcoversmall.jpg" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: Bob
					<p>Condition: Good
					<p>Price: Php 350.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-primary disabled pull-right">Request Pending</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: Bob
					<p>Condition: Good
					<p>Price: Php 350.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/95x125" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: Bob
					<p>Condition: Good
					<p>Price: Php 350.00 (negotiable)
					<p>Meetup: Gokongwei Lobby
					<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>
				</div>
			</div>
        </div>
		</div>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="js/userprofile.js"></script>
  </body>
</html>