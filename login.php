

//@ $db = new mysqli('localhost', 'root', '', 'juarvis');
//session_start();
 


<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
	   $myusername = htmlentities($myusername);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
	   $mypassword = htmlentities($mypassword);
      
      $sql = "SELECT id FROM admin WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         
         header("location: main.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<div class="login-form">
			<div class="top-login">
				<span><img src="img/group.png" alt=""/></span>
			</div>
			<h1>Welcome to Juarvis!</h1>
			<div class="login-top">
			<form>
				<div class="login-ic">
					<i ></i>
					<input type="text"  value="username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User name';}"/>
					<div class="clear"> </div>
				</div>
				<div class="login-ic">
					<i class="icon"></i>
					<input type="password"  value="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"/>
					<div class="clear"> </div>
				</div>
			
				<div class="log-bwn">
					<input type="submit"  value="Login" >
				</div>
				</form>
			</div>
</div>		
</body>
</html>
