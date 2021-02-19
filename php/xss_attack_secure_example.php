<?php
    
    if(isset($_POST['username'])){
        // This way is not secure
        //echo "Username: " . $_POST['username'];

        // This way is secure (replace "<" and ">" with HTML Entities)
        $username = htmlspecialchars($_POST['username']);
        echo "Username: " . $username;
    }


    // Attack example: <script> window.location="https://it-akademija.com"; </script>
?>

<html>
    <head>
        <title>XSS Attack</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form method="POST" action="">
            <label>Insert username:</label>
            <input type="text" name="username">
            <input type="submit" value="Send">
        </form>
    </body>
</html>