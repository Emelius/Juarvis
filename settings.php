<?php
	include 'header.php';
	include 'config.php';
	include 'session.php';?>
<?php

        if (isset($_SESSION['login_user'])) {
                $activeusername = $_SESSION['login_user'];
        }

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

	$sql = "SELECT * FROM users WHERE username = 'login_user'";


	//somehow assign current data to forms -> so that if not edited the same info will be returned to db -> edited will be updated

        //$activeemail =assign from databse email

        // check so that new username or email is not already in db
	//if (newusername != any other username in db) else {"sorry, the username is taken!}

	//check so that fields are not empty? don't send to db -> if !empty

	//else post -> settingsinsert.php -> insert new info into db

	if (isset($_POST) && !empty($_POST)) {
	//Get data from form
			$newusername = trim($_POST['newusername']);
			$newpassword = trim($_POST['newpassword']);
			$newemail = trim($_POST['newemail']);
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
            <input type="text" name="newusername" placeholder="New Username" class="inputField"/>
            <h4>Change Password</h4>
            <input type="password" name="currentpassword" placeholder="Current Password" class="inputField"/>
            <input type="password" name="newpassword" placeholder="New Password" class="inputField"/>
            <h4>Change Email</h4>
            <input type="email" name="newemail" placeholder="New Email"class="inputField"/>
            <input type="submit" value="Save Changes" class="button">
        </form>
    </div>

<?php include 'footer.php'; ?>
