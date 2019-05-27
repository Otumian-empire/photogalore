<?php

    // this file contains the myFunction.php file and 
    // checks if a session id isset else, starts a session
    require_once("DBConfig.php"); 

    
    // the $_FILES is a 2D array
    // print_r($_FILES['user_image']);
    // results in: 
    // Array ( [name] => invest.png [type] => image/png [tmp_name] => /opt/lampp/temp/phpzHBEZH [error] => 0 [size] => 610238 ) 

    // name: name of the file when user chose it
    // type: image extension
    // tmp_name: a temporary name given in cache
    // error: 0 - no error, 1 - error
    // size: image size in bytes
   
    if (isset($_POST['submit_image']) && isset($_FILES['user_image']) && 
        isset($_POST['file_label']) && isset($_POST['file_description']) && 
        strlen($_POST['file_label']) > 0 && strlen($_POST['file_description']) > 0) {

        $fileName = $_FILES['user_image']['name'];
        $fileType = $_FILES['user_image']['type'];
        $fileTmpName = $_FILES['user_image']['tmp_name'];
        $fileError = $_FILES['user_image']['error'];
        $fileSize = $_FILES['user_image']['size'];

        // validating the file size, in bytes
        if ($fileSize >= 3000 && $fileSize <= 1000000 && $fileError === 0) {
            
            // validating the file extension type
            $allowedFileTypes = ['png', 'jpg', 'jpeg'];
            $fileExtension = explode("/", strtolower($fileType))[1];
            
            if (in_array($fileExtension, $allowedFileTypes)) {

                // validating the file name count
                // stripping tags and html chars
                // i tried to use RegEx but couldn't
                if (isset($_POST['file_label']) && isset($_POST['file_description'])) {
                    
                    $fileLabel = removeUnwantedChars($_POST['file_label']);
                    $fileDescription = removeUnwantedChars($_POST['file_description']);

                    // file_label and file_description should consist of only letters and numbers
                    if ((strlen($fileLabel) >= 4 && strlen($fileLabel) <= 50) && (strlen($fileDescription) >= 4 && strlen($fileDescription) <= 255)) {
                        
                        // setting up an interface between the database the image form upload
                        // rename file ($fileName = $fileLabel) , create image url = base folder + fileName(file label)
                        // put url, label and description into the data base
                        // then move the file to the base folder

                        $imageUrl = "photos/" . str_replace(' ', '_', $fileLabel) . "." . $fileExtension;

                        // check if file already exists
                        if (file_exists($imageUrl)) {

                            /* TODO: maybe if file already exist we could ask the user to edit the label and description.
                            this would force us to change the url and the label in the database and rename the file as a whole (the url..) */

                            return_msg("A file already exists with the same details...");
                        
                        } else {
                            $insert_image_query = "INSERT INTO photos(`url`, `label`, `description`) VALUES('$imageUrl', '$fileLabel', '$fileDescription')";

                            if (mysqli_query($conn, $insert_image_query)) {

                                if (move_uploaded_file($fileTmpName, $imageUrl)) {
                                    return_msg("image has been moved successfully..");
                                } else {
                                    return_msg("file upload unsuccessful..<br>" . mysqli_error($conn));
                                }
                            } else {
                                return_msg("database error: " . mysqli_error($conn));
                            }
                        }
                    } else {
                        // return_msg("enter a file name less than or equal to 15 chars<br>".
                        //         "enter a file description less than or equal to 255 chars<br>".
                        //         "but not empty and greater than 3 characters..");
                        /*TODO: change this error message */
                        return_msg("error with label and description: " . mysqli_error($conn));
                    }
                } else {
                    return_msg("File label and name needed, in that, exclude non-alphanumeric characters such as *, +, <, etc");
                }
            } else {
                return_msg("Only images of extension, png, jpg and jpeg are allowed..");
            }
        } else {
            return_msg("File upload error. A file greater than 30kB or less than 1MB, is recommended..");
        }
    } else {
        return_msg("please select an image, enter the name and description of the image and then click the upload image button...");
    }

    if ($conn) mysqli_close($conn);
?>
