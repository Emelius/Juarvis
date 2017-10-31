<?php
   include('config.php');
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

   if(!isset($_SESSION['username'])){
     echo "not set";
      //header("location:index.php");
   }
?>
