<?php
include_once('php/animolibroerrorhandler.php');
require_once('php/db_config.php');
session_start();

echo '<!DOCTYPE html>

<html>';
include ('head.php');
echo'<body>';
include('navbar.php');

if (isset($_POST['user']) && $_POST['user'] != $_SESSION['animolibrousername']) {
	$username = $_POST['user'];
	$myprofile = false;
}
else {
	$username = $_SESSION['animolibrousername'];
	$myprofile = true;
}


$db = database::getInstance(); 

//query to get current user's info
$user_query = $db->dbh->prepare("SELECT * FROM UserAccount WHERE username = :username");
$user_query->bindParam(':username', $username);

if ($user_query->execute()) {
	$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
	$user_id = $user_row['id'];
	$user_course_id = $user_row['Course_id'];
	$course_query = $db->dbh->prepare("SELECT code from Course WHERE id = :courseid");
	$course_query->bindParam(':courseid', $user_course_id);
	
	if ($course_query->execute()) {
		$course_row = $course_query->fetch(PDO::FETCH_ASSOC);
		$course = $course_row['code'];
	}
}

//section for getting profile picture
$profile_pic_id_query = $db->dbh->prepare("SELECT profile_pic_id FROM USERACCOUNT WHERE id = :userid");
$profile_pic_id_query->bindParam(':userid', $user_id);

if ($profile_pic_id_query->execute()) {
	$profile_pic_id_row = $profile_pic_id_query->fetch(PDO::FETCH_ASSOC);
	$profile_pic_id = $profile_pic_id_row['profile_pic_id'];

	$profile_pic_query = $db->dbh->prepare("SELECT href FROM Image WHERE id = :profilepic_id");
	$profile_pic_query->bindParam(':profilepic_id', $profile_pic_id);
	$has_profile_pic = $profile_pic_query->execute();

	if ($has_profile_pic) {
		$profile_pic_row = $profile_pic_query->fetch(PDO::FETCH_ASSOC);
		$profile_pic_filepath = $profile_pic_row['href'];
		if (empty($profile_pic_filepath)) {
			$has_profile_pic = false;
		}
	}

	if (!$has_profile_pic) {
		$profile_pic_filepath = "placeholder.gif";
	}
}
 
//display user profile box: username, location, course, email, contactno
echo '<div class="container">
	<div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 center">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$profile_pic_filepath.'" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>';
                            echo $username;
							echo'</h4>
                        <!--small><cite title="Location"><i class="glyphicon glyphicon-map-marker">
                        </i> Quezon City </cite></small><br-->
						<small><cite title=" Course"><i class="glyphicon glyphicon-book">
                        </i>&nbsp;';
						echo $course;
						echo'</cite></small>
                        <p>
                            <i class="glyphicon glyphicon-envelope"></i>&nbsp;';
						echo $user_row['email'];
                            echo'<br />
							<i class="glyphicon glyphicon-earphone"></i>&nbsp;';
							echo $user_row['contactnumber'];
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
	
