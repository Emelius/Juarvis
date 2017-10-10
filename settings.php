<?php include 'header.php'; include 'config.php'; ?>

<?php
        session_start();

        if (isset($_SESSION['username'])) {
                $activeusername = $_SESSION['username'];
        }
        else {
                header("index.php")
        }

        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
		
		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
	}

        $activename = //assign from db name
        $activeemail = //assign from databse email
                
        // check so that new username or email is not already in db?
        // post, insert new info into db
        

        echo
                '<h2>Username</h2>'
                ,
                $activeusername
                ,
                '<h3>Change Username</h3>
                <form method="POST" action="registration.php">
                <input type="text" value="newusername"/>
                <h2>Change Password</h2>
                <input type="password" value="newpassword"/>
                <h2>Name</h2>'
                ,
                $activename
                ,
                '<h3>Change Name</h3>
                <input type="text" value="newname"/>
                <h2>Email<h2>'
                ,
                $activeemail
                ,
                '<h3>Change Email</h3>
                <input type="email" value="newemail"/>
                <input type="submit"  value="Save Changes">
                </form>';
?>

/*/list following:username, pw, name, email, colorscheme?
econfirm button - ability to change - send new info to db
/*/

<?php include 'footer.php'; ?>
