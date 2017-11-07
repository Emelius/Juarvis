<?php

$url = $_SERVER['REQUEST_URI'];
$strings = explode('/', $url);
$current_page = end($strings);


$dbname = 'juarvis';
$dbuser = 'root';
$dbpass = '';
$dbserver = 'localhost';
$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
   //$db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
?>
