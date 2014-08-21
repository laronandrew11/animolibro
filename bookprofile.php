<!DOCTYPE html>
<html>

<?php
include_once('php/animolibroerrorhandler.php');
include('head.php');
require_once("php/db_config.php");
session_start();
echo'<body>';
include('navbar.php');

$db = database::getInstance(); 

//TODO: display relevant book info
$bookid=$_POST['bookid'];
$title = $_POST['title']; 
$isbn = $_POST['isbn']; 
$authors = $_POST['authors']; 
$category = $_POST['category']; 
$publisher = $_POST['publisher']; 
$numcopies = $_POST['numcopies'];
$sellerid = $_SESSION['animolibroid'];
//$query1 ="SELECT * FROM Ad WHERE Book_id= $bookid AND seller_id != $sellerid ORDER BY status=2,status=1";
//$query2="SELECT cover_pic_id FROM Book WHERE id=$bookid";	

$found = 0;

$query1 = $db->dbh->prepare("SELECT * FROM Ad WHERE Book_id= :bookid AND seller_id != :sellerid ORDER BY status=2,status=1");
$query1->bindParam(':bookid', $bookid);
$query1->bindParam(':sellerid', $sellerid);

$query2 = $db->dbh->prepare("SELECT cover_pic_id FROM Book WHERE id=:bookid");
$query2->bindParam(':bookid', $bookid);

//section for getting ads
$query2->execute();
$row2 = $query2->fetch(PDO::FETCH_ASSOC);
$coverpic_id = $row2['cover_pic_id'];

$coverquery = $db->dbh->prepare("SELECT href FROM Image WHERE id = :coverpic_id");
$coverquery->bindParam(':coverpic_id', $coverpic_id);
$coverquery->execute();

if(count($coverquery->fetchAll()) != 0) {
	if(count($coverquery->fetchAll())==1) {
		$cover_row=$coverquery->fetch(PDO::FETCH_ASSOC);
		$cover_filename=$cover_row['href'];
	}
	else {
			$cover_filename="placeholder.gif";
	}
}
else{
	$cover_filename="placeholder.gif";
}

	
echo'<div class="container">
    <div class="row">
	<!--div class="alert alert-success" id="success-alert"-->
	<!--Reservation successful!-->
	</div>
        <div class="col-xs-12 col-sm-6 col-md-6 center">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$cover_filename.'" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>';
echo $title;
echo'</h4>
                        <small><cite title="ISBN">
                        <i class="glyphicon glyphicon-barcode"></i>&nbsp; ISBN ';
echo $isbn;
echo'</cite></small><br>
                        <p>
                            <i class="glyphicon glyphicon-briefcase"></i>&nbsp;';
echo $publisher;
echo'<br />
							<i class="glyphicon glyphicon-folder-close"></i>&nbsp;';
echo $category;
echo'<br />
							<i class="glyphicon glyphicon-pencil"></i>&nbsp;';
echo $authors;
echo'<br />';

//$subjectbookquery="SELECT DISTINCT Subject_id FROM Subject_uses_Book WHERE Book_id = $bookid";
$subjectbookquery = $db->dbh->prepare("SELECT DISTINCT Subject_id FROM Subject_uses_Book WHERE Book_id = :bookid");
$subjectbookquery->bindParam(':bookid', $bookid);
$subjectbookquery->execute();

//$subjectbooks= mysql_query($subjectbookquery);
while($subjectbookrow = $subjectbookquery->fetch(PDO::FETCH_ASSOC)) {
	$subjectID = $subjectbookrow['Subject_id'];
//	$subjectquery=mysql_query("SELECT code from Subject WHERE id = $subjectID");
	$subjectquery = $db->dbh->prepare("SELECT code from Subject WHERE id = :subjectID");
	$subjectquery->bindParam(':subjectID', $subjectID);
	$subjectquery->execute();
	while($subjectrow=$subjectquery->fetch(PDO::FETCH_ASSOC)) {
		echo '<i class="glyphicon glyphicon-book"></i>&nbsp;' .$subjectrow['code'].'<br>';
	}	
}
echo'<i class="glyphicon glyphicon-info-sign"></i> ';
echo $numcopies;
echo ' copies available<br />';
//echo'Used in subjects: <br>';

echo'</div>
                </div>
            </div>
        </div>
    </div>
	</div>';
	
echo '<div class="row">
		<div class="col-lg-8 center">
			<h4>Sellers</h4>';
