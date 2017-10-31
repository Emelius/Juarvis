<div class='tododiv'>
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

	else {
	      echo "0 results";
	}

	//get and display all tasks

	$sql2 = "SELECT taskname FROM tasks"; //and user_id = 'login_user'";
	$result2 = mysqli_query($db, $sql2);

	$taskname = "";

	if (mysqli_num_rows($result2) > 0) {

	    // output data of each row
	    while($row2 = mysqli_fetch_assoc($result2)) {
		echo "". $row2["taskname"]. "<br>";
	    }
	}
	else {
	      echo "0 results";
	    }

	//Create new list if user submits new list. Will NOT run first time user goes to page
	if (isset($_POST['submitlist'])) {

	    //If newlist is not set echo error message
	    if (empty($_POST['newlist'])) {
		printf("You must add a listname, try again.");
		exit();
	    }

		else {
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

//selected list_id (when creating task) should end up in $newlistid


	//Create new task for specific list
if (isset($_POST['submittask']) /*/&& isset($_POST['tasklist'])/*/) {

	    //If newlist is not set, write error message, it not continue
	    if (empty($_POST['newtask'])) {
			printf("You must add a task, try again.");
			exit();
			}

			else {
	    # Get data from form
	    $newtask = "";
	    $newtask = trim($_POST['newtask']);

	    $stmt = $db->prepare("INSERT INTO 'tasks' ('task_id', 'taskname', 'taskdesc', 'sdate', 'edate', 'rdate', 'status', 'list_id') VALUES ('', ?, ?, '', '', '','',?)");
	    $stmt->bind_param('ssi', $newtask, $newtaskdesc, $newlistid);
	    $stmt->execute();
	    printf("<br>Task Added!");
	    header("Refresh:0");
	  }
	}

	//Remove list and tasks with same list_id


/*/
	$stmt = $db->prepare("DELETE FROM `lists` WHERE list_id = ?");
        $stmt->bind_param('i', $list_id);
        $response = $stmt->execute();
        printf("<br>List deleted!");
/*/
  	//Remove finished tasks

	/*/
	$stmt = $db->prepare("DELETE FROM `tasks` WHERE task_id = ?");
        $stmt->bind_param('i', $task_id);
        $response = $stmt->execute();
        printf("<br>Task deleted!");
	/*/
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

  $sql3 = "SELECT list_id,listname FROM lists";
  $result3 = mysqli_query($db, $sql3);

  echo "<select name='tasklist'>";
  while ($row3 = mysqli_fetch_assoc($result3)) {
      echo "<option value='" . $row3['list_id'] ."'>" .$row3['listname'] ."</option><br>";
  }
  echo "</select>";
  ?>

	<input type="submit" name="submittask" value="Add" class="button">
</form>
</div>
