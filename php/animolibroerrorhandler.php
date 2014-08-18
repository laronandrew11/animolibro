<?php
require_once("db_config.php");

function animo_error_handler($errno, $errstr, $errfile, $errline) {

    $db = database::getInstance();

    $stmt = $db->dbh->prepare("INSERT INTO log_errors (errno, errstr, errfile, errline) VALUES (:errno, :errstr, :errfile, :errline)");
    $stmt->bindParam(':errno', $errno);
    $stmt->bindParam(':errstr', $errstr);
    $stmt->bindParam(':errfile', $errfile);
    $stmt->bindParam(':errline', $errline);

    if ($stmt->execute()) {
		/* Successfully logged into db */
    }
    else {
    	/* Failed to log into db */
    }

    return true;
}

set_error_handler('animo_error_handler');