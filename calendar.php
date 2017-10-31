<!doctype html>
<?php
include("config.php");
//include("session.php");
ob_start();
@ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
if ($db->connect_error) {
  echo "could not connect: " . $db->connect_error;
  exit();
}
$username = $_SESSION['username'];
//echo "$username";
$taskname ='nothing';
$edate ='nothing';
$stmt = $db ->prepare("SELECT taskname, edate FROM tasks JOIN lists on tasks.list_id = lists.list_id JOIN users on lists.user_id = users.user_id WHERE users.username = '$username'");
$stmt->bind_result($taskname, $edate);
$stmt->execute();
$tasklist = array();

while ($stmt->fetch()) {
    printf("%s %s\n", $taskname, $edate);
    $tasklist[] = array("taskname" => $taskname, "edate" => $edate);
    echo "$takslist";
}
//Set timezone
date_default_timezone_set("Europe/Stockholm");
$test="hej";
echo ($taskname);

//Get prev & next month
if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  //this month
  $ym = date('Y-m');
}

//Check format
$timestamp = strtotime($ym, "-01");
if ($timestamp === false) {
  $timestamp = time();
}
//today
$today = date('Y-m-d', time());

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

//Add empty cell
$week .=str_repeat('<td></td>',$str);

for ($day = 1; $day <= $day_count; $day++, $str++) {

  $date = $ym.'-'.$day;

  if($today == $date) {
      $week .='<td class="today"><a href="">'.$day ;
  } else {
    $week .= '<td><a href="">'.$day;
 }
  $week .= '</a></td>';

  //End of the week OR End of the month
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

<div class="container">
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
</div>
