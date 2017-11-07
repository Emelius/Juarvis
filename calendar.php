<!doctype html>
<?php
include("config.php");
include("session.php");
ob_start();
//Database connection
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
}
//sets $username = to the username thats used to login from session
$username = $_SESSION['username'];
$taskname ='nothing';
$edate ='no date';
//checks if the url is ending on ex: active_day=2017-12-01. if true the selected date from the user is saved in a correct way.
if (isset($_GET['active_day'])) {
  //if user have clicked on a day, set active day and ym to the clicked day in a strotime format
  //today
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

//the query that asks for taskname and edate from db where the depending of whichc user is logged in and which date you have clicked on in the calendar.
$sql ="SELECT taskname, edate FROM tasks JOIN lists on tasks.list_id = lists.list_id JOIN users on lists.user_id = users.user_id WHERE users.username = '$username' AND tasks.edate = '$active_day' ";
$stmt = $db ->prepare($sql);
$stmt->bind_result($taskname, $edate);
$stmt->execute();
$tasklist = array();
//Set timezone
date_default_timezone_set("Europe/Stockholm");
//Check format
$timestamp = strtotime($ym, "-01");
if ($timestamp === false) {
  $timestamp = time();
}

//for h3 title
$html_title = date('Y/m', $timestamp);
//Create prev & next month link mktime(hour, minute, second, month, day, year)
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
  <h3>
    <a href="?ym=<?php echo $prev; ?>"> &lt;<a/>
      <?php echo $html_title; ?>
    <a href="?ym=<?php echo $next; ?>"> &gt;</a>
  <h3>
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
 echo "<h3> Tasks do the " .$active_day."</h3>";
   while ($stmt->fetch()) {
        echo "<br />";
        printf("%s  ", $taskname);
         //$tasklist[$edate[2]] = array("taskname" => $taskname, "edate" => explode("-", $edate));
     }
  ?>
</div>
