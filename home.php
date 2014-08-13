<?php
	session_start();
	echo '<!DOCTYPE html>
<html>';
include('head.php');
include('php/authenticator.php');
  echo'<body>';
include ('navbar.php');
	
?>
<?php
	//session_start();
	if(!empty($_SESSION['pwchange']))
	{
		if($_SESSION['pwchange']==true)
		{
			echo '<div class="alert alert-success" id="success-alert">Your password has been changed.</div>';
		}
		else{
			echo '<div class="alert alert-danger" id="failure-alert">Cannot change password.</div>';
		}
	}
?>
	<!--script src ="home.php"></script-->
	<div class=" jumbotron col-md-6 col-lg-6 ">
	<h1>Find a book</h1>
		<p>Need a textbook? Start your search here.</p>
		<p><div class="row">
        <div class="col-lg-12">
            <form name=search action="findbooks.php" method="post"  class="form-inline" >
                <input class="span5 form-control form-control_inline input-xlarge" type="text"  id="typeahead" name="typeahead" rel="popover" data-provide="typeahead" placeholder="Search by Title, ISBN, Author, Publisher, Category, or Subject:">
                <button type="submit" name="submit" class="btn btn-success btn-lg"> Search <i class="glyphicon glyphicon-search"></i></button>
				 <!--a name = "submit0" type="submit" role="button" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></a-->
            </form>
        </div></p>
	</div>
	</div>
	<div class="jumbotron col-md-6 col-lg-6 ">
	<h1>Sell a book</h1>
		<p>Done with your old textbooks? Pass them on.</p>
		<p><a class="btn btn-primary btn-lg" role="button" href="sellbookpage.php">Sell a textbook</a></p>
	</div>
	

	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.js"></script>
	  <script src="js/autofill.js">
		
	</script>
  </body>
</html>