if ($query1->execute()) { 
	while ($ad_row = $query1->fetch(PDO::FETCH_ASSOC)) {
		$found++;
		//echo $row['title'] . " " . $row['LastName'];
		// "<br>";
		$description=$ad_row['description'];
		$adid=$ad_row['id'];
		$status=$ad_row['status'];
		$condition=$ad_row['copy_condition'];
		$sellerid=$ad_row['seller_id'];
		$buyerid=$ad_row['buyer_id'];
		
		//get buyer info
		$buyer_query = $db->dbh->prepare("SELECT * from UserAccount WHERE id = :buyerid");
		$buyer_query->bindParam(':buyerid', $buyer_id);
		if ($buyer_query->execute()) {
			$buyer_row = $buyer_query->fetch(PDO::FETCH_ASSOC);
			$buyer_name = $buyer_row['username'];
		}
		
		
	//	$sellerquery=mysql_query("SELECT * from UserAccount WHERE id = '$sellerid'");
	//	$seller_row=mysql_fetch_array($sellerquery);
		if($status==0||$status==3||$buyer_name==$_SESSION['animolibrousername'])
		{
		$sellerquery=$db->dbh->prepare("SELECT * from UserAccount WHERE id = :sellerid");
		$sellerquery->execute(array(':sellerid'=>$sellerid));

		$seller_row=$sellerquery->fetch(PDO::FETCH_ASSOC);
		$sellername=$seller_row['username'];
		
		$profilepic_id=$seller_row['profile_pic_id'];

		//$profilequery=mysql_query("SELECT href FROM Image WHERE id = $profilepic_id");
		
		$profilequery=$db->dbh->prepare("SELECT href FROM Image WHERE id = :profilepic_id");
		$profilequery->bindParam(':profilepic_id', $profilepic_id);
		$profilequery->execute();

		if(count($profilequery->fetchAll()) != 0) {
			if(count($profilequery->fetchAll()) == 1) {
				$profile_row=$profilequery->fetch(PDO::FETCH_ASSOC);
				$profile_filename=$profile_row['href'];
			}
			else {
				$profile_filename="placeholder.gif";
			}
		}
		else{
			$profile_filename="placeholder.gif";
		}
			
		//$bookauthors=$bookrow['authors'];
		if($status != 2) {
			echo'<form id="buyform" onsubmit="return confirm(\'Request to buy this book?\');" action = "php/buybook.php" method = "POST">
				<div class="col-lg-6 col-md-6"><div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">';
			echo $sellername; 
			$split=explode(" ", $sellername);
			echo'<iframe src="http://www.setrating.com/widget.php?ref=http%3A%2F%2Flocalhost%2Fanimolibro%2Fuserprofile.php%3Fuser%3D';
			foreach($split as $value){
				echo $value;
				if(end($split)!=$value)
					echo '%2520';
			}
			echo '&amp;type=star" allowtransparency="true" frameborder="0" border="0" framebackground="none" scrolling="no" style="width:89px; padding:0; height:16px; margin:0px; background:none; align:right;"></iframe></i></h3>
				</div>
				<div class="panel-body">
					<div class="col-sm-6 col-md-4">
                        <img src="uploads/'.$profile_filename.'" alt="" class="img-rounded img-responsive" />
                    </div>
					<p>Condition: ';
			echo $condition;					
			echo '<p>Price: Php ';
			echo $ad_row['cost']; 
			if ($ad_row['negotiable'] ==1) {
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
			echo '<p>Copy Description: '.$description;
		
						
			echo'<input type="hidden" name="url" value="'.$_SERVER['REQUEST_URI'].'">';
			
			
			
			
			if($status == 0 || $status == 3)
				echo'<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">';
			else
				if($status == 1) {
					echo'<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">';
				}
			echo '</form>
				<form action="userprofile.php"  id="viewSeller" method="post">
						<input type="text" class="hidden" id="user" name="user" value="'.$sellername.'"/>
						
						<button type="submit" class="btn" color="#00f" name="viewsellerbutton">View Seller Profile</button>
						</form>
				</div>
				</div></div>';
		}
		}	
	}
}
if ($found <= 0)
	echo "No sellers found. Perhaps you are the only seller.";
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
	  <link rel="stylesheet" href="dist/css/bootstrap-dialog.min.css">
	  <script src="dist/js/bootstrap-dialog.js"></script>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	
	<!--script src="js/bookprofile.js"></script-->
  </body>
</html>