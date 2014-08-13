<?php
	include('php/authenticator.php');
		echo '<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home.php">Animo&#9734Libro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			<li><a href="findbooks.php">Find</a></li>
			<li><a href="sellbookpage.php">Sell</a></li>
			
					           <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
			   
          </ul>
         <ul class="nav navbar-nav navbar-right">';

			 
	echo '<li><a href="userprofile.php?user='.$_SESSION["animolibrousername"].'"><span class="glyphicon glyphicon-user"></span> ';
	echo $_SESSION['animolibrousername'];
	echo '</a></li>';
	echo '<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span> Settings <b class="caret"></b></a>
				<ul class="dropdown-menu">
				  <li><a name="changepassword" href=changepw.php>Change Password</a></li>
				  <li><a href="php/logout.php">Log out</a></li>
				  <!--li class="divider"></li>
				  <li><a href="#"></a></li-->
				</ul>
			  </li>
		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>';
?>