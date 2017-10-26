<?php
  include 'config.php';

  //establish db connection
  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

  //get and display all lists from DB
	$sql = "SELECT listname FROM lists"; //where user_id = 'login_user'";
	$result = mysqli_query($db, $sql);

  $listname = "";

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "". $row["listname"]. "<br>";
    }
}

else{
      echo "0 results";
    }

  //get and display all tasks

$sql2 = "SELECT taskname FROM tasks"; //and user_id = 'login_user'";
	$result2 = mysqli_query($db, $sql2);

$listname = "";

if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row2 = mysqli_fetch_assoc($result2)) {
        echo "". $row2["taskname"]. "<br>";
    }
}

else{
      echo "0 results";
    }

//CREATE NEW LIST
//If user submits new list. Will NOT run first time user goes in on page:
if (isset($_POST['submitlist'])) {

    //If newlist is not set, write error message, it not continue
    if (empty($_POST['newlist'])) {
        printf("You must add a listname, try again.");

    } else {
    # Get data from form
  	$newlist = "";
  	$newlist = trim($_POST['newlist']);

  	$stmt = $db->prepare("INSERT INTO lists (list_id, listname) VALUES ('', ?)");
  	$stmt->bind_param('s', $newlist);
  	$stmt->execute();
  	printf("<br>List Added!");
  	header("Refresh:0");

  }
}

//CREATE NEW TASK for specific list: taskname, taskdesc, sdate, edate, rdate, status(1)
if (isset($_POST['submittask'])) {

    //If newlist is not set, write error message, it not continue
    if (empty($_POST['newtask'])) {
		printf("You must add a task, try again.");

  } else {

    # Get data from form
    $newtask = "";
    $newtask = trim($_POST['newtask']);

    $stmt = $db->prepare("INSERT INTO tasks (task_id, taskname, taskdesc, sdate, edate, rdate, status) VALUES ('', ?, ?, '', '', '','')");
    $stmt->bind_param('ss', $newtask, $newtaskdesc);
    $stmt->execute();
    printf("<br>Task Added!");
    header("Refresh:0");
  }
}

  //change task status to completed and mark it as grey or other CSS

?>

<form action="todo.php" method="POST">
	<input type="text" name="newlist" placeholder="New List" class="inputField">
  <br>
  <input type="submit" name="submitlist" value="Add" class="button">
</form>

<form action="todo.php" method="POST">
	<input type="text" name="newtask" placeholder="Add Task" class="inputField">
	<br>
	<input type="text" name="newtaskdesc" placeholder="Task Description" class="inputField">
	<br>

  <?php

  $sql3 = "SELECT listname FROM lists";
  $result3 = mysqli_query($db, $sql3);

  echo "<select name='listname'>";
  while ($row3 = mysqli_fetch_assoc($result3)) {
      echo "<option value='" . $row3['listname'] ."'>" . $row3['listname'] ."</option><br>";
  }
  echo "</select>";
  ?>

	<input type="submit" name="submittask" value="Add" class="button">
</form>
