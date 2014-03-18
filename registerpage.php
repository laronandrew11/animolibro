  <?php
  session_start(); 
	$_SESSION['upload_type']=1; //so upload.php knows that we are uploading a user profile pic
  ?>
<!doctype html>
<html><head>
    <title>AnimoLibro - DLSU Book Exchange</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	
	<link href="css/customized-components.css" rel="stylesheet">
	<link href="css/upload.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
            <li><a href="portal.html">Home</a></li>
             <!--li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li-->
          </ul>
          <form class="navbar-form navbar-right" role="form">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
			 <!--button type="submit" class="btn btn-success">Sign in</button-->
            <a href="home.html" class="btn btn-success" role="button">Sign in</a>
			<button type="submit" class="btn btn-primary active">Register</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
	</div>
	<div class="container">
	
	<div class="row">
	<div class="col-sm-8 col-md-8">
	<div class="alert alert-success" id="success-alert">
		Registration successful!
	</div>
	<div class="row">
			<div class="col-sm-8 col-md-8">
			<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
			<div id="drop">
				Drop Here

				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>
		</div>
		</div>
		<form action="php/register.php" class="form-horizontal" id="registerHere" method="post">
		<fieldset>

		<legend>Registration (all fields required)</legend>
		
		<div class="form-group">
		<label class="control-label">Name</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="user_name" name="user_name" rel="popover" data-content="Enter your first and last name." data-original-title="Full Name">
		</div>
		</div>

		<div class="form-group">
		<label class="control-label">DLSU E-mail (*******@dlsu.ph)</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="user_email" name="user_email" rel="popover" data-content="What�s your email address?" data-original-title="Email">
		</div>
		</div>
		
		<!--sql currently requires course and contact no-->		
		<div class="form-group">
		<label class="control-label">Contact Number</label>
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="user_contactno" name="user_contactno" rel="popover" data-content="What�s your contact number?" data-original-title="Contact Number">
		</div>
		</div>
		
			<!--div class="form-group">
		<label class="control-label">Course (optional)</label> 
		<div class="controls">
		<input type="text" class="input-xlarge form-control" id="user_course" name="user_course" rel="popover" data-content="What�s your course?" data-original-title="Email">
		</div>
		</div-->
		
		<div class="form-group">
		<label class="control-label">Course</label> 
		<div class="controls">
		<select name="course">
		<option value=1>CS-ST</option>
		<option value=2>CS-CSE</option>
		<option value=3>CS-NE</option>
		<option value=4>CS-IST</option>
		</select>
		</div>
		</div>

		


		
		
		<div class="form-group">
		<label class="control-label">Password</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control" id="user_password" name="user_password" rel="popover" data-content="Enter a password." data-original-title="Password">
		</div>
		</div>
		
		<div class="form-group">
		<label class="control-label">Confirm Password</label>
		<div class="controls">
		<input type="password" class="input-xlarge form-control" id="confirm_password" name="confirm_password" rel="popover" data-content="Re-enter your password." data-original-title="Confirm Password">
		</div>
		</div>
		
	
		
		<div class="form-group">
		<label class="control-label"></label>
		<div class="controls">
		<button type="submit" class="btn btn-success" name="submit">Create My Account</button>
		<!--a href="home.html" role="button" class="btn btn-success" id="btn-home">Create My Account</a-->
		</div>
		</div>

		</fieldset>
		
		</form>
	</div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="dist/js/bootstrap.min.js"></script>
	<script src="js/upload/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="js/upload/jquery.ui.widget.js"></script>
		<script src="js/upload/jquery.iframe-transport.js"></script>
		<script src="js/upload/jquery.fileupload.js"></script>
		
		<script src="js/upload/script.js"></script>
	<!--script src="js/dropdown.js"></script-->
	<script src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	<script src="js/register.js"></script>
	
  
</body></html>