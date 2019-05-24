<?php

    // this file contains the myFunction.php file and 
    // checks if a session id isset else, starts a session
    require_once("DBConfig.php"); 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <title>Photo Galore | Index page</title>
    </head>
    <body>

        <!-- top starts here -->
        <!-- we brought top here so that we can make the modal be displayed 
        and the rest of the page in the top, displayed none -->
        <div class="top">

            <!-- header starts here -->
            <div class="header">
                <h1>Photo Galore</h1>
                <p>Image maniacs - Select an image below and it will be added to those below if there is any...</p>
            </div>
            <!-- header ends here -->


            <!-- file-upload-form starts here -->
            <div class="file-upload-form">

                <div class="form-container">
                    <form action="imageUploadValidation.php" method="POST" enctype="multipart/form-data">

                        <div class="label-input-field">
                            <label for="user_image">Select image</label>
                            <input type="file" alt="user image" name="user_image" class="button">
                        </div>

                        <div class="file-label-description">
                            <input type="text" name="file_label" id="file_label" placeholder="file label..">
                            <input type="text" name="file_description" id="file_description" placeholder="file description..">
                        </div>
                        
                        <button type="submit" name="submit_image" id="submit_image" class="button">upload image</button>

                    </form>

                </div>
                    
                <div class="return-message">
                    <?php
                        echo isset($_SESSION['return_message'])? $_SESSION['return_message']:"";
                    ?>
                </div>

            </div>
            <!-- file-upload-form ends here -->


            <!-- home-page starts here -->
            <div class="home-page">
                <?php
                
                    // query the data base for the url, label and description
                    // create an img tag: src=url, p tag: text=label
                    // and another p tag: text=description
                    $read_url_label_description_query = "SELECT `url`, `label`, `description` FROM `photos`";

                    $read_result = mysqli_query($conn, $read_url_label_description_query);

                    if ($read_result) {
                        $id = 0;

                        while ($imageInfo = mysqli_fetch_array($read_result)) {
                            $output = "";
                            $output .= "<div class='image-frame' onclick='enlargeImage(this)'; id='" . $id++ . "'>";
                            $output .= "<img src='" . $imageInfo['url']. "' alt=''  class='image'> ";
                            $output .= "<h3 class='label'>". $imageInfo['label'] ."</h3>";
                            $output .= "<p class='description'>". $imageInfo['description'] ."</p>";
                            $output .= "</div>";

                            echo $output;

                            return_msg("Image Upload: successful..", DO_NOT_REDIRECT);
                        }
                    } else {
                        return_msg("error message: " . mysqli_error($conn), DO_NOT_REDIRECT);
                    }
                ?>

            </div>
            <!-- home-page ends here -->

        </div>
        <!-- top ends here -->


        <br><br>


        <!-- modal starts here -->
        <div class="bg-modal" id="bg-modal">

            <div class="modal-content">

                <div class="modal-frame">

                    <img src="" alt="" id="modal-url">

                    <div class="label_desc">
                        <h1 id="modal-label"></h1>
                        <p id="modal-description"></p>
                    </div>

                </div>

                <!-- this is the close button -->
                <button class="modal-close" id="modal-close">^</button>
                
            </div>
            
        </div>
        <!-- modal ends here -->


        <!-- js starts here -->
        <script src="app.js"></script>
        <!-- js ends here -->

    </body>
    
</html>

<?php if ($conn) mysqli_close($conn); ?>
