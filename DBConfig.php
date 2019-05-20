<?php
    // check for session
    if (!session_id()) {
        session_start();
    }

    // include the function file
    require_once("myFunctions.php");

    // connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'photoGaloreDB');
    if (!$conn) {
        return_msg("Please try again later, system under repair..");
    }
?>
