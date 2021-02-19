<?php
    /* If we want to show some PHP code inside HTML page for showcase, example, etc., here is the way to do it. */    


    // Code we want to show inside HTML page
    $code = '
    <?php
        echo "Test code to be output with everything else";
    ?>';
    
    // Output full HTML Code, changing "<" and ">" to HTML Entities
    echo "<pre>" . htmlspecialchars($code) . "</pre>";
?>
