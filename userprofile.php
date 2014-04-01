<?php
	session_start();
	echo '<!DOCTYPE html>
<html>';
include ('head.php');
  echo'<body>';
	include('navbar.php');
			  if(/*$_SESSION["external_profile"]==*/ $_GET['user']!=$_SESSION['animolibrousername']){
		$username=$_GET['user'];
		$myprofile=false;
		//echo '<li><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
		}
	else {$username= $_SESSION['animolibrousername'];
		//echo '<li  class="active"><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
		$myprofile=true;
	}
	
	include('php/dbConnect.php');
	
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
	$adquery="SELECT * FROM Ad WHERE seller_id = $userid ORDER BY status=2,status=1";
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
                        <!--small><cite title="Location"><i class="glyphicon glyphicon-map-marker">
                        </i> Quezon City </cite></small><br-->
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
							<script type="text/javascript" src="http://SetRating.com/SetRating.js"></script><script type="text/javascript">SetRatingWidget("star")</script>
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
			$description=$ad_row['description'];
			$buyerid=$ad_row['buyer_id'];
			$buyerquery=mysql_query("SELECT * from UserAccount WHERE id = '$buyerid'");
			$buyerrow=mysql_fetch_array($buyerquery);
			$buyername=$buyerrow['username'];
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
				</div>';
				
				if($myprofile==true)
				{
					echo'<form action = "php/';
					echo 'confirmstat';
				}
				else
				{
					echo'<form onsubmit="return confirm(\'Request to buy this book?\');" action = "php/';
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
					echo '<p>Copy Description: '.$description;
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
						echo '<p>Buyer: ';
						echo $buyername;
						echo'
								<div class="btn-group pull-right">
								<button type="button"  class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Request Pending';
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
							echo '<p>Buyer: ';
							echo $buyername;
							echo '<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
						}
						else if($bookstat == 3)
						{
							echo '<p>Buyer: ';
							echo $buyername;
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
	$description=$ad_row['description'];
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
	echo '<p>Copy Description: '.$description;
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

	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="js/userprofile.js"></script>
	<script src="js/stars.js"></script>
  </body>
</html>