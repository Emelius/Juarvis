<?php
   include('config.php');
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  //echo $_SESSION['username'];
//checks if a session is set and sends it forward to the main page
   if(
     (!isset($_SESSION['username']) && (!isset($_SESSION['user_id']))))
   {
      header("location:main.php");
   }
?>
