<?php

function animo_error_handler($errno, $errstr, $errfile, $errline) {
    echo "'$errno', '$errstr', '$errfile', '$errline'<br />";

    $errno = mysql_escape_string($errno);
    $errstr = mysql_escape_string($errstr);
    $errfile = mysql_escape_string($errfile);
    $errline = mysql_escape_string($errline);

    $error_query = "INSERT INTO `log_errors` (`errno`, `errstr`, `errfile`, `errline`) VALUES ('$errno', '$errstr', '$errfile', '$errline')";

    include('dbConnect.php');
    if (mysql_query($error_query)) {
		/* Successfully logged into db */
		echo "Error inserted.";
    }
    else {
    	/* Failed to log into db */
    }

    return true;
}

set_error_handler('animo_error_handler');