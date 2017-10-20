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

<form class="registrationForm" action="registration.php" method="POST">
    <table>
        <tbody>
            <tr>
                <td>Username</td>
                <td><INPUT type="text" name="username"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><INPUT type="text" name="email"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><INPUT type="password" name="password"></td>
            </tr>
		<tr>
                <td>Confirm Password</td>
                <td><INPUT type="password" name="password"></td>
            </tr>
            <tr>
                <td></td>
                <td><INPUT type="submit" name="submit" value="Register"></td>
            </tr>
        </tbody>
    </table>
    <br>
</form>


<?php  include("footer.php"); ?>

