<?php
    
    try {
        $database = new PDO('mysql:host=localhost;dbname=itacademy', 'root', '');
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

    if(isset($_POST['username'])){
        $username = $_POST['username'];

        // Place where SQL Injection attack will occur
        //$user = $database->query("SELECT * FROM user WHERE username = '{$username}'");

        // Better way of running queries with prepared statements
        $user = $database->prepare("SELECT * FROM user WHERE username = :username");
        $user->execute([
            ':username' => $username,
        ]);


        if($user->rowCount()){
            echo "Username found!";
        }
    }

    // SQL Attack: '; DROP TABLE post; --
?>

<html>
    <head>
        <title>SQL Injection</title>
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