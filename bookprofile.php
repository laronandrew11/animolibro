
	<!DOCTYPE html>
<html>
<?php
	
  include('head.php');
 session_start();
  echo'<body>';
  
  	include('navbar.php');
	include('php/dbConnect.php');
	

	//TODO: display relevant book info
	$bookid=$_GET['bookid'];
    $title = $_GET['title']; 
    $isbn = $_GET['isbn']; 
	 $authors = $_GET['authors'];  
	  $subject = $_GET['subject']; 
	 $category = $_GET['category']; 
	  $publisher = $_GET['publisher']; 
	  $numcopies = $_GET['numcopies'];
	$sellerid = $_SESSION['animolibroid'];
	$query1 ="SELECT * FROM Ad  
        WHERE Book_id= $bookid AND seller_id != $sellerid ORDER BY status=2,status=1";
	$query2="SELECT cover_pic_id FROM Book WHERE id=$bookid";	
	//section for getting ads
	$sql1 = mysql_query($query1);
	$sql2=mysql_query($query2);
	$row2=mysql_fetch_array($sql2);
	$coverpic_id=$row2['cover_pic_id'];
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
                            echo'<br />';
							$subjectbookquery="SELECT DISTINCT Subject_id FROM Subject_uses_Book WHERE Book_id = $bookid";
	$subjectbooks= mysql_query($subjectbookquery);
	while($subjectbookrow=mysql_fetch_array($subjectbooks))
	{
		$subjectID= $subjectbookrow['Subject_id'];
		$subjectquery=mysql_query("SELECT code from Subject WHERE id = $subjectID");
		while($subjectrow=mysql_fetch_array($subjectquery))
						{
							echo '<i class="glyphicon glyphicon-book"></i>' .$subjectrow['code'].'<br>';
		
		
						}	
	}
							echo'<i class="glyphicon glyphicon-info-sign"></i> ';
							echo $numcopies;
							echo ' copies available
                            <br />';
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
	if(!empty($sql1)&&mysql_num_rows($sql1) >= 1){ 

		while($ad_row = mysql_fetch_array($sql1))
		{
			//echo $row['title'] . " " . $row['LastName'];
			// "<br>";
			$description=$ad_row['description'];
			$adid=$ad_row['id'];
			$status=$ad_row['status'];
			$condition=$ad_row['copy_condition'];
			$sellerid=$ad_row['seller_id'];
			$sellerquery=mysql_query("SELECT * from UserAccount WHERE id = '$sellerid'");
			$seller_row=mysql_fetch_array($sellerquery);
			$sellername=$seller_row['username'];
			
			$profilepic_id=$seller_row['profile_pic_id'];
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
	

	
	
	
			
			//$bookauthors=$bookrow['authors'];
			if($status != 2)
			{
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
					echo '<p>Copy Description: '.$description;
					echo'<input type="hidden" name="url" value="'.$_SERVER['REQUEST_URI'].'">';
					$sellername = str_replace(' ', '%20', $sellername);
					echo'<p><a href=userprofile.php?user='.$sellername.'>View seller profile</a>';
					if($status == 0 || $status == 3)
					echo'<input type="submit" name="submit" class="btn btn-primary pull-right buy-btn" value="Buy">';
					else if($status == 1)
					{
						echo'<input type="submit" name="submit" class="btn btn-primary disabled pull-right buy-btn" value="Bought">';
					}
				echo '</form>
				</div>
			</div></div>';
			}
			
		}
	}else echo "No sellers found. Perhaps you are the only seller.";
	
	
	
	
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