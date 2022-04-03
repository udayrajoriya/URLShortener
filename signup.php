
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="signup1.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>
<body>


<center>
<div>
	
  <h2>Creat a new account</h2> 
  <form method="post">
    
    <input type="text" id="userName" name="userName" placeholder="Username" required ><br>
    <input type="text" id="fullName" name="fullName"placeholder="Full Name" required><br>
    <input type="email" id="email" name="email" placeholder="Email-id" required><br>
    <input type="password" id="pass" name="password" placeholder="Password" required><br>
    <input type="password" id="rePass" name="rePass" placeholder="Re-enter Password" required><br>
  
    <input type="submit" name="submit"value="Sign up">
  </form>
  
  <h4>Already have an account? <a href="login.php">Login</a></h4>
</div>
</center>
</body>

<?php
session_start();
include('db_config.php');
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error)
 {
   die("Connection error: " . $conn->connect_error);
 }
else{
    if(isset($_POST['submit']))
    {	 
    $userName = $_POST['userName'];
    $fullname = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rePass = $_POST['rePass'];
    $result = $conn->query("SELECT * from user where username='$userName'");
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
          echo "<center><h1>User name already exist</h2></center>";
        }
    }
    elseif($password!==$rePass){
      echo "<center><h1>repassword not match</h2></center>";
    }
    else
    {
      $sql = "INSERT INTO user (username,  
    full_name,email,password) VALUES('$userName',  
    '$fullname','$email','$password')";

    if (mysqli_query($conn, $sql)) {

      echo "<center><h1>created successfully !</h2></center>";
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
    } 
    else {
      echo "Error: " . $sql . "
      " . mysqli_error($conn);
    }
    mysqli_close($conn);
    
    }

	
  }
}
?>
</html>
