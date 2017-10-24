<?php
include 'config.php';

if (isset($_POST['taskname'])) {
    // This is the postback so add the book to the database
    # Get data from form
    $taskname = trim($_POST['taskname']);
    $taskdesc = trim($_POST['taskdesc']);
    $edate = ($_POST['edate']);
    $td = date('Y-m-d', strtotime($edate));

    if (!$taskname || !$taskdesc) {
        printf("You must specify both a title and an author");
        printf("<br><a href=index.php>Return to home page </a>");
        exit();
    }

    $taskname = addslashes($taskname);
    $taskdesc = addslashes($taskdesc);

    # Open the database using the "librarian" account
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

    if ($db->connect_error) {
        echo "could not connect: " . $db->connect_error;
        printf("<br><a href=home.php>Return to home page </a>");
        exit();
    }

    // Prepare an insert statement and execute it
    $stmt = $db->prepare("INSERT INTO tasks (taskname, taskdesc, sdate, edate, status) VALUES (?, ?, CURDATE(), ?, false)");
    $stmt->bind_param('sss', $taskname, $taskdesc, $td);
    $stmt->execute();
    printf("<br>task added!");
    printf("<br><a href=add_task.php>add another </a>");
    exit;
}

 ?>
 <h3>Add a new task</h3>
 <hr>
 <form action="add_task.php" method="POST">
     <table bgcolor="#bdc0ff" cellpadding="6">
         <tbody>
             <tr>
                 <td>Name of your task:</td>
                 <td><INPUT type="text" name="taskname"></td>
             </tr>
             <tr>
                 <td>Description:</td>
                 <td><INPUT type="text" name="taskdesc"></td>
             </tr>
             <tr>
                 <td>Due date</td>
                 <td><INPUT type="date" name="edate"></td>
             </tr>
             <tr>
                 <td></td>
                 <td><INPUT type="submit" name="submit" value="Add Book"></td>
             </tr>
         </tbody>
     </table>
 </form>
 <?php

 ?>
