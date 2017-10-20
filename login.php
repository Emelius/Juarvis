<?php
	include("config.php");
	include "head.php";

	if(isset($_SESSION['username'])){
		header("location:main.php");
	}

	if (isset($_POST['myusername'], $_POST['mypassword']) && !empty($_POST)) {
		$myusername =  stripslashes($_POST['myusername']);
		$mypassword =  stripslashes($_POST['mypassword']);

	@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

	$stmt = $db->prepare("SELECT username, password FROM users WHERE username = ?");
	$stmt->bind_param('s', $myusername);
	$stmt->execute();

	$stmt->bind_result($username, $password);
	while ($stmt->fetch()) {
	if (sha1($mypassword) == $password){
		$_SESSION['username'] = $myusername;
		header("location:main.php");
		exit();
	}
	else {
		$error = "Your Username or Password is invalid, please try again.";
		echo ("<p class=\"error_msg\">$error</p>");
       }
    }
  }


?>
	<div class="loginDiv">
		<h1>¡Hola!</h1>
		<h2>Welcome to Juárvis.</h2>
		<p> Log in </p>
		<hr>
		<form class="loginForm" action = "" method = "post">
                  <input type = "text" name = "myusername" placeholder="Username" class = "box"/><br /><br />
                  <input type = "password" name = "mypassword" placeholder="Password" class = "box" /><br/><br />
                  <input type = "submit" name = "login" value = " Log in "/>
		</form>
	</div>
</body>
