<!--Calendar code based on code from: http://codingwithsara.com/how-to-code-calendar-in-php/-->
<!doctype html>
<?php
    include("config.php");
    //Turn on output buffering
    ob_start();

    //Database connection
    @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
    if ($db->connect_error) {
      echo "could not connect: " . $db->connect_error;
      exit();
    }

    //sets $username = to the username thats used to login from session
    $username = $_SESSION['username'];

    //declare variables
    $taskname ='nothing';
    $edate ='no date';

    //checks if the url is ending on ex: active_day=2017-12-01. if true the selected date from the user is saved in a correct way.
    if (isset($_GET['active_day'])) {

      //if user have clicked on a day, set active day and ym to the clicked day in a strotime format
      //always set today to todays date
      //date is a function used to format date and time 
      $today = date('Y-m-d', time());
      $active_day = date("Y-m-d", strtotime($_GET['active_day']));
      $ym = date("Y-m", strtotime($_GET['active_day']));
    }

    // checks if ym is set ex:ym=2017-12
    else if (isset($_GET['ym'])) {
      $active_day = date("Y-m-d");
      $ym = $_GET['ym'];
    }

    else {
      //if user has not clicked on a day, set active day and ym variable to this month
      $active_day = date("Y-m-d");
      $ym = date('Y-m');
    }

    //When you log in, alert what tasks due today. Not so beautiful so we decided not to include it
    // function alert(){
    //    //set variables
    //    $username = $_SESSION['username'];
    //    $today = date('Y-m-d', time());
    //
    //    //db connection
    //    @ $db = new mysqli('localhost', 'root', '', 'juarvis');
    //    if ($db->connect_error) {
    //      echo "could not connect: " . $db->connect_error;
    //      exit();
    //    }
    //
    //    //get tasks
    //    $sql1 ="SELECT taskname FROM tasks JOIN lists on tasks.list_id = lists.list_id JOIN users on lists.user_id = users.user_id WHERE users.username = '$username' AND tasks.edate = '$today' ";
    //    $result = mysqli_query($db, $sql1);
    //    $new_array = array();
    //
    //    while( $row = mysqli_fetch_assoc($result)){
    //      $new_array[] = $row;
    //    }
    //
    //    if (!empty($new_array)) {
    //        echo
    //        "<script type='text/javascript'>
    //          alert('Tasks due today:";
    //
    //       foreach ($new_array as $value){
    //              print_r($value['taskname']);
    //            }
    //
    //        echo
    //          "');
    //        </script>";
    //     }
    // }
    // alert();

    //the query that asks for taskname and edate from db where the depending on which user is logged in and which date you have clicked on in the calendar.
    $sql ="SELECT task_id, taskname, edate FROM tasks JOIN lists on tasks.list_id = lists.list_id JOIN users on lists.user_id = users.user_id WHERE users.username = '$username' AND tasks.edate = '$active_day' ";
    $stmt = $db ->prepare($sql);
    $stmt->bind_result($task_id, $taskname, $edate);
    $stmt->execute();

    //Set timezone to Sweden
    date_default_timezone_set("Europe/Stockholm");

    //Check format
    //timestamp specifies a timestamp and the default is the current date and time
    //strtotime is a function used to convert a human readable string to a Unix time
    $timestamp = strtotime($ym, "-01");
    if ($timestamp === false) {
      $timestamp = time();
    }

    //for h3 title
    $html_title = date('Y/m', $timestamp);

    //Create prev & next month link mktime(hour, minute, second, month, day, year)
    //mktime() function returns the Unix timestamp for a date. 
    //The Unix timestamp contains the number of seconds between the Unix Epoch (January 1 1970 00:00:00 GMT) and the time specified.
    $prev = date('Y-m', mktime(0,0,0, date('m',$timestamp)-1, 1, date('Y',$timestamp)));
    $next = date('Y-m', mktime(0,0,0, date('m',$timestamp)+1, 1, date('Y',$timestamp)));

    //Number of days in the month
    $day_count = date('t', $timestamp);

    //0:sun, 1:mon, 2:tues ...
    $str = date('w', mktime(0,0,0, date('m',$timestamp), 1, date('Y',$timestamp)));

    //Create calendar
    $weeks = array();
    $week = '';

    //$active_day='';
    //Add empty cell
    $week .=str_repeat('<td></td>',$str);
    for ($day = 1; $day <= $day_count; $day++, $str++) {

    //making sure that the date is always displayed with two digits (1=01, 10=10)
      $day2 = sprintf("%02d", $day);
      //sves the full date in $date
      $date = $ym.'-'.$day2;
      $today = date('Y-m-d', time());

    //Checks if the $active_day = the $date and if so sets the class clickedday to that day.
    if($active_day == $date) {
          $week .="<td class='clickedday'><a href='?active_day=$ym-$day'>".$day;
    }

    //if that is not true it checks if the date is todays date and then gives the day the class today.
    else if ($today == $date){
          $week .="<td class='today'><a href='?active_day=$ym-$day'>".$day;
    }

    else {
          $week .= "<td><a href='?active_day=$ym-$day'>".$day;
    }

    //and then sets everyday in a list called week which is the table rows.
      $week .= '</a></td>';

    //Checks if its the end of the week OR End of the month
      if($str % 7 == 6 || $day == $day_count) {
        if($day == $day_count){
          $week .= str_repeat('<td></td>',6-($str % 7));
        }
        $weeks[] = '<tr>'.$week.'</tr>';
        //Prepare for a new week
        $week = '';
      }
    }

?>

<div class="calendardiv">
  <h2>
    <a href="?ym=<?php echo $prev; ?>"> &lt;<a/>
      <?php echo $html_title; ?>
    <a href="?ym=<?php echo $next; ?>"> &gt;</a>
  <h2>
  <br>
  <table class="table table-bordered">
    <tr>
      <th>S</th>
      <th>M</th>
      <th>T</th>
      <th>W</th>
      <th>T</th>
      <th>F</th>
      <th>S</th>
    </tr>

    <?php
          foreach($weeks as $week){
              echo $week;
          }
    ?>
  </table>

<?php
    //echos out the tasks for the current day and the date of the day.
    echo "<h3> Tasks due the " .$active_day."</h3>";
      echo "<ul id='calendarList'>";

      //fetches the data from the sql query on row 80, loops through this data and displays the taskname in a list for that date.
      while ($stmt->fetch()) {
           echo "<br />";
           printf("%s  ", "<li class= calendarTasks>".$taskname."</li>");

            echo "<form method='post' action='main.php'>";
            echo "<input class='deleteButton2' type='submit' name='deletetask' value='remove'/>";
            echo "<input type='hidden' name='id' value='$task_id'/>";
            echo "</form>";
        }

?>
  </ul>
  <?php
    //task deleteion in calendar
    if (isset($_POST['deletetask'])) {

      //hidden id from the echo:d form is used to determine which task should be deleted
      $id = $_POST['id'];

      $stmt = $db->prepare ("DELETE FROM tasks WHERE task_id = '$id'");
      $stmt->execute();
    }
  ?>

</div>
