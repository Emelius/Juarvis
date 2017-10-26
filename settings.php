<?php
	include 'header.php';
	include 'config.php';
	include 'session.php';?>
<?php

$userid = $_SESSION['user_id'];

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

	//somehow assign current data to forms -> so that if not edited the same info will be returned to db -> edited will be updated
	$query = "select * from users where username='login_user'";
	//set result in $currentemail etc

	$newusername = "";
	$newpassword = "";
	$newemail = "";

	if (isset($_POST) && !empty($_POST)) {
	//Get data from form
			$newusername = trim($_POST['newusername']);
			$newpassword = trim($_POST['newpassword']);
			$newemail = trim($_POST['newemail']);
	} else {
		echo "Please fill something out in the form";
		//exit();
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

	//insert new info into db



	$sql = "INSERT into users where username='login_user' ('',?,?,?,'') values ('$newusername','$newpassword','$newemail')";

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
            <input type="text" name="newusername" value="$currentusername" placeholder="" class="inputField"/>
            <h4>Change Password</h4>
            <input type="password" name="currentpassword" placeholder="Current Password" class="inputField"/>
            <input type="password" name="newpassword" placeholder="New Password" class="inputField"/>
            <h4>Change Email</h4>
            <input type="email" name="newemail" placeholder="New Email"class="inputField"/>
            <input type="submit" value="Save Changes" class="button">
        </form>
    </div>

<?php include 'footer.php'; ?>
