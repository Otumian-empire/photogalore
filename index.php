<?php
   /* 
        this file contains the myFunction.php file and 
        checks if a session id isset else, starts a session
    */
    require_once("DBConfig.php"); 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <title>Uploading image...</title>
    </head>
    <body>
        <div class="header">
            <h1>Photo Galore</h1>
            <p>Image maniacs - Select an image below and it will be added to those below if there is any...</p>
        </div>
        <div class="file-upload-form">
            <div class="form-container">
                <form action="imageUploadValidation.php" 
                method="POST" enctype="multipart/form-data">
                    <div class="label-input-field">
                        <label for="user_image">Upload Image</label>
                        <input type="file" alt="user image" name="user_image" class="button">
                    </div>
                    <div class="file-label-description">
                        <input type="text" name="file_label" id="file_label" placeholder="file label..">
                        <input type="text" name="file_description" id="file_description" placeholder="file description..">
                    </div>
                    
                    <button type="submit" name="submit_image" id="submit_image" class="button" onclick="window.location.reload();">upload image</button>
                </form>
            </div>
                
            <div class="return-message">
                <?php
                    echo isset($_SESSION['return_message'])? $_SESSION['return_message']:"";
                ?>
            </div>
        </div>
        <div class="home-page">
            <?php
            
                // query the data base for the url, label and description
                // create an img tag: src=url, p tag: text=label
                // and another p tag: text=description
                $read_url_label_description_query = "SELECT `url`, `label`, `description` FROM `photos`";

                $read_result = mysqli_query($conn, $read_url_label_description_query);

                if ($read_result) {
                    while ($imageInfo = mysqli_fetch_array($read_result)) {
                        $output = "";
                        $output .= "<div class='image-frame'>";
                        $output .= "<img src='" . $imageInfo['url']. "' alt=''  class='image'> ";
                        $output .= "<p class='label'>". $imageInfo['label'] ."</p>";
                        $output .= "<p class='description'>". $imageInfo['description'] ."</p>";
                        $output .= "</div>";
                        // $output .= "<br>";

                        echo $output;

                        return_msg("Image Upload: successful..", DO_NOT_REDIRECT);
                    }
                } else {
                    return_msg("error message: " . mysqli_error($conn), DO_NOT_REDIRECT);
                }
            
            ?>

        </div>
        <br><br>
    </body>
</html>

<?php if ($conn) mysqli_close($conn); ?>
