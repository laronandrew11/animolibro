<?php
	session_start();
	echo '<!DOCTYPE html>
<html>';
include('head.php');
  echo'<body>';
include ('navbar.php');
	
?>
	<!--script src ="home.php"></script-->
	<div class="jumbotron">
	<h1>Sell a book</h1>
		<p>Done with your old textbooks? Let them continue to serve their purpose.</p>
		<p><a class="btn btn-primary btn-lg" role="button" href="sellbookpage.php">Sell a textbook</a></p>
	</div>
	<div class="jumbotron">
	<h1>Find a book</h1>
		<p>Need a textbook? Start your search here.</p>
		<p><div class="row">
        <div class="col-lg-6">
            <form name=search action="findbooks.php" method="post"  class="form-inline" >
                <input class="span5 form-control input-xlarge" type="text"  id="typeahead" name="typeahead" rel="popover" data-provide="typeahead" placeholder="Search by Title, ISBN, Author, Publisher, Category, or Subject:">
                <button type="submit" name="submit" class="btn btn-success"> Search <i class="glyphicon glyphicon-search"></i></button>
				 <!--a name = "submit0" type="submit" role="button" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i></a-->
            </form>
        </div></p>
	</div>

	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	 <script>
		$(function() {
			$("#typeahead").typeahead({
				source:function(typeahead, query) {
					$.ajax({
						url: 'php/source.php',
						type: 'POST',
						data: 'query=' + query,
						dataType: 'JSON',
						async: false,
						success: function(data) {
							typeahead.process(data);
						}
					});
				}
			});
		});
	</script>
  </body>
</html>