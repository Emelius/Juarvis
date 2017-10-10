<?php
        include 'config.php';
        
        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
        
		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
        }

	//how to target specific user?
        
        $newusername = POST_$['username'];
        $newpassword = POST_$['password'];
        $newemail = POST_$['email'];

	$sql = "INSERT into users where user_id '(userid)' (username,password,email) values ('$newusername','$newpassword','$newemail');
	
	if (!mysqli_query($con,$sql)) {
		echo 'Something went wrong, not updated';
	}

	else {
		echo 'Update successfull';
	} 

	header("refresh:2; url=settings.html");

?>
