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

?>