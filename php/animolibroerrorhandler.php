<?php

function animo_error_handler($errno, $errstr, $errfile, $errline) {
    echo "'$errno', '$errstr', '$errfile', '$errline'<br />";

    return true;
}

set_error_handler('animo_error_handler');