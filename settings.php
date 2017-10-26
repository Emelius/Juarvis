<?php
	include 'header.php';
	include 'config.php';
	include 'session.php';?>
<?php

//$userid = $_SESSION['userid'];

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

	//set current user information in variables

	$stmt = $db->prepare("select username,password,email from users where username='username'");
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
		$sqlEmailExists = "SELECT email FROM users WHERE email = '$newemail'";
		$result = $db->query($sqlEmailExists);

		if ($result->num_rows > 0){
			echo "That email already exists";
			exit();
		}
	}

	// check if username already exists in db
	if ($newusername != "") {
		$sqlUsernameExists = "SELECT username FROM users WHERE username = '$newusername'";
		$result = $db->query($sqlUsernameExists);

		if ($result->num_rows > 0){
			echo "That username already exists";
			exit();
		}
	}

	//check if password matches the old one
	if ($confirmpassword != ''){
		//pls chek if $currentpassword
	}else {
		echo "Wrong password.";
	}

	//insert new info into db

	$sql = "INSERT into users where username='username' ('',?,?,?,'') values ('$newusername','$newpassword','$newemail')";

	if(!mysqli_query($db,$sql)) {
		echo 'Something went wrong, not updated';
	}
	else {
		echo 'Update successfull';
	}


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
            <input type="password" name="confirmpassword" placeholder="Confirm Password" class="inputField"/>
            <input type="password" name="newpassword" value="<?php echo $currentpassword ?>" placeholder="New Password" class="inputField"/>
            <h4>Change Email</h4>
            <input type="email" name="newemail" value="<?php echo $currentemail ?>" placeholder="New Email" class="inputField"/>
            <input type="submit" value="Save Changes" class="button">
        </form>
    </div>

<?php include 'footer.php'; ?>
