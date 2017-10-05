//<?php
//$url = $_SERVER['REQUEST_URI'];

//$strings = explode('/', $url);

//$dbname = 'juarvis';
//$dbuser = 'root';
//$dbpass = '';
//$dbserver = 'localhost';


//?>

<?php

$dbserver = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'juarvis';

   $db = mysqli_connect($dbserver,$dbuser,$dbpass,$dbname);
?>
