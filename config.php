<?php
//get the url and just take the last part of the url and saves it to the $current_page
$url = $_SERVER['REQUEST_URI'];
$strings = explode('/', $url);
$current_page = end($strings);

//the database connection variables
$dbname = 'juarvis';
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
   //$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
?>
