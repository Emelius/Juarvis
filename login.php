<?php
	include("config.php");
	include("head.php");



	if(isset($_SESSION['username'])){
		header("location:main.php");
	}

<<<<<<< HEAD
	if (isset($_POST['myusername'], $_POST['mypassword']) && !empty($_POST)) {
	echo "hej";
=======
	if (isset($_POST['myusername'], $_POST['mypassword'])) {

>>>>>>> 63476ac9309ff8c2888159ceb59b7366fa761e36
		$myusername =  stripslashes($_POST['myusername']);
		$mypassword =  stripslashes($_POST['mypassword']);

	@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

<<<<<<< HEAD
	$stmt = $db->prepare("SELECT username, password FROM users WHERE username = '$myusername'");
=======
	echo "SELECT username, password FROM users WHERE username = '$myusername'";

	$stmt = $db->prepare("SELECT username, password FROM users WHERE username = ?");
	$stmt->bind_param('s', $myusername);
>>>>>>> 63476ac9309ff8c2888159ceb59b7366fa761e36
	$stmt->execute();
	$stmt->bind_result($username, $password);

	while ($stmt->fetch()) {
	if (sha1($mypassword) == $password){
		$_SESSION['username'] = $myusername;


				ob_start();
				header("location:main.php");
		ob_flush();
		//exit();
	}
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
<<<<<<< HEAD
		<form class="loginForm" action = "" method = "POST">
=======
	   	<h3>Log in below to get started!</h3>
		<form class="loginForm" action = "" method = "post">
>>>>>>> 63476ac9309ff8c2888159ceb59b7366fa761e36
                  <input type = "text" name = "myusername" placeholder="Username" class = "inputField"/>
                  <br>
                  <input type = "password" name = "mypassword" placeholder="Password" class = "inputField" />
                  <br>
                  <input type = "submit" name = "login" value = "Log In" class="button"/>
		</form>
        <p>Not registered?</p></b><a href="registration.php">Sign Up</a>
	</div>
</html>
