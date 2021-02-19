// Redirect to custom page/website 1
window.location = "https://lab387.com"; 
// Redirect to custom page/website 2 (simulate a mouse click)
window.location.href = "https://lab387.com"; 
// Redirect to custom page/website 3 (simulate HTTP redirect)
window.location.replace("https://lab387.com");
// Get currect URL/location
var url = window.location.href;

// Get browser's width (full function, with cross-browser support) #function
function width() {
    return Math.max(
        document.body.scrollWidth,
        document.documentElement.scrollWidth,
        document.body.offsetWidth,
        document.documentElement.offsetWidth,
        document.documentElement.clientWidth
    );
}
// Get browser's height (full function, with cross-browser support) #function
function height() {
    return Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight,
      document.documentElement.clientHeight
    );
}

// Check if id exists and then do something
var idExists = document.getElementById("id-name");
if(idExists.length > 0){
    // Id exists
}else{
    // Id doesn't exists
}

// Check if class exists and then do something
var classExists = document.getElementsByClassName("class-name")[0];
if(classExists.length > 0){
    // Class exists
}else{
    // Class doesn't exists
}

// Get elements width (without border)
var element = document.getElementById("element").clientWidth;
// Get elements width (with border width)
var element = document.getElementById("element").offsetWidth;

// Get elements height (without border)
var element = document.getElementById("element").clientHeight;
// Get elements height (with border width)
var element = document.getElementById("element").offsetWidth;



/*** S: Password Complexity Check (8-20 characters with lowercase letter, uppercase letter, one digit and one special character) ***/
// Get passwords from input
var passwords = document.getElementsByClassName("register-password");
// Create function which checks the password patterns
var passwordsCheck = function(){
    // Take the password value
    var passwordValue = this.value;
    // The password pattern 
    var passwordPattern =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,20}$/;
    // If password value doesn't match password value show an error in adequate language
    if(!passwordValue.match(passwordPattern)){ 
        // Find all password error fields (this can be changed to specific field)
        var passwordError = document.getElementsByClassName("password-error-field");
        // Show error in all password error fields 
        for (var i = 0; i < passwordError.length; i++) {
            // Call the getCookie function and get the language which is choosen
            var language = getCookie('lang');
            // If language is not set, then show the error in the default language (English here)
                passwordError[i].style.display = "inline-block";
            if(language === ''){
                passwordError[i].innerHTML = "Password needs to have between 8 and 20 characters, including lowercase letter, uppercase letter, number and special character!";
            }else if(language === 'english'){
                passwordError[i].innerHTML = "Password needs to have between 8 and 20 characters, including lowercase letter, uppercase letter, number and special character!";
            }
        }
    }else{
        // If password value match the pattern, then empty and hide every password field (this can be changed to specific field)
        var passwordField = document.getElementsByClassName("password-error-field");
        for (var i = 0; i < passwordField.length; i++) {
            passwordField[i].innerHTML = "";
            passwordField[i].style.display = "none";
        }
    }
};
// Add event listener for password complexity check to every .register-password field there
for (var i = 0; i < passwords.length; i++) {
    passwords[i].addEventListener('focusout', passwordsCheck, false);
}
/*** E: Password Complexity Check (8-20 characters with lowercase letter, uppercase letter, one digit and one special character) ***/



/*** S: Function which checks username pattern (8 to 20 charachters, including numbers. It can't start with the number) ***/
// Get usernames from input
var usernames = document.getElementsByClassName("register-username");
// Create function which checks the username patterns
var usernamesCheck = function(){
    // Take the username value
    var usernameValue = this.value;
    // The username pattern
    var usernamePattern = /^[^0-9][a-zA-Z0-9]{8,20}$/;
    // If username value doesn't match password value show an error in adequate language
    if(!usernameValue.match(usernamePattern)){
        // Find all username error fields (this can be changed to specific field)
        var usernameError = document.getElementsByClassName("username-error-field");
        // Show error in all username error fields
        for(var i = 0; i < usernameError.length; i++){
            // Call the getCookie function and get the language which is choosen
            var language = getCookie('lang');
            // If language is not set, then show the error in the default language (English here)
            usernameError[i].style.display = "inline-block";
            if(language === ''){
            usernameError[i].innerHTML = "Username needs to have between 8 and 20 characters, including only letters and numbers!";
        }else if(language === 'english'){
            usernameError[i].innerHTML = "Username needs to have between 8 and 20 characters, including only letters and numbers!";
        }
        }
    }else{
        // If username value match the pattern, then empty and hide every password field (this can be changed to specific field)
        var usernameField = document.getElementsByClassName("username-error-field");
        for (var i = 0; i < usernameField.length; i++) {
            usernameField[i].innerHTML = "";
            usernameField[i].style.display = "none";
        }
    }
};
// Add event listener for password complexity check to every .register-username field there
for (var i = 0; i < usernames.length; i++) {
    usernames[i].addEventListener('focusout', usernamesCheck, false);
}
/*** E:  S: Function which checks username pattern (8 to 20 charachters, including numbers. It can't start with the number) ***/



