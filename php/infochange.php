<?php
include_once('animolibroerrorhandler.php');
require_once('db_config.php');
require_once('check_password.php');
session_start();

if (isset($_POST)) {
	$db = database::getInstance();
	$form_type = $_POST['formType'];
	$user_id = $_SESSION['animolibroid'];

	if ($form_type == 'Change email') {
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

	else if ($form_type == 'Change contact number') {
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

	else if ($form_type == 'Change course') {
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