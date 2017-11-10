<?php
	include "config.php";
	include "head.php";

//checks if a session is started
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}
	if(isset($_SESSION['username'])){
		header("location:main.php");
	}
//checks if form has send any data
	if (isset($_POST['myusername'], $_POST['mypassword'])) {
		//removes all the slashes to convert the text to a one line string.
		$myusername =  stripslashes($_POST['myusername']);
		$mypassword =  stripslashes($_POST['mypassword']);
		//protects the forms with html entities, and protects against html injection
		$myusername = htmlentities($_POST['myusername']);
		$mypassword = htmlentities($_POST['mypassword']);

	@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
	//adds slashes before certain variables stopping harmful code form entering the db.
	$myusername = mysqli_real_escape_string($db, $myusername);
	$mypassword = mysqli_real_escape_string($db, $mypassword);
	//returns a string with added backslashes infront of predefined characters ',",\,NULL
	$myusername = addslashes($myusername);
	$mypassword = addslashes($mypassword);


	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}


//fetches the user_id username and password from the db where username is euqal to the variable containing wha the user inserted inot the form.
	$stmt = $db->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
	$stmt->bind_param('s', $myusername);
	$stmt->bind_result($userid,$username, $password);
	$stmt->execute();

//fetches the stmt and checks if the hashed password the user inserted into the form is the same as the one in the db
	while ($stmt->fetch()) {
	if (sha1($mypassword) == $password){
		//adds data from username and userid variable to the session.
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $userid;
		ob_start();
		header("location:main.php");
		ob_flush();
		exit();
	}
	//otherwise tells the user to retry with a different username or password.
	else {
		$error = "Your Username or Password is invalid, please try again.";
		echo ("<p class=\"error_msg\">$error</p>");
       }
    }
  }


?>
   <div class="loginDiv">
        <img src="img/juarvis.png" alt="logo" id="logo"/>
		<h1>Juárvis</h1>
		<h2>Not your average list making</h2>
	   	<h3>Log in below to get started!</h3>
		<form class="loginForm" action = "" method = "post">
                  <input type = "text" name = "myusername" placeholder="Username" class = "inputField"/>
                  <br>
                  <input type = "password" name = "mypassword" placeholder="Password" class = "inputField" />
                  <br>
                  <input type = "submit" name = "login" value = "Log In" class="button"/>
		</form>
        <p>Not registered?</p></b><a href="registration.php">Sign Up</a>
	</div>
</html>
