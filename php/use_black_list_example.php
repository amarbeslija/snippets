<html>
    <head>
        <title>Black List</title>
        <meta charset="utf-8">
    </head>
    <body>
        
        <form action="" method="POST">
        <label>Choose your color:</label>
        <select name="color"> 
            <option value="red">Red</option> 
            <option value="blue">Blue</option> 
            <option value="green">Green</option>
            <option value="black">Now it is a good option</option> 
        </select> 
        <input type="submit" value="Send your color">
        </form>
 

        <?php 

        $colors = ["red", "blue", "green"]; 
        
        if(isset($_POST["color"])){
            $color = $_POST['color']; 
            $color = htmlspecialchars($color);
            
            if(!in_array($color, $colors)){ 
                // Proceed with data processing 
                echo "Color " . $color . " is good!";
            }else{
                // Do not proceed with data processing
                echo "Color " . $color . " is not good!";
            }
        }

        ?>
    </body>
</html>