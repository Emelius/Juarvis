<?php include 'header.php'; ?>

<?php

session_start();

$username = $_SESSION["(active user?)"];

echo (current/active username);

echo '<form method="POST" action="registration.php">

<input type="text" value="newusername"/>';

echo (current/active password);

echo 'input type="password" value="newpassword"/>';

echo (current/active name);

echo '<input type="text" value="newname"/>';

echo (current/active email);

echo  '<input type="email" value="newemail"/>

<input type="submit"  value="Save Changesr">';

echo '</form>';
?>

/*/list following:username, pw, name, email, colorscheme?
econfirm button - ability to change - send new info to db
/*/

<?php include 'footer.php'; ?>
