<?php
session_start();
$userId = $_SESSION['userId'];
//$password = $_SESSION['password'];
$userNameInSql =$_SESSION['username'];

include('db_config.php');
$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error)
{
    die("Connection error: " . $conn->connect_error);
}

$userName = $_POST['userName'];

$fullname = $_POST['fullName'];
$email = $_POST['email'];
$oldPass = $_POST['pass'];
$newPass = $_POST['newPass'];

// $sqlUser = $conn->query("SELECT username from user where username='$userName'");
// if($sqlUser!==$userNameInSql){
//       echo "<center><h1>User name already exist</h2></center>";
// }

// $sqlPassword = $conn->query("SELECT password from user where user_id='$userId'");
// if($oldPass!==$sqlPassword){
//     echo "<center><h1>invalid password</h2></center>";
// }

// $result = $conn->query("SELECT * from user where username='$userName'");
// if ($result->num_rows > 0)
// {   if(){
//     while ($row = $result->fetch_assoc())
//     {
//       echo "<center><h1>User name already exist</h2></center>";
//     }
//         }
// }
// elseif($password!==$rePass){
//   echo "<center><h1>repassword not match</h2></center>";
// }
 if(!$userName == Null && !$email == Null && !$oldPass==Null)
    {
        $result = $conn->query("SELECT * from user where username='$userName' and password='$oldPass'");
        if($result->num_rows > 0)
        {   if($newPass==Null)
            {
            $result = $conn->query("UPDATE user SET full_name='$fullname' ,email='$email' WHERE user_id =$userId");
            }
            else
            {
               $result = $conn->query("UPDATE user SET full_name='$fullname' ,email='$email',password='$newPass'  WHERE user_id =$userId"); 
            }
            if ($result === TRUE)
            {
             echo '<center><h1>Update successfully! please <a href="login.php">Login</a> Again</h1></center>';
            session_destroy();
            }
            else
            {
            echo "There was some problem adding your data!";

            }
        }

        else
        {
             echo "Check your credentials";
        }              
    
   
    }
     else
    {
             echo "Check your credentials";
    }              
    
   


    


?>

