<?php

/*** S: Function which cleans string from special characters and spaces ***/

function cleanString($string){
    // Replaces all spaces with hyphens.
    $string = str_replace(' ', '', $string); 
    
    // Removes special characters (every one of them) and return cleaned string
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
}

/*** E: Function which cleans string  from special characters and spaces ***/



/*** S: Function which checks does username exists in the database and returns true or false ***/

// PS: Change table name here accordingly
// PPS: Connection class is singleton, so use something similar or change accordingly
function checkUsernameExists($data){
    // Get the data and clean it
    $username = $data['username'];
    $username = cleanString($username);
    
    // Get connection to the database
    $connection = Connection::instance();
    $db = $connection->connect();
    
    // Check does user with the username provided exists inside the database
    $sql = "SELECT username FROM Wo_Users WHERE username LIKE '%{$username}%'";
    
    // Check do query works
    if($result = $db->query($sql)){
        // Check if we have results. If we have, then we are returning true (username already in database)
        if(mysqli_num_rows($result) >= 1){
            // Username exists
            return true;   
        }
    }
    // If we don't have results, username doesn't exists
    return false;
    
}
/*** E: Function which checks does username exists in the database and returns true or false ***/


/********** CLASSES **********/


/*** S: Singleton class which connects to the database ***/

class Connection {
	private $_connection;

	private $_hostname = "";
	private $_username = "";
	private $_password = "";
	private $_database = "";

	private static $_instance; 

    // Create instance of the class
	public static function instance() {
		
		if(!self::$_instance) { 
		    
		    // If no instance then make one here
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	// Constructor which connects to the database
	private function __construct() {
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database);
	
		// Write that we can't connect to the database if we have an error
		if(mysqli_connect_error()) {
			trigger_error("Failed to connect to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
		}
	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function connect() {
		return $this->_connection;
	}
}

/*** E: Singleton class which connects to the database ***/

/*** S: Create random color in PHP ***/

$randomArray = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
$color = '#' . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)];

/*** E: Create random color in PHP ***/

/*** S: Function:Create random color in PHP ***/

function randomColor(){
	$randomArray = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	$color = '#' . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)] . $randomArray[rand(0,15)];	
	return $color;
}

/*** E: Function:Create random color in PHP ***/


// Generate 4 Digit Random Number (for example, for 2FA) 1
$randomNumber = mt_rand (1000, 9999);

// Generate 5 Digit Random Number (for example, for 2FA) 2
$randomNumber = mt_rand (10000, 99999);

// Generate X Digit Random Number (for example, for 2FA) 3
$x = 10;
$randomNumber = substr(str_shuffle("0123456789"), 0, $x);

// Generate X Random String (for example, for 2FA) 4
$x = 13;
$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, $x);

/*** S: Simple XSS Protection - Replace special characters with HTML Entities ***/

$input = $_POST['input'];
$input = htmlspecialchars( $input);

/*** E: Simple XSS Protection ***/

/*** S: Simple SQL Injection Protection - Add slash to special characters */

$input = $_POST['input'];
$input = mysqli_real_escape_string($connectionToTheDatabase, $input);

/*** E: Simple SQL Injection Protection */