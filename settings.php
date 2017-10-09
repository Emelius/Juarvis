<?php include 'header.php'; ?>

<?php
        session_start();

        if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
        }
        else {
                header("index.php")
        }

        echo '<h2>'$username'</h2>

        <form method="POST" action="registration.php">
        <input type="text" value="newusername"/>
        <h2>Password</h2>
        <input type="password" value="newpassword"/>'

        (current/active name)

        '<input type="text" value="newname"/>'

        (current/active email)

        '<input type="email" value="newemail"/>
        <input type="submit"  value="Save Changes">
        </form>';
?>

/*/list following:username, pw, name, email, colorscheme?
econfirm button - ability to change - send new info to db
/*/

<?php include 'footer.php'; ?>
