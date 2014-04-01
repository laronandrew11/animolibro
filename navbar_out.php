<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="portal.php">Animo&#9734Libro</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <!--li><a href="portal.php">Home</a></li>
            <!--li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li-->
          </ul>
          <form action="php/verify.php" class="navbar-form navbar-right" role="form" method = "post">
            <div class="form-group">
              <input type="text" name="Email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="Password" placeholder="Password" class="form-control">
            </div>
            <!--button type="submit" class="btn btn-success">Sign in</button-->
			<input type="submit" class="btn btn-success" role="button" name = "submit" value = "Sign-in">
			<a role="button" href = "registerpage.php" class="btn btn-primary" role=>Register</a>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>