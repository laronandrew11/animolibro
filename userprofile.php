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
          <a class="navbar-brand" href="#">Animo&#9734Libro</a>
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
			  if(/*$_SESSION["external_profile"]==*/ $_GET['user']!=$_SESSION['animolibrousername']){
		$username=$_GET['user'];
		$myprofile=false;
		echo '<li><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
		}
	else {$username= $_SESSION['animolibrousername'];
		echo '<li  class="active"><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
		$myprofile=true;
	}
	
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
	$profileIDquery="SELECT profile_pic_id FROM USERACCOUNT WHERE id=$userid";	
	//section for getting ads
	$profileIDsql=mysql_query($profileIDquery);
	$row2=mysql_fetch_array($profileIDsql);
	$profilepic_id=$row2['profile_pic_id'];
	$profilequery=mysql_query("SELECT href FROM Image WHERE id = $profilepic_id");
	if(!empty($profilequery)){
	if(mysql_num_rows($profilequery)==1)
	{
	$profile_row=mysql_fetch_array($profilequery);
	
	$profile_filename=$profile_row['href'];
	}
	else{
			$profile_filename="placeholder.gif";
	}
	}
	else{
			$profile_filename="placeholder.gif";
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
                        <img src="uploads/'.$profile_filename.'" alt="" class="img-rounded img-responsive" />
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
			$adid=$ad_row['id'];
			$bookid=$ad_row['Book_id'];
			$bookstat=$ad_row['status'];
			$bookquery=mysql_query("SELECT * from Book WHERE id = '$bookid'");
			$bookrow=mysql_fetch_array($bookquery);
			
			$booktitle=$bookrow['title'];
			$bookauthors=$bookrow['authors'];
			$coverpic_id=$bookrow['cover_pic_id'];
	$coverquery=mysql_query("SELECT href FROM Image WHERE id = $coverpic_id");
	if(!empty($coverquery)){
	if(mysql_num_rows($coverquery)==1)
	{
	$cover_row=mysql_fetch_array($coverquery);
	
	$cover_filename=$cover_row['href'];
	}
	else{
			$cover_filename="placeholder.gif";
	}
	}
	else{
			$cover_filename="placeholder.gif";
	}
			echo'<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
					echo $booktitle;
					echo'</h3>
				</div>
				<form action = "php/';
				if($myprofile==true)
				{
					echo 'confirmstat';
				}
				else
				{
					echo 'buybook';
				}
				echo '.php" method = "POST">
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$cover_filename.'" alt="" class="img-rounded img-responsive" />
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
					echo'<input type="hidden" name="adid" value="'.$adid.'">';
					echo'<input type="hidden" name="myprofile" value="'.$myprofile.'">';
					if($myprofile==true)
					{
						if($bookstat == 0)
						{
						echo '<button type="button" class="btn btn-primary disabled pull-right">No Buyer Yet</button>';
						}
						else if($bookstat == 1)
						{
						echo '<div class="btn-group">
								<button type="button" class="btn btn-primary pull-right dropdown-toggle" data-toggle="dropdown" value="Requested">';
								echo'<span class="caret"></span></button>
								<ul class="dropdown-menu" role="menu">
									<li><input class="btn btn-success" name="submit1" style="width: 100%; height: 100%;" type="submit" value="Accept"></input></li>
									<li class="divider"></li>
									<li><input class="btn btn-danger" name="submit1" style="width: 100%; height: 100%;" type="submit" value="Reject"></input></li>
								</ul>
							  </div>';
						}
						else if($bookstat == 2)
						{
							echo '<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
						}
						else if($bookstat == 3)
						{
							echo '<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>';
						}
					}
					else{
					echo'<input type="hidden" name="url" value="'.$_SERVER['REQUEST_URI'].'">';
						if($bookstat == 0 || $bookstat == 3)
					echo'<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">';
					else if($bookstat == 1)
					{
						echo'<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">';
					}
					}
				echo '</div>
				</form>
			</div>';
		}
	}
echo '</div>	
      <div class="col-lg-6">
			<h4>Looking for</h4>';
$lookquery="SELECT * FROM Ad WHERE buyer_id = $userid";
$sql3=mysql_query($lookquery);
if(mysql_num_rows($sql3) >= 1) {
	while($ad_row = mysql_fetch_array($sql3)) {
	$adid=$ad_row['id'];
	$bookid=$ad_row['Book_id'];
	$bookstat=$ad_row['status'];
	$bookquery=mysql_query("SELECT * from Book WHERE id = '$bookid'");
	$bookrow=mysql_fetch_array($bookquery);
	$booktitle=$bookrow['title'];
	$bookauthors=$bookrow['authors'];
	$coverpic_id=$bookrow['cover_pic_id'];
	$coverquery=mysql_query("SELECT href FROM Image WHERE id = $coverpic_id");
	if(!empty($coverquery)){
	if(mysql_num_rows($coverquery)==1)
	{
	$cover_row=mysql_fetch_array($coverquery);
	
	$cover_filename=$cover_row['href'];
	}
	else{
			$cover_filename="placeholder.gif";
	}
	}
	else{
			$cover_filename="placeholder.gif";
	}
	echo'<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
	echo $booktitle;
	echo '</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$cover_filename.'" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: ';
	echo $bookauthors;
	echo '<p>Condition: ';
	echo $ad_row['copy_condition'];
	echo '<p>Price: ';
	echo $ad_row['cost']; 
	if( $ad_row['negotiable'] ==1)
	{
		echo " (negotiable)";
	}
	else
	{
		echo " (non-negotiable)";
	}
	echo '<p>Meetup: ';
	echo $ad_row['meetup'];
	if($bookstat == 1)
	{
	echo '<button type="button" class="btn btn-primary disabled pull-right">Request Pending</button>';
	}
	else if($bookstat == 2)
	{
	echo '<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
	}
	else if($bookstat == 3)
	{
	echo '<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>';
	}
	echo'			</div>
			</div>
        ';
	}
	}
echo '

</div>
	
		<div class="row">
		<div class="col-lg-12">
	<!-- begin htmlcommentbox.com -->
 <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">Widget</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
 <script type="text/javascript" id="hcb"> /*<!--*/ if(!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=(hcb_user.PAGE || ""+window.location), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&mod=%241%24wq1rdBcg%24HvaXrhoLUlS7EjSFDgieF%2F"+"&opts=16862&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
<!-- end htmlcommentbox.com -->
		</div>	
		</div>
		
      </div>
	  
	 
	  ';
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
                        <img src="assets/bookprofile2small.jpg" alt="" class="img-rounded img-responsive" />
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
		<!-- </div>	
        <div class="col-lg-6">
			<h4>Looking for</h4>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Fundamentals of Web Design, 4th Edition</h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="assets/bookprofilesmall.jpg" alt="" class="img-rounded img-responsive" />
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
      </div> -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="js/userprofile.js"></script>
  </body>
</html>