<?php include 'head.php'; ?>
	
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

<h3>Welcome to Juarvis</h3>

<div class="registrationDiv">
	<form class="registrationForm" action="registration.php" method="POST">
		<label>Username</label>
		<input type="text" name="username">
		<br>
		<label>Email</label>
		<input type="text" name="email">
		<br>
		<label>Password</label> 
		<input type="password" name="password">
		<br>
		<input type="submit" name="submit" value="Register">
	</form>
<div>


<?php  include("footer.php"); ?>

