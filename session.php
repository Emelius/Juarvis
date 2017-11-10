<?php
    include('config.php');

    //checks if the user IP is set
    if (isset($_SESSION['userip']) === false){     
    //stores the IP into the session 'userip'
        $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
    }

    //checks if the IP of the current user is the same as the IP when the session was started
    if ($_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']){
        //if it is not the same all session variables are removed and session is destroyed
        session_unset();
        session_destroy();
    }   

    //Starts session engine if not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //checks if a session is set, if set redirects to main page
   if ( (!isset($_SESSION['username']) && (!isset($_SESSION['user_id']))) ) {
        header("location:login.php");
   }
?>
