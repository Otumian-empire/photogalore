<?php

/**
 * Constants for redirection in the function below
 *
 */
define('DO_REDIRECT', true, false);
define('DO_NOT_REDIRECT', false, false);

/**
 * takes an error message as a parameter
 * and redirects to imageUploadForm.php page
 * return_msg($msg, $rdt = DO_REDIRECT)
 */
function return_msg($msg, $rdt = DO_REDIRECT) {

    $_SESSION['return_message'] = $msg;

    if ($rdt) {
        header("Location: index.php");
    }
}

?>