//query to get current user's ads
$ad_query = $db->dbh->prepare("SELECT * FROM Ad WHERE seller_id = :userid ORDER BY status=2,status=1");
$ad_query->bindParam(':userid', $user_id);
$has_ads = $ad_query->execute();
if ($has_ads) {
	$has_ads = false;
	// SHOW USER'S ADS
	while ($ad_row = $ad_query->fetch(PDO::FETCH_ASSOC)) {
		$has_ads = true;
		
		// GET ADVERTISEMENT DATA
		$ad_id = $ad_row['id'];
		$book_id = $ad_row['Book_id'];
		$book_status = $ad_row['status'];
		$description = $ad_row['description'];
		$buyer_id = $ad_row['buyer_id'];

		// GET BUYER DATA
		$buyer_query = $db->dbh->prepare("SELECT * from UserAccount WHERE id = :buyerid");
		$buyer_query->bindParam(':buyerid', $buyer_id);
		if ($buyer_query->execute()) {
			$buyer_row = $buyer_query->fetch(PDO::FETCH_ASSOC);
			$buyer_name = $buyer_row['username'];
		}
		
		// GET BOOK DATA
		$book_query = $db->dbh->prepare("SELECT * from Book WHERE id = :bookid");
		$book_query->bindParam(':bookid', $book_id);
		if ($book_query->execute()) {
			$book_row = $book_query->fetch(PDO::FETCH_ASSOC);

			$book_title = $book_row['title'];
			$book_authors = $book_row['authors'];
			$cover_pic_id = $book_row['cover_pic_id'];
			
			// GET COVER PICTURE
			$cover_pic_query = $db->dbh->prepare("SELECT href FROM Image WHERE id = :cover_pic_id");
			$cover_pic_query->bindParam(':cover_pic_id', $cover_pic_id);
			$has_cover_pic = $cover_pic_query->execute();

			if ($has_cover_pic) {
				$cover_pic_row = $cover_pic_query->fetch(PDO::FETCH_ASSOC);
				$cover_pic_filepath = $cover_pic_row['href'];
				if (empty($cover_pic_filepath)) {
					$has_cover_pic = false;
				}
			}
			
			if (!$has_cover_pic) {
				$cover_pic_filepath = "placeholder.gif";
			}
		}
		if($myprofile==true ||$book_status==0||book_status==3||$buyer_name==$_SESSION['animolibrousername'])
		{
		// START DISPLAY AD
		echo '<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
					echo $book_title;
					echo'</h3>
				</div>';
				
		if ($myprofile==true) {
			echo'<form action = "php/';
			echo 'confirmstat';
		}
		else {
			echo'<form onsubmit="return confirm(\'Request to buy this book?\');" action = "php/';
			echo 'buybook';
		}
		echo '.php" method = "POST">
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$cover_pic_filepath.'" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Author: ';
					echo $book_authors;
					echo'<p>Condition: ';
					echo $ad_row['copy_condition'];
					echo '<p>Price: Php ';
					echo $ad_row['cost'];

		if ($ad_row['negotiable'] == 1) {
			echo " (negotiable)";
		}
		else {
			echo " (non-negotiable)";
		}
		echo'<p>Meetup: ';
		echo $ad_row['meetup'];
		echo '<p>Copy Description: '.$description;
		echo'<input type="hidden" name="adid" value="'.$ad_id.'">';
		echo'<input type="hidden" name="myprofile" value="'.$myprofile.'">';
		if ($myprofile==true) {
			if ($book_status == 0) {
				echo '<button type="button" class="btn btn-primary disabled pull-right">No Buyer Yet</button>';
			}
			else if ($book_status == 1) {
				echo '<p>Buyer: ';
				echo $buyer_name;
				echo '
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
			else if ($book_status == 2) {
				echo '<p>Buyer: ';
				echo $buyer_name;
				echo '<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
			}
			else if ($book_status == 3) {
				echo '<p>Buyer: ';
				echo $buyer_name;
				echo '<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>';
			}
		}
		else {
			echo'<input type="hidden" name="url" value="'.$_SERVER['REQUEST_URI'].'">';
			if ($book_status == 0 || $book_status == 3)
				echo'<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">';
			else if ($book_status == 1) {
				echo'<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">';
			}
		}
		echo '</div>
				</form>
			</div>';
		// END DISPLAY AD
		}
	}
}
if (!$has_ads) {
	echo '<p>Not selling any books.';
	if ($myprofile == true) {
		echo ' <a href="sellbookpage.php">Sell a book?</a>';
	}
	echo '</p>';
}
echo '</div>	
      <div class="col-lg-6">
			<h4>Looking for</h4>';

// SHOW LOOKING FOR
$looking_for_query = $db->dbh->prepare("SELECT * FROM Ad WHERE buyer_id = :user_id");
$looking_for_query->bindParam(':user_id', $user_id);
$has_looking_for_ads = $looking_for_query->execute();

if ($has_looking_for_ads) {
	$has_looking_for_ads = false;
	while ($lf_ad_row = $looking_for_query->fetch(PDO::FETCH_ASSOC)) {
		$has_looking_for_ads = true;

		// GET AD DATA
		$lf_ad_id = $lf_ad_row['id'];
		$lf_book_id = $lf_ad_row['Book_id'];
		$lf_book_status = $lf_ad_row['status'];

		// GET BOOK DATA
		$lf_book_query = $db->dbh->prepare("SELECT * from Book WHERE id = :book_id");
		$lf_book_query->bindParam(':book_id', $lf_book_id);

		if ($lf_book_query->execute()) {
			$lf_book_row = $lf_book_query->fetch(PDO::FETCH_ASSOC);
			$lf_book_title = $lf_book_row['title'];
			$lf_book_authors = $lf_book_row['authors'];
			$lf_description = $lf_ad_row['description'];
			$lf_cover_pic_id = $lf_book_row['cover_pic_id'];
			
			// GET COVER PICTURE
			$lf_cover_pic_query = $db->dbh->prepare("SELECT href FROM Image WHERE id = :cover_pic_id");
			$lf_cover_pic_query->bindParam(':cover_pic_id', $lf_cover_pic_id);
			$has_lf_cover_pic = $lf_cover_pic_query->execute();

			if ($has_lf_cover_pic) {
				$lf_cover_pic_row = $lf_cover_pic_query->fetch(PDO::FETCH_ASSOC);
				$lf_cover_pic_filepath = $lf_cover_pic_row['href'];
				if (empty($lf_cover_pic_filepath)) {
					$has_lf_cover_pic = false;
				}
			}
			
			if (!$has_lf_cover_pic) {
				$lf_cover_pic_filepath = "placeholder.gif";
			}
		}

		// START DISPLAY 'LOOKING FOR' ADS
		if($lf_book_status==0||$lf_book_status==3||$myprofile==true)
		{
			echo '<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">';
			echo $lf_book_title;
			echo '</h3>
					</div>
					<div class="panel-body">
						<div class="col-sm-6 col-md-4">
							<img src="uploads/'.$lf_cover_pic_filepath.'" alt="" class="img-rounded img-responsive" />
						</div>
						<p>Author: ';
			echo $lf_book_authors;
			echo '<p>Condition: ';
			echo $lf_ad_row['copy_condition'];
			echo '<p>Price: ';
			echo $lf_ad_row['cost']; 
			if ( $lf_ad_row['negotiable'] ==1) {
				echo " (negotiable)";
			}
			else {
				echo " (non-negotiable)";
			}
			echo '<p>Meetup: ';
			echo $lf_ad_row['meetup'];
			echo '<p>Copy Description: '.$lf_description;
			if($myprofile==true)
			{
				if ($lf_book_status == 1) {
					echo '<button type="button" class="btn btn-primary disabled pull-right">Request Pending</button>';
				}
				else if ($lf_book_status == 2) {
					echo '<button type="button" class="btn btn-success disabled pull-right">Request Accepted</button>';
				}
				else if ($lf_book_status == 3) {
					echo '<button type="button" class="btn btn-danger disabled pull-right">Request Rejected</button>';
				}
			}
		
			echo '</div>
				</div>';
			// END DISPLAY 'LOOKING FOR' ADS
		}
		
	}
}
if (!$has_looking_for_ads) {
	echo '<p>Not requesting for any books.';
	if ($myprofile == true) {
		echo ' <a href="findbooks.php">Look for a book?</a>';
	}
	echo '</p>';
}
echo '

</div>
	
		<div class="row">
		<div class="col-lg-12">
	<!-- begin htmlcommentbox.com -->
 <div id="HCB_comment_box"><a href="http://www.htmlcommentbox.com">Widget</a> is loading comments...</div>
 <link rel="stylesheet" type="text/css" href="//www.htmlcommentbox.com/static/skins/bootstrap/twitter-bootstrap.css?v=0" />
 <script type="text/javascript" id="hcb"> /*<!--*/ if (!window.hcb_user){hcb_user={};} (function(){var s=document.createElement("script"), l=(hcb_user.PAGE || ""+window.location), h="//www.htmlcommentbox.com";s.setAttribute("type","text/javascript");s.setAttribute("src", h+"/jread?page="+encodeURIComponent(l).replace("+","%2B")+"&mod=%241%24wq1rdBcg%24HvaXrhoLUlS7EjSFDgieF%2F"+"&opts=16862&num=10");if (typeof s!="undefined") document.getElementsByTagName("head")[0].appendChild(s);})(); /*-->*/ </script>
<!-- end htmlcommentbox.com -->
		</div>	
		</div>
		
      </div>
	  
	 
	  ';
?>

 
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