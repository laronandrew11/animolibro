<?php
include_once('php/animolibroerrorhandler.php');
require_once('php/db_config.php');

session_start();
$db = database::getInstance();
$user = array();
$user['id'] = $_SESSION['animolibroid'];

/* GET USER EMAIL, CONTACT NUMBER AND COURSE ID */
$user_query = $db->dbh->prepare("SELECT `email`, `contactnumber`, `Course_id` FROM `useraccount` WHERE `id` = :user_id LIMIT 1");
$user_query->bindParam(':user_id', $user['id']);
if ($user_query->execute() && $user_query->rowcount() > 0) {
	$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
	$user['email'] = $user_row['email'];
	$user['contact_number'] = (int)$user_row['contactnumber'];
	$user['course_id'] = (int)$user_row['Course_id'];
}
else {
	header("Location: changeinfo.php");
	exit;
}

/* GET ALL COURSES AVAILABLE */
$course_query = $db->dbh->prepare("SELECT `id`, `code` FROM `course` ORDER BY `id`");
if ($course_query->execute()) {
	$courses = $course_query->fetchAll(PDO::FETCH_ASSOC);
}
else {
	header("Location: changeinfo.php");
	exit();
}

?>


<!-- START HEADER LAYOUT STUFF -->
<!DOCTYPE html5>
<html>
	<?php include('head.php'); ?>
	<head>
		<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		    /* display: none; <- Crashes Chrome on hover */
		    -webkit-appearance: none;
		    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
		}
		</style>
	</head>
	<body>
		<?php include('navbar.php'); ?>
<!-- END HEADER LAYOUT STUFF -->


<!-- START ALERTS -->
<?php
/* ALERTS HERE */
if (isset($_SESSION["bad_message"])) {
	echo "<div type='danger-alert' class='alert alert-danger' data-dismiss='alert' aria-hidden='true'>";
	echo $_SESSION['bad_message'];
	echo "</div>";
	unset($_SESSION["bad_message"]);
}
?>
<!-- END ALERTS -->


<!-- START MAIN LAYOUT STUFF -->
<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<form action="php/infochange.php" role="form" method="POST">
				<legend>Change Email Address</legend>
				<input type="hidden" name="formType" value="changeEmail" required />
				<div class="form-group">
					<label for="email" class="control-label">Email address</label>
					<input type="email" name="email" class="form-control" placeholder="<?php echo $user['email']; ?>" autofocus required />
				</div>
				<div class="form-group">
					<label for="password" class="control-label">Password</label>
					<input type="password" name="password" class="form-control" placeholder="******" required />
				</div>
				<input type="submit" class="btn btn-success" value="Change email" />
			</form>
		</div>
		<div class="col-lg-4 col-md-4">
			<form action="php/infochange.php" role="form" method="POST">
				<legend>Change Contact Number</legend>
				<input type="hidden" name="formType" value="changeNumber" required />
				<div class="form-group">
					<label for="contactnumber" class="control-label">Contact number</label>
					<input type="number" name="contactnumber" class="form-control" placeholder="<?php echo $user['contact_number']; ?>" required />
				</div>
				<div class="form-group">
					<label for="password" class="control-label">Password</label>
					<input type="password" name="password" class="form-control" placeholder="******" required />
				</div>
				<input type="submit" class="btn btn-success" value="Change contact number" />
			</form>
		</div>
		<div class="col-lg-4 col-md-4">
			<form action="php/infochange.php" role="form" method="POST">
				<legend>Change Course</legend>
				<input type="hidden" name="formType" value="changeCourse" required />
				<div class="form-group">
					<label for="course_id" class="control-label">Course</label>
					<select name="course_id" class="form-control">
						<?php foreach ($courses as $course): ?>
							<option value="<?php echo $course['id']; ?>" <?php if ($course['id'] == $user['course_id']) {echo 'selected';} ?>>
								<?php echo $course['code'] ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<input type="submit" class="btn btn-success" value="Change course" />
			</form>
		</div>
	</div>
</div>
<!-- END MAIN LAYOUT STUFF -->


<!-- START FOOTER LAYOUT STUFF -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://code.jquery.com/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="dist/js/bootstrap.min.js"></script>
	</body>
</html>
<!-- END FOOTER LAYOUT STUFF -->