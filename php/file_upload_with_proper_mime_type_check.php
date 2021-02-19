<!DOCTYPE html>
<html>
    <head>
        <title>Check Your Mime Type</title>
        <meta charset="utf8">
    </head>
    <body>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="image">Select image to upload:</label>
            <input type="file" name="image" id="image">
            <input type="submit" value="Upload">
        </form>

        <?php

        if(isset($_FILES["image"])){
            // Set directory where to upload files and full path to uploaded file
            $upload_directory = "uploads/";
            $destination = $upload_directory . basename($_FILES["image"]["name"]);

            // Check MIME type and upload file if it is correct
            if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                // Take MIME type (best version of it)
                $mime_type = mime_content_type($_FILES['image']['tmp_name']);
            
                // Allow only png and jpeg in this situation (white list)
                $allowed_types = ['image/png', 'image/jpeg'];
                if (!in_array($mime_type, $allowed_types)) {
                    echo "Sorry! This file is not allowed!";
                    return;
                }
            
                // Upload file if everything checks out
                if (move_uploaded_file ($_FILES['image']['tmp_name'] , $destination)) {
                    echo "Good! File uploaded";
                    return;
                }
            }
        }
        ?>
    </body>
</html>