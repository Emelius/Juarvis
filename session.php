<?php
if (isset($_SESSION['userip']) === false){

    #here we store the IP into the session 'userip'
    $_SESSION['userip'] = $_SERVER['REMOTE_ADDR'];
}

#now we check if the IP where the session is generated is the same as the IP of the current user

if ($_SESSION['userip'] !== $_SERVER['REMOTE_ADDR']){
    #if it is not the same, we just remove all session variables
    #this way the attacker will have no session
    session_unset();
    session_destroy();

}
   include('config.php');
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  //echo $_SESSION['username'];
//checks if a session is set and sends it forward to the main page
   if(
     (!isset($_SESSION['username']) && (!isset($_SESSION['user_id']))))
   {
     header("location:login.php");
   }
?>
