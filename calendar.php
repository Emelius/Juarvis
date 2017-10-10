<!doctype html>
<html>
    <head>
        <title>JUARVIS</title>
        <meta charset="utf-8"/>
        
        
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" type="text/css" href="main.css"/>
        
    </head>

<?php

//Set timezone
date_default_timezone_set("Europe/Stockholm");

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
      $week .='<td class="today">'.$day; 
  } else {
    $week .= '<td>'.$day;
 }
  $week .= '</td>';
  
  //End of the week OR End of the month 
  if($str % 7 == 6 || $day == $day_count) {
    
    if($day == $day_count){
      $week .= str_repeat('<td><a><a></td>',6-($str % 7));  
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

</html>
