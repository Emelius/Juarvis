<?php
  include 'config.php';

  //establish db connection
  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
	if ($db->connect_error) {
		echo "could not connect: " . $db->connect_error;
		exit();
	}

  //get all lists and their tasks from DB
	$sql = "SELECT listname FROM list"; //where user_id = 'login_user'";
	$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "list: " . $row["listname"]. "";
    }
}

else{
      echo "0 results";
    }

  //display all lists and their tasks as a table?

$sql = "SELECT taskname FROM tasks where list_id = list_id"; //and user_id = 'login_user'";
	$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "list: " . $row["listname"]. "";
    }
}

else{
      echo "0 results";
    }

  //create new list
$sql = "INSERT INTO list (listname) VALUES (tomorrow)";

if ($db->query($sql) === TRUE) {
    echo "New list added";
}
else {
    echo "Error: " . $sql . "<br>" . $db->error;
}

$db->close();

  //in this list create new tasks
  //tasks should hold information such as taskname, taskdesc, sdate, edate, rdate, status(meaning if it is completed or not)

  //insert this new lists and tasks to DB

  //change task to completed and mark it as grey or other CSS

?>
