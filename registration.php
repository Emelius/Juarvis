<?php 
	include 'head.php';
	include 'config.php';
?>
	
<?php
if (isset($_POST) && !empty($_POST)) {
    // This is the postback so add the book to the database
    # Get data from form
    $newusername = "";
    $newpassword = "";
    $newemail = "";
    
    $newusername = trim($_POST['username']);
    $newpassword = trim($_POST['password']);
    $newemail = trim($_POST['email']);
    
    $newpassword = sha1($newpassword);
	
	echo $newusername;
	echo $newpassword;
	echo $newemail;

    if (!$newusername || !$newpassword || !$newemail) {
        printf("You must specify both username, email and a password");
        printf("<br><a href=registration.php>Try again</a>");
        exit();
    }

    $newusername = addslashes($newusername);
    $newemail = addslashes($newemail);
    $newpassword = addslashes($newpassword);
	
    $newusername = htmlentities($newusername);
    $newemail = htmlentities($newemail);
    $newpassword = htmlentities($newpassword);

    # Open the database
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=registration.php>Registration failed, try again</a>");
        exit();
    }

    // Prepare an insert statement and execute it
    $stmt = $db->prepare("insert into users values ('', ?, ?, ?, '')");
    $stmt->bind_param('sss', $newusername, $newpassword, $newemail);
    $stmt->execute();
    printf("<br>Account created!");
    printf("<br><a href=index.php>Login</a>");
    exit;
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
    </body
</html>

