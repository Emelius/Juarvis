<?php
   include('config.php');
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  //echo $_SESSION['username'];

   if(
     (!isset($_SESSION['username']) && (!isset($_SESSION['user_id']))))
   {
     echo "not set";
      //header("location:index.php");
   }
?>
