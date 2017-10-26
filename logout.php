<?php include 'head.php';
// You have left jarviz all alone and logged out bye pls thnx
    session_start();
    session_destroy();
    header("location:index.php");
    ?>
