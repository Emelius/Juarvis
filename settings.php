<?php
	include 'header.php';
	include 'config.php';
	include 'session.php';?>
<?php
	//set session variables
	$userid = $_SESSION['userid'];
	$username = $_SESSION['username'];

	//establish db connection
        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page.</a>");
			exit();
	}

	//set current user information in variables
	$stmt = $db->prepare("SELECT username,password,email from users WHERE username='$username'");
	$stmt->execute();
	$stmt->bind_result($currentusername, $currentpassword, $currentemail);

	//set variables
	$newusername = "";
	$newpassword = "";
	$newemail = "";
	$confirmpassword = "";

	//safety yes
	$newusername = addslashes($newusername);
	$newpassword = addslashes($newpassword);
	$newemail = addslashes($newemail);
	$confirmpassword = addslashes($confirmpassword);

	$newusername = htmlentities($newusername);
	$newpassword = htmlentities($newpassword);
	$newemail = htmlentities($newemail);
	$confirmpassword = htmlentities($confirmpassword);

	$newusername = mysqli_real_escape_string($db, $newusername);
	$newpassword = mysqli_real_escape_string($db, $newpassword);
	$newemail = mysqli_real_escape_string($db, $newemail);
	$confirmpassword = mysqli_real_escape_string($db, $confirmpassword);

	//check forms
	if (isset($_POST) && !empty($_POST)) {
		
	//get data from form
		$newusername = trim($_POST['newusername']);
		$newpassword = trim($_POST['newpassword']);
		$newemail = trim($_POST['newemail']);
		$confirmpassword = trim($_POST['confirmpassword']);
	
	//check if email already exists in db
	if ($newemail != "") {
		$sql = "SELECT email FROM users WHERE email = '$newemail'";
		$result = $db->query($sql);
		
		if ($result->num_rows > 0){
			echo "That email already exists!";
			exit ();
		}
		else {
			$stmt = $db->prepare("INSERT INTO users (user_id, username, password, email) VALUES ('','','','$newemail') WHERE user_id='$userid'");
			$stmt->execute();
		}
		
	}

	//check if username already exists in db
	if ($newusername != "") {
		$sql = "SELECT username FROM users WHERE username = '$newusername'";
		$result = $db->query($sql);
		
		if ($result->num_rows > 0){
			echo "That username already exists!";
			exit();
		}
		else {
			$stmt = $db->prepare("INSERT INTO users (user_id, username, password, email) VALUES ('','$newusername','','') WHERE user_id='$userid'");
			$stmt->execute();
		}
	}

	//check if password matches the old one
	if ($confirmpassword != ""){
		if ($confirmpassword != $currentpassword) {
			echo "Wrong password.";
			exit();
		}
		else {
			$stmt = $db->prepare("INSERT INTO users (user_id, username, password, email) VALUES ('','','$newpassword','') WHERE user_id='$userid'");
			$stmt->execute();		
		}
	}
		
	}

	else {
		echo "Please fill something out in the form.";
	}
	
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
