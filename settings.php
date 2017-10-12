<?php include 'header.php'; include 'config.php'; ?>

<?php
        session_start();

        if (isset($_SESSION['login_user'])) {
                $activeusername = $_SESSION['login_user'];
        }
        else {
                header("index.php");
        }

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

	$sql = "SELECT * FROM user WHERE username = 'login_user'";
	$result = mysqli_query($db,$sql);
  	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

        //$activeemail =assign from databse email

        // check so that new username or email is not already in db?
	//if (newusername != any other username in db) {"sorry, the username is taken!}

	//check so that fields are not empty? don't send to db -> if !empty

	//else post -> settingsinsert.php -> insert new info into db

        echo
                "<h2>Username</h2>",
                $activeusername,
                '<form method="POST" action="settingsinsert.php">
		            <h3>Change Username</h3>
                <input type="text" name="newusername"/>
                <h2>Change Password</h2>
                <input type="password" name="newpassword"/>
                <h2>Email</h2>',
                $activeemail,
                '<h3>Change Email</h3>
                <input type="email" name="newemail"/>
                <input type="submit"  value="Save Changes">
                </form>';

?>

<?php include 'footer.php'; ?>
