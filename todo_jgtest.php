<h3>Task list</h3>
<hr>
<?php
include 'config.php';


@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br><a href=index.php>Return to home page </a>");
    exit();
}

$query = "SELECT * FROM tasks"
$stmt = $db->prepare($query);
$stmt->bind_result($task_id, $taskname, $taskdesc, $sdate, $edate, $rdate, $status);
$stmt->execute();


echo '<table bgcolor="#dddddd" cellpadding="6">';
echo '<tr><b><td>Title</td> <td>Author</td> <td>Reserved?</td> <td>Reserve</td> </b> </tr>';
while ($stmt->fetch()) {
    if($reserved==0){
        $reserved="No";
        echo "<td> $title </td><td> $author </td> <td>$reserved</td>";
        echo '<td><a href="reserveBook.php?bookid=' . urlencode($book_id) .'title='.urlencode($title).' "> Reserve </a></td>';
    }
    else{
        $reserved="Yes";
        echo "<tr>";
        echo "<td> $title </td><td> $author </td> <td>$reserved</td><td>Already reserved</td>";
    }

    echo "</tr>";
}
echo "</table>";
?>
?>



<?php include("footer.php"); ?>
