<?php
include_once('animolibroerrorhandler.php');
require_once('db_config.php');
session_start();

function is_password_correct($password) {
	$db = database::getInstance();
	$user_id = $_SESSION['animolibroid'];
	$user_query = $db->dbh->prepare("SELECT `passwordhash`, `salt` FROM `useraccount` WHERE `id` = :user_id LIMIT 1");
	$user_query->bindParam(':user_id', $user_id);
	if ($user_query->execute()) {
		$user_row = $user_query->fetch(PDO::FETCH_ASSOC);
		$stored_password_hash = $user_row['passwordhash'];
		$stored_salt = $user_row['salt'];
		$password_hash = hash("sha256", $password . $stored_salt);
		if ($password_hash === $stored_password_hash) {
			return TRUE;
		}
	}
	return FALSE;
}

if (isset($_POST)) {
	$db = database::getInstance();
	$form_type = $_POST['formType'];
	$user_id = $_SESSION['animolibroid'];

	if ($form_type == 'changeEmail') {
		if (is_password_correct($_POST['password'])) {
			$new_email = $_POST['email'];
			$user_update_query = $db->dbh->prepare("UPDATE `useraccount` SET `email` = :email WHERE `id` = :user_id");
			$user_update_query->bindParam(':email', $new_email);
			$user_update_query->bindParam(':user_id', $user_id);
			$changed_something = $user_update_query->execute();
		}
		else {
			$changed_something = FALSE;
		}
		$_SESSION['bad_message'] = 'Sorry, we failed to update your email. Please try again?';
	}

	else if ($form_type == 'changeNumber') {
		if (is_password_correct($_POST['password'])) {
			$new_contact_number = $_POST['contactnumber'];
			$user_update_query = $db->dbh->prepare("UPDATE `useraccount` SET `contactnumber` = :contact_number WHERE `id` = :user_id");
			$user_update_query->bindParam(':contact_number', $new_contact_number);
			$user_update_query->bindParam(':user_id', $user_id);
			$changed_something = $user_update_query->execute();
		}
		else {
			$changed_something = FALSE;
		}
		$_SESSION['bad_message'] = 'Sorry, we failed to update your contact number. Please try again?';
	}

	else if ($form_type == 'changeCourse') {
		$new_course_id = $_POST['course_id'];
		$user_update_query = $db->dbh->prepare("UPDATE `useraccount` SET `course_id` = :course_id WHERE `id` = :user_id");
		$user_update_query->bindParam(':course_id', $new_course_id);
		$user_update_query->bindParam(':user_id', $user_id);
		$changed_something = $user_update_query->execute();
		$_SESSION['bad_message'] = 'Sorry, we failed to update your course. Please try again?';
	}

	if (isset($changed_something)) {
		if ($changed_something === TRUE) {
			unset($_SESSION['bad_message']);
			header("Location: ../userprofile.php");
		}
		else {
			header("Location: ../changeinfo.php");
		}
		exit;
	}
}

unset($_SESSION['bad_message']);

if (isset($_SESSION['logged']) && $_SESSION['logged']) {
	header("Location: ../home.php");
}
else {
	header("Location: ../portal.php");
}
exit;

?>