<?php
session_start();
if(array_key_exists('login', $_POST))
{
		            login(); 
}
function login()
{
  include('db_config.php');
  $conn = new mysqli($host, $user, $password, $db);
  if ($conn->connect_error)
  {
      die("Connection error: " . $conn->connect_error);
  }
  $userName = $_POST['userName'];
  $password = $_POST['password'];
  $result = $conn->query("SELECT * from user where username='$userName' and password='$password'");
	
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
		        {
              $_SESSION['username'] = $userName;
              $_SESSION['userId'] = $row['user_id'];
              $_SESSION['fullname'] = $row['full_name'];
              $_SESSION['email'] = $row['email'];
              $_SESSION['password'] = $row['password'];
            
              header('Location: dash.php');
              exit();
            }
        }
        else
        {
          echo "<h4>Please check your Username and Password!</h4>";
        }
}
  

?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="login2.css">
       
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>
<body>


<center>
<div>
  <h2>Login</h2>

  <form method="POST">
    
    <input type="text" id="userName" name="userName" placeholder="Username" required><br>

    <input type="password" id="password" name="password" placeholder="password" required><br>
  
    <input type="submit" name= "login" value="Login">
  </form>
  <h4>Don't have an account? <a class ="account "href="signup.php">Signup</a></h4>
</div>
</center>
</body>
</html>
