<?php
    include 'config.php';
    //include 'session.php';
    include 'header.php';
    include 'calendar.php';
    include 'todo.php';
    include 'footer.php';
    session_start();

    if(!isset($_SESSION['username'])){
       header("location:index.php");
    }
?>
