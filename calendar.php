// insert calendar here, show dates that have tasks //

<? php
  include ('header.php');
?>

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
$html_title = date('Y/n', $timestamp);

//Create prev & next month link mktime(hour, minute, second, month, day, year)
$prev = date('Y-m', mktime(0,0,0 date('m',$timestamp)-1, 1, date('Y',$timestamp)));
$next = date('Y-m', mktime(0,0,0 date('m',$timestamp)+1, 1, date('Y',$timestamp)));

//Number of days in the month
$day_count = date('t', $timestamp);

//0:sun, 1:mon, 2:tues ... 
$str = date('Y-m', mktime(0,0,0 date('m',$timestamp), 1, date('Y',$timestamp)));

//Create calendar
$weeks = array();
$week = '';

//Add empty cell
$week .=str_repeat('<td></td>',$str);

for ($day = 1; $day <= $day_count; $day++) {
 
  $date = $ym.'-'.$day;
  
  if($today == $date) {
      $week .='<td class="today">'.$day; 
  } else {
    $week .= '<td>'.$day;
 }
  $week .= '</td>';
  
  //End of the week OR End of the month 
  if($str % 7 == 6 || $day == $day_count) {
    
    if($day == $day_count)
     
  } 
  
}

?>

<div class="container">
  <h3><a>back<a/>October 2017<a>forward</a><h3>
  <br>
  <table class="table.table-bordered">
    <tr class="week">
      <th>S</th>
      <th>M</th>
      <th>T</th>
      <th>W</th>
      <th>T</th>
      <th>F</th>
      <th>S</th>
    </tr>
    <tr class="week">
      <td>1</td>
      <td>2</td>
      <td>3</td>
      <td>4</td>
      <td>5</td>
      <td>6</td>
      <td>7</td>
    </tr>
    <tr class="week">
      <td>8</td>
      <td class="today">9</td>
      <td>10</td>
      <td>11</td>
      <td>12</td>
      <td>13</td>
      <td>14</td>
    </tr>
    <tr class="week">
      <td>15</td>
      <td>16</td>
      <td>17</td>
      <td>18</td>
      <td>19</td>
      <td>20</td>
      <td>21</td>
    </tr>
    <tr class="week">
      <td>22</td>
      <td>23</td>
      <td>24</td>
      <td>25</td>
      <td>26</td>
      <td>27</td>
      <td>28</td>
    </tr>
    <tr class="week">
      <td>29</td>
      <td>30</td>
      <td>31</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
 </table>
</div> 
