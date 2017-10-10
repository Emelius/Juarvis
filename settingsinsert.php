<?php
        include 'config.php';
        
        @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
        
		if ($db->connect_error) {
			echo "could not connect: " . $db->connect_error;
			printf("<br><a href=index.php>Return to home page </a>");
			exit();
        }
        
        $newusername = POST_$['username'];
        $newpassword = POST_$['password'];
        $newname = POST_$['name'];
        $newemail = POST_$['email'];
?>
