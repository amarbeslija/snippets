<?php 
    require 'Mailer/PHPMailerAutoload.php';

    /**
     * @author Amar Bešlija
     * @version 1.0
     * 
     * Helper Class which will help you to make a backup of one or multiple databases and save it to the screen, file or send it via email
     */
    
    class DBHelper{
        //Enter the relevant data below
        private static $username    = "username";
        private static $password    = "password";
        private static $host        = "localhost";
        private static $database    = "database";
        private static $backup_name = false;
        private static $tables      = false;
        private static $site_name   = "Lab387";

        /**
         * Method which will create database backup and other method will use that data for export to screen, file or email (email includes file export)
         * Tested: 19.02.2021
         * Results: 10/10
         */
        private static function backupDatabase($database = false, $tables = false, $backup_name = false){
            
            $mysqli = new mysqli(self::$host, self::$username, self::$password, self::$database); 
            
            if($database === false){
                $mysqli->select_db(self::$database); 
            }else{
                $mysqli->select_db($database);
            }

            $mysqli->query("SET NAMES 'utf8'");
    
            $queryTables = $mysqli->query('SHOW TABLES'); 

            while($row = $queryTables->fetch_row()){ 
                $target_tables[] = $row[0]; 
            }   

            if($tables !== false){ 
                $target_tables = array_intersect( $target_tables, $tables); 
            }

            foreach($target_tables as $table){
                $result         =   $mysqli->query('SELECT * FROM ' . $table);  
                $fields_amount  =   $result->field_count;  
                $rows_num=$mysqli->affected_rows;     
                $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
                $TableMLine     =   $res->fetch_row();
                $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";
    
                for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0){

                    while($row = $result->fetch_row()){ //when started (and every after 100 command cycle):

                        if ($st_counter%100 == 0 || $st_counter == 0 ){
                                $content .= "\nINSERT INTO ".$table." VALUES";
                        }

                        $content .= "\n(";

                        for($j=0; $j<$fields_amount; $j++){ 

                            $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 

                            if (isset($row[$j])){
                                $content .= '"'.$row[$j].'"' ; 
                            }else{   
                                $content .= '""';
                            } 

                            if ($j<($fields_amount-1)){
                                    $content.= ',';
                            }      
                        }

                        $content .=")";

                        //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                        if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num){   
                            $content .= ";";
                        }else{
                            $content .= ",";
                        } 

                        $st_counter=$st_counter+1;
                    }

                } $content .="\n\n\n";
            }
            // Go with defined backup name in the class or this format: database_xx.xx.xxxx_xx.xx.xx_xxxxxxxx.sql
            if($database === false){
                $databaseName = self::$database; 
            }else{
                $databaseName = $database;
            }
            $backup_name = self::$backup_name ? self::$backup_name : $databaseName . "_" . date('d.m.Y') . "_" . date('H.i.s') . "_" . rand(1,11111111) . ".sql";

            return array('content'=>$content, 'backup_name'=>$backup_name);
        }

        /**
         * Export whole database with tables and data to the screen
         * Tested: 19.02.2021
         * Results: 10/10
         */
        public static function toScreen($database = false, $tables = false, $backup_name = false ){

            $database = self::backupDatabase($database, $tables, $backup_name);

            // Export to the screen
            header('Content-Type: application/octet-stream');   
            header("Content-Transfer-Encoding: Binary"); 
            header("Content-disposition: attachment; filename=\"" . $database['backup_name'] . "\"");  
            
            echo $database['content'];
            return true; 
        }

        /**
         * Export whole database with tables and data to the file
         * Tested: 19.02.2021
         * Results: 10/10
         */
        public static function toFile($database = false, $tables = false, $backup_name = false ){

            $database = self::backupDatabase($database, $tables, $backup_name);

            // Export to the same folder as where is this file (by default)
            if(!file_put_contents($database['backup_name'], $database['content'])){
                return false;
            }

            return true;
        }

        public static function toEmail($database = false, $tables = false, $backup_name = false ){

            $database = self::backupDatabase($database, $tables, $backup_name);

            // Export to the same folder as where is this file (by default)
            if(!file_put_contents($database['backup_name'], $database['content'])){
                return false;
            }

            $mail = new PHPMailer();

            try {
                //Server settings (Send email through SMTP, because it is just better and easier)
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // If you want to see debuging on the screen                     
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.server.com';       // Insert your SMTP server             
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'email@email.com';  // Insert your email from the SMTP server                   
                $mail->Password   = 'Email Password!'; // Insert your password for the email                              
                $mail->SMTPSecure = 'tls';                      // User TLS for the encryption
                $mail->Port       = 587;                        // Secure port on the SMTP server            
            
                //Recipients
                $mail->setFrom('email@email.com', 'Website SQL Backup');       // Tell which email sends the email message
                $mail->addAddress('admin@email.com', 'Lab387 Admin');               // Add one or more recipients of the email    
                $mail->addReplyTo('email@email.com', 'Reply to this address'); // Add Reply To 
            
                // Attachments
                $mail->addAttachment($database['backup_name']);         
            
                // Content
                $mail->isHTML(true);                                  
                $mail->Subject = self::$site_name . " Database Backup - " . date('d.m.Y H:i:s');
                $mail->Body    = 'Good News! You can find your database backup in the attachment.';
                $mail->AltBody = 'Good News! You can find your database backup in the attachment.';
            
                if(!$mail->send()){
                    return false;
                }
                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        /**
         * Helper method to export
         * Tested: 19.02.2021
         * Results: 10/10
         */
        public static function export(string $type = "file"){
            switch($type){
                case 'file': self::toFile();
                break;

                case 'screen': self::toScreen();
                break;

                case 'email' : self::toEmail();
                break;

                case 'all': self::toScreen(); self::toEmail();
                break;  

                default:
                self::toFile();
                break;
            }
        }

        /**
         * Helper method to export multiple databases
         * Screen doesn't work here because Headers are sent for the first file, and can't be sent for other files (intentionally)
         * Tested: 19.02.2021
         * Results: 10/10
         */
        public static function exportMultiple(string $type = "file", $databases){
            switch($type){
                case 'file': 
                    foreach($databases as $database){
                        self::toFile($database);
                    }
                break;

                case 'all':
                case 'email' : 
                    foreach($databases as $database){
                        self::toEmail($database);
                    }

                break;  

                default:
                foreach($databases as $database){
                    self::toFile($database);
                }
                break;
            }
        }
    }

    /**
     * Examples for the Class Usages 
     * 
     */
    #DBHelper::export("screen", 'pdfcreator');
    #DBHelper::export("file", 'pdfcreator');
    #DBHelper::export("email", 'pdfcreator');
    #DBHelper::export("all", 'pdfcreator');
    #DBHelper::exportMultiple("email", array('pdfcreator', 'prijava', 'quiz', 'logotip'));
    #DBHelper::exportMultiple("screen", array('pdfcreator', 'prijava', 'quiz', 'logotip'));
    #DBHelper::exportMultiple("all", array('pdfcreator', 'prijava', 'quiz', 'logotip'));
    
?>
