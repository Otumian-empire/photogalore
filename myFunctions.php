<?php

// Constants for redirection in the function below
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


/**
 * removeUnwantedChars($data)
 * removes non-alphanumeric characters and replaces them with a single space
 * after the process, returns a safe version of $data for use
 * @param {*} $data
 * @return {*} $data
 */
function removeUnwantedChars($data) {

    // these are characters we don't want in our db
    $unwantedChars = [
        '~', '`', '!', '@', '#', '$', '%'. '^', '&', '*', '(',
        ')', '-', '_', '+', '=', '{', '}', '[', ']', ':', ';',
        '\'', '"',  '\\', '|', '<', ',', '>', '.', '?', '/',
        '\t', '\n', '\r', '\f'
    ];

    // loop through the $data, check if a char in data is in the above 
    // array and replace it
    for ($i = 0; $i < strlen($data); $i++) {
        if (in_array($data[$i], $unwantedChars)) {
            $data = str_replace($data[$i], '', $data);
        }
    }

    return $data;
}

?>
