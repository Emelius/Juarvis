<div class='tododiv'>
<?php
	include 'config.php';

	//establish db connection
	@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

	$list_id='';

	//get and display all lists from DB
	$sql = "SELECT listname, list_id FROM lists"; //where user_id = 'username'";
	$result = mysqli_query($db, $sql);

	while( $row = mysqli_fetch_assoc($result)){
    $new_array[] = $row; // Inside while loop
	}

	foreach ($new_array as $value) {
		print_r($value["listname"]);
//deletes third list, how do we store the right list id
		$list_id = $value["list_id"];

		echo "<form method='post' action'todo.php'>";
		echo "<input type='submit' name='deletelist' value='x'/>";
		echo "<input type='hidden' name='id' value='$list_id'/>";
		echo "</form>";

		echo "<br>";



		//display all tasks
		//$sql2 = "SELECT taskname FROM tasks WHERE list_id = '$list_id' "; //and user_id = 'username'";
		//$result2 = mysqli_query($db, $sql2);

		$taskname = "";
		$task_id = "";

		$stmt = $db->prepare("SELECT task_id, taskname FROM tasks WHERE list_id = '$list_id' ");
		$stmt->execute();
		$stmt->bind_result($task_id, $taskname);

		if (mysqli_num_rows($taskname) > 0) {

				// output data of each row
				while($row2 = mysqli_fetch_assoc($taskname)) {
						echo "". $row2["taskname"]. "";

						/*/
						echo "<form method='post' action'todo.php'>";
						echo "<input type='submit' name='deletetask' value='x'/>";
						echo "<input type='hidden' name='id' value='$task_id'/>";
						echo "</form>"; /*/

				}
			}
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

	//Create new task for specific list
	if (isset($_POST['submittask'])) {

	    //If newlist is not set, write error message, it not continue
	    if (empty($_POST['newtask'])) {
			printf("You must add a task, try again.");
			exit();
			}

		else {
	    # Get data from form
	    $newtask = "";
	    $newtask = trim($_POST['newtask']);
			$newtaskdesc = "";
	    $newtaskdesc = trim($_POST['newtaskdesc']);
			$newStartDate = "";
			$newStartDate = trim($_POST['newStartDate']);
			$newEndDate = "";
			$newEndDate = trim($_POST['newEndDate']);
			$tasklist = "";
			$tasklist = trim($_POST['tasklist']);

	    $stmt = $db->prepare("INSERT INTO tasks (taskname, taskdesc, sdate, edate, list_id) VALUES (?, ?, ?, ?, ?)");
	    $stmt->bind_param('ssssi', $newtask, $newtaskdesc, $newStartDate, $newEndDate, $tasklist);
	    $stmt->execute();
	    printf("<br>Task Added!");
	    header("Refresh:0");
	  }
	}

	//Remove list and tasks with same list_id if deletbutton is clicked

	if (isset($_POST['deletelist'])) {

		$stmt = $db->prepare ("DELETE FROM lists WHERE list_id = '$list_id'");
		//$stmt->bind_param('i', $list_id);
		//$response = $stmt->execute();
		$stmt->execute();

		$stmt = $db->prepare ("DELETE FROM tasks WHERE list_id = '$list_id'");
		//$stmt->bind_param('i', $list_id);
		//$response = $stmt->execute();
		$stmt->execute();

		header("Refresh:0");
  }


//Remove specific task in a list if deletebutton is clicked

	/*/if (isset($_POST['deletetask'])) {

		$stmt = $db->prepare ("DELETE FROM tasks WHERE task_id = '$task_id'");
		//$stmt->bind_param('i', $list_id);
		//$response = $stmt->execute();
		$stmt->execute();

		header("Refresh:0");
	}
	/*/

?>

<h2>Add new list</h2>
<form action="todo.php" method="POST">
	<h3>List name</h3>
	<input type="text" name="newlist" placeholder="New List" class="inputField">
	<br>
	<input type="submit" name="submitlist" value="Create" class="button">
</form>

<h2>Add new task</h2>
<form action="todo.php" method="POST">
	<h3>Task name</h3>
	<input type="text" name="newtask" placeholder="Add Task" class="inputField">
	<br>
	<h3>Task description</h3>
	<input type="text" name="newtaskdesc" placeholder="Task Description" class="inputField">
	<br>
	<h3>Start date</h3>
	<input type="date" name="newStartDate" class="inputField">
	<br>
	<h3>End date</h3>
	<input type="date" name="newEndDate" class="inputField">
	<br>
	<h3>Select list</h3>
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
