<?php
    include("config.php");
    session_start();
    if (isset($_SESSION['username'])) {
        header("welcome.php");
    }
    if (isset($_POST["login"])) {

      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
	      $myusername = htmlentities($myusername);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']);
	      $mypassword = htmlentities($mypassword);
        // username and password sent from form, This php script was modified and based on a script from:
        //https://www.tutorialspoint.com/php/php_mysql_login.htm

        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']);

        $sql = "SELECT user_id FROM users WHERE username = '$myusername' and password = '$mypassword'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //$active = $row['active'];

        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
           //session_register("myusername");
           $_SESSION['login_user'] = $myusername;

           header("location: welcome.php");
        }else {
           $error = "Your Login Name or Password is invalid, please try again.";
           echo ("<p class=\"error_msg\">$error</p>");
        }
     }
   }

?>
<html>

    <head>
      <title>Login Page</title>
    </head>

   <body bgcolor = "#FFFFFF">

      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>

            <div style = "margin:30px">

               <form action = "" method = "post">

                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" name = "login" value = " Log In "/>
                  <br />
                  <a href="registration.php">Register here...</a>
               </form>

            </div>

         </div>

      </div>

   </body>
</html>
