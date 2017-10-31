<?php
	include 'header.php';
	include 'config.php';
	include 'session.php';?>
<?php

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

	//set current user information in variables

	$stmt = $db->prepare("SELECT username,password,email from users where username='username'");
	$stmt->execute();
	$stmt->bind_result($currentusername, $currentpassword, $currentemail);

	//set variables
	$newusername = "";
	$newpassword = "";
	$newemail = "";

	//Check forms
	if (isset($_POST) && !empty($_POST)) {
	//Get data from form
			$newusername = trim($_POST['newusername']);
			$newpassword = trim($_POST['newpassword']);
			$newemail = trim($_POST['newemail']);
	} else {
		echo "Please fill something out in the form";
	}

	// check if email already exists in db
	if ($newemail != "") {
		if ($result->num_rows > 0){
			echo "That email already exists";
			exit();
			$sql = "SELECT email FROM users WHERE email = '$currentemail'";
			$result = $db->query($sql);
		}
		else {
			$sql = "SELECT email FROM users WHERE email = '$newemail'";
			$result = $db->query($sql);
		}
	}

	// check if username already exists in db
	if ($newusername != "") {
		if ($result->num_rows > 0){
			echo "That username already exists";
			exit();
			$sql = "SELECT email FROM users WHERE username = '$currentusername'";
			$result = $db->query($sql);
		}
		else {
			$sql = "SELECT email FROM users WHERE username = '$newusername'";
			$result = $db->query($sql);
		}
	}
	else{
		$sql = "SELECT email FROM users WHERE username = '$currentusername'";
		$result = $db->query($sql);
	}

	//check if password matches the old one
	if ($confirmpassword != $currentpassword){
		echo "Wrong password.";
		}
		else {
			
	}

	//insert new info into db

	$stmt = $db->prepare("INSERT INTO users where user_id='userid' (user_id, username, password, email) VALUES ('','$newusername','$newpassword','$newemail')");
	$stmt->execute();

	//Safety yes
	$newusername = addslashes($newusername);
	$newpassword = addslashes($newpassword);
	$newemail = addslashes($newemail);

	$newusername = htmlentities($newusername);
	$newpassword = htmlentities($newpassword);
	$newemail = htmlentities($newemail);

	$newusername = mysqli_real_escape_string($db, $newusername);
	$newpassword = mysqli_real_escape_string($db, $newpassword);
	$newemail = mysqli_real_escape_string($db, $newemail);
?>

   <div class="settingsDiv">
        <h2>Settings<h2>
        <h3>Fill in the forms below to change your settings.</h3>
        <form method="POST" action="settingsinsert.php" class="settingsForm">
            <h4>Change Username</h4>
            <input type="text" name="newusername" value="<?php echo $currentusername ?>" placeholder="New Username" class="inputField"/>
            <h4>Change Password</h4>
            <input type="password" name="newpassword" value="<?php echo $currentpassword ?>" placeholder="New Password" class="inputField"/>
            <h4>Change Email</h4>
            <input type="email" name="newemail" value="<?php echo $currentemail ?>" placeholder="New Email" class="inputField"/>
						<h4>Confirm with your old password</h4>
						<input type="password" name="confirmpassword" placeholder="Confirm Password" class="inputField"/>
						<input type="submit" value="Save Changes" class="button">
        </form>
    </div>

<?php include 'footer.php'; ?>
