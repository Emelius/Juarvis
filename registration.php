<?php
	include 'head.php';
	include 'config.php';
?>

<?php
if (isset($_POST) && !empty($_POST)) {

   	//declare variables
    $newusername = "";
    $newpassword = "";
    $newemail = "";
	
	//Get data from form
    $newusername = trim($_POST['username']);
    $newpassword = trim($_POST['password']);
    $newemail = trim($_POST['email']);

	//hash the new password
    $newpassword = sha1($newpassword);

	//if either username, password or email is not filled in print error message
    if (!$newusername || !$newpassword || !$newemail) {
			echo "<script type='text/javascript'> alert('You must specify both username, email and password.'); </script>";
	}

	//if filled in, insert into db
	else {
		
		//security for forms

		//removes all the slashes to convert the text to a one line string.
		$newusername = addslashes($newusername);
		$newemail = addslashes($newemail);
		$newpassword = addslashes($newpassword);
		
		//protects the forms with html entities, and protects against html injection
		$newusername = htmlentities($newusername);
		$newemail = htmlentities($newemail);
		$newpassword = htmlentities($newpassword);

		//removes all the slashes to convert the text to a one line string.
		$newusername = mysqli_real_escape_string($db, $newusername);
		$newpassword = mysqli_real_escape_string($db, $newpassword);
		$newemail = mysqli_real_escape_string($db, $newemail);

		//connect to database
		@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
		if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=registration.php>Registration failed, try again</a>");
        exit();
    	}
		
		//fetch email from db, checks if there already exists a row with that email in the db
		$sql = "SELECT email FROM users WHERE email = '$newemail'";
		$result = $db->query($sql);
		if ($result->num_rows > 0){
			echo "<script type='text/javascript'> alert('That email already exists!'); </script>";
			header("Refresh:0");
			exit ();
		}
		
		//fetch the username from the db
		$sql = "SELECT username FROM users WHERE username = '$newusername'";
		$result = $db->query($sql);
		//checks if that username exits in the database
		if ($result->num_rows > 0){
			echo "<script type='text/javascript'> alert('That name already exists!'); </script>";
			header("Refresh:0");
			exit ();
		}
		
		//inserts the new username, password and email into the db
		$stmt = $db->prepare("INSERT INTO users (`user_id`, `username`, `password`, `email`) values ('', ?, ?, ?)");
		$stmt->bind_param('sss', $newusername, $newpassword, $newemail);
		$stmt->execute();
		header('location:index.php');
			exit;
		}
}

?>

<div class="registrationDiv">
            <img src="img/juarvis.png" alt="logo" id="logo"/>
            <h1>Juárvis</h1>
            <h2>Register now to get started!</h2>

						<h3>Fill in your details below to sign up.</h3>
            <form class="registrationForm" action="registration.php" method="POST">
                <input type="text" name="username" placeholder="Username" class="inputField">
                <br>
                <input type="text" name="email" placeholder="Email" class="inputField">
                <br>
                <input type="password" name="password" placeholder="Password" class="inputField">
                <br>
                <input type="submit" name="submit" value="Register" class="button">
            </form>

            <p>Already registered?</p></b><a href="index.php">Return to Login Page</a>
        <div>
    </body>
</html>
