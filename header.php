<?php include("session.php") ?>
<!doctype html>
<html>
    <head>
        <title>JUARVIS</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">
    </head>
    <body>
    	<header>
            <img src='img/juarvis_white.png' alt="logo" id="logo_header"/>
            <nav id='headermenu'>
                <ul>
                    <li><a class="<?php echo ($current_page == 'main.php')? 'active' :NULL?>" href="main.php">Home</a></li>
                    <li><a class="<?php echo ($current_page == 'settings.php')? 'active' :NULL?>" href="settings.php">Settings</a></li>
                </ul>
            </nav>
            <a id='logout' href="logout.php">Log out</a>
    	</header>
