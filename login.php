
<? php 
	include('header.php');
?>

<?php

@ $db = new mysqli('localhost', 'root', '', 'juarvis');

if ($db->connect_error) {
    echo "could not connect: " . $db->connect_error;
    printf("<br>login failed");
    exit();
}

    #the mysqli_real_espace_string function helps us solve the SQL Injection
    #it adds forward-slashes in front of chars that we can't store in the username/pass
    #in order to excecute a SQL Injection you need to use a ' (apostrophe)
    #Basically we want to output something like \' in front, so it is ignored by code and processed as text

if (isset($_POST['username'], $_POST['userpass'])) {
    #SQL Injection-proof
    $uname = htmlentities($_POST['username']);
    $uname = mysqli_real_escape_string($db, $_POST['username']);
    
    #here we hash the password, and we want to have it hashed in the database as well
    #optimally when you create a user (through code) you simply send a hash
    #hasing can be done using different methods, MD5, SHA1 etc.
    
    $upass = sha1($_POST['userpass']);
    
    $query = ("SELECT * FROM users WHERE username = '{$uname}' "." AND hash = '{$upass}'");
       
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->store_result(); 
    
    #here we create a new variable 'totalcount' just to check if there's at least
    #one user with the right combination. If there is, we later on print out "access granted"
    $totalcount = $stmt->num_rows();
    
    
    
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
					<input type="text"  value="User name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User name';}"/>
					<div class="clear"> </div>
				</div>
				<div class="login-ic">
					<i class="icon"></i>
					<input type="password"  value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"/>
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
