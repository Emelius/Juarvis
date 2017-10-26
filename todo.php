<!--- reference: https://gist.github.com/hcmn/3773595 !--->

<?php
  include 'config.php';

  //establish db connection
  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

  //get and display all lists from DB
	$sql = "SELECT listname FROM list"; //where user_id = 'login_user'";
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

$sql2 = "SELECT taskname FROM tasks where list_id = list_id"; //and user_id = 'login_user'";
	$result2 = mysqli_query($db, $sql2);

$listname = "";

if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
        echo "". $row["taskname"]. "<br>";
    }
}

else{
      echo "0 results";
    }

  //create new list

if (isset($_POST) && !empty($_POST)) {
    # Get data from form
   	$newlist = "";
	$newlist = trim($_POST['newlist']);

	if (!$newlist) {
		printf("You must add a listname, try again.");
		exit();
	    }

	$stmt = $db->prepare("insert list (list_id, listname) VALUES ('', ?)");
	    $stmt->bind_param('s', $newlist);
	    $stmt->execute();
	    printf("<br>List Added!");
	header("Refresh:0");
}

  //create new task for specific list: taskname, taskdesc, sdate, edate, rdate, status(1)

if (isset($_POST) && !empty($_POST)) {
    # Get data from form
   	$newtask = "";
	$newtask = trim($_POST['newtask']);

	if (!$newtask) {
		printf("You must add a task, try again.");
		exit();
	    }

	$stmt = $db->prepare("insert tasks (task_id, taskname) VALUES ('', ?)");
	    $stmt->bind_param('s', $newlist);
	    $stmt->execute();
	    printf("<br>Task Added!");
	header("Refresh:0");
}


$query = " select ISBN, Author, Title, Reserved from Book";
                if ($searchtitle && !$searchauthor) { // Title search only
                    $query = $query . " where Title like '%" . $searchtitle . "%'";
                }
                if (!$searchtitle && $searchauthor) { // Author search only
                    $query = $query . " where Author like '%" . $searchauthor . "%'";
                }
                if ($searchtitle && $searchauthor) { // Title and Author search
                    $query = $query . " where Title like '%" . $searchtitle . "%' and Author like '%" . $searchauthor . "%'"; // unfinished
                }


  //change task status to completed and mark it as grey or other CSS

?>

<form action="todo.php" method="POST">
	<input type="text" name="newlist" placeholder="New List" class="inputField">
  <br>
  <input type="submit" name="submit" value="Add" class="button">
</form>

<form action="todo.php" method="POST">
	<input type="text" name="newtask" placeholder="Add Task" class="inputField">
	<br>
	<input type="text" name="newtaskdesc" placeholder="Task Description" class="inputField">
	<br>
	<select name="List">
		<option value="hej">Hejsan</option>	
	</select>
	<input type="submit" name="submit" value="Add" class="button">
</form>
