
<body>
  <form action="insert.php" method="post">
  Name : <input type="text" name="username">
  <br/>
  Email : <input type="text" name="email">
  <br/>
  <input type="submit" value="insert">
</form>



<?php
  $con = mysqli_connect('juarvis','root','');
  if(!$con)
  {
   echo 'Not Connected To Server';
  }
  if (!mysqli_select_db ($con,'tutorial'))
  {
   echo 'Database Not Selected';
  }

  $Name = $_POST('username');
  $Email = $_POST('email');


  $sql = "insert into person (Name,Email) values ('$Name','$Email')";

  if (!mysqli_query($con,$sql))
  {
   echo 'Not Inserted';
  }

  else
  {
   echo 'Inserted Successfully';
  }

  header("refresh:2; url=index.html");


?>