/*** S: Function for getting cookie by name ***/
function getCookie(cookieName) {
    // Get the cookie name
    var name = cookieName + "=";
    // Decode cookies saved inside browser
    var decodedCookie = decodeURIComponent(document.cookie);
    // Split cookies to the array by ;
    var cookieArray = decodedCookie.split(';');
    // Find the cookie we are searching for inside the array
    for(var i = 0; i < cookieArray.length; i++) {
      var cookie = cookieArray[i];
      while (cookie.charAt(0) == ' ') {
        cookie = cookie.substring(1);
      }
      // If we find cookie, then return its value
      if (cookie.indexOf(name) == 0) {
        return cookie.substring(name.length, cookie.length);
      }
    }
    // If we don't find cookie, then return nothing
    return "";
  }

  /*** E: Function for getting cookie by name ***/


/*** S: Function for creating cross browser XMLHttpRequest ***/

function createAjax() {
    // The variable that makes Ajax possible!
    var ajaxRequest; 
    try {
      // Opera 8.0+, Firefox, Safari
      ajaxRequest = new XMLHttpRequest();
    } catch (e) {
    
      // Internet Explorer Browsers
      try {
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
      
         try {
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (e) {
      
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      }
    }
// If everything is allright, return ajaxRequest
return ajaxRequest;
}

/*** E: Function for creating cross browser XMLHttpRequest ***/



/*** S: Function which checks does username exists inside the database ***/
// Get username to check
var usernamesExists = document.getElementsByClassName("register-username");
// Create function for checking username inside the database
var usernameExistsCheck = function(){
    // Get username value
    var usernameValue = this.value;
    // Create cross-browser ajax request
    var xhttp = createAjax();
    xhttp.onreadystatechange = function() {
        // If call is successful check backend response
        if (this.readyState == 4 && this.status == 200) {
            // If answer is true, than we have a username inside the database, and we are going to show the error
            if(this.responseText){
                // Get error field to write in
                var usernameExistsError = document.getElementsByClassName("username-exists-error-field");
                // Go through all error fields
                for(var i = 0; i < usernameExistsError.length; i++){
                    // Get language cookie, to know what to write
                    var language = getCookie('lang');
                    // Display error field
                    usernameExistsError[i].style.display = "inline-block";
                    // Write the message
                    if(language === ''){
                        usernameExistsError[i].innerHTML = "Username already exists!";
                    }else if(language === 'english'){
                        usernameExistsError[i].innerHTML = "Username already exists!";
                    }
                }   
            }else{
                // If don't have a match in the database, hide the field and remove the text errors (if they are any)
                var usernameExistsField = document.getElementsByClassName("username-exists-error-field");
                for (var i = 0; i < usernameExistsField.length; i++) {
                    usernameExistsField[i].innerHTML = "";
                    usernameExistsField[i].style.display = "none";
                }
            }
        }
    };
    // Open AJAX request, send it and send POST parameters
    xhttp.open("POST", "dom_php/controller.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("username="+usernameValue+"&function=checkUsernameExists");

};
// Add this function to every element with the class 'register-username'
for (var i = 0; i < usernamesExists.length; i++) {
    usernamesExists[i].addEventListener('focusout', usernameExistsCheck, false);
}
    
/*** E: Function which checks does username exists inside the database ***/

/*** S: Strip HTML Tags ***/

let originalString = "<div><h1>We are naked <strong> now!</strong></h1></div>";
let strippedString = originalString.replace(/(<([^>]+)>)/gi, "");
document.write(strippedString);

/*** E: Strip HTML Tags ***/

// Create random color
var randomColor = Math.floor(Math.random()*16777215).toString(16);

// Select random element from array (named RandomArray)
var randomArrayElement = RandomArray[Math.floor(Math.random()*RandomArray.length)];

/*** S: Inject new styles ***/

function injectStyles(rule) {
    var div = $("<div />", {
        html: '<style>' + rule + '</style>'
    }).appendTo("body");    
}

/*** E: Inject new styles ***/

// XSS Protection
var sanitizeHTML = function (str) {
    return str.replace(/[^\w. ]/gi, function (c) {
        return '&#' + c.charCodeAt(0) + ';';
    });
};