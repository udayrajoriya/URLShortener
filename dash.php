<?php
session_start();
if(!isset($_SESSION['username']))
{
  header('Location: index.php');
  exit();
}
  $userName = $_SESSION['username'];
  $userId = $_SESSION['userId'];
  $fullname = $_SESSION['fullname'];
  $email = $_SESSION['email'];
  //$password = $_SESSION['password'];
  
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="dash1.css">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

</head>
<body>
  <div class="topnav">
    <a >URL Shortener</a>
    <div class="topnav-right">
        <a href="#dashboard">Dashboard</a>
        <a href="#tab">View</a>
        <a href="#profile">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
  </div>

<center>

<div class="section1" id="dashbord">

<h3>Welcome <?php echo $userName; ?> to the dashboard!</h3>
  <form action="process.php" class="shorten">
    
    <input type="text" id="title" name="title" placeholder="Title">
    <input type="text" id="orgUrl" name="originalUrl" placeholder="Enter URL(*)" required>
    <input type="text" id="cutUrl" name="customUrl" placeholder="Enter Custom Short Code">
    <input type="password" id="pass" name="password" placeholder="Password">
	
    <input type="submit" value="Submit" href="#hisory">
  

  </form>
  <br>
  <?php
if(isset($_SESSION['shortUrl']))
{
    if($_SESSION['shortUrl']==="ERROR")
    {
        echo "Custom URL not available! Please use another custom URL.";
    }
    else
    {
        echo "<h1 class='textbox'>Here is your shortened URL</h1><p class='shortenurl'> <a href=\"http://localhost/url_shortener/" . $_SESSION['shortUrl'] . "\">http://localhost/url/".$_SESSION['shortUrl']."</h1></a></p>";
    }
}
  ?>
</div>

<div id="tab">
	<h4 id="history">History</h4>

  <?php
include('db_config.php');
$conn = new mysqli($host, $user, $password, $db);
	
	if ($conn->connect_error)
	{
		die("Connection error: " . $conn->connect_error);
	}

	$result = $conn->query("SELECT * from url where user_id='$userId'");
	
	if ($result->num_rows > 0)
	{
    ?>
    
<table style="width:100%">
  <tr>
    <th>Title</th>
    <th>Shortend URL</th> 
    <th>Original URL</th>
    <th>Created On</th>
    <th>Password</th>
    <th></th>
  </tr>
    <?php
    while ($row = $result->fetch_assoc())
		{
      echo "<tr>";
      echo "<td class=\"title\">";
        echo $row['title'];
      echo "</td>";
      echo "<td>";
      echo "<a target='_blank' href=\"http://localhost/url_shortener/" . $row['short_url'] . "\" >http://localhost/url/".$row['short_url']."</a>";

      echo "</td>";
      echo "<td>";
     
      echo $row['orig_url'];
        
      echo "</td>";
      echo "<td>";
        echo $row['created_on'];
      echo "</td>";
      echo "<td>";
        if($row['password']==="-")
        {
            echo "-";
        }
        else
        {
          echo "**********";
        }
      echo "</td>";
      echo "<td>
      <form action=\"delete.php\" method=\"POST\">
      <input type=\"hidden\" name=\"urlId\" value=\"". $row['url_id']."\">
      <button type=\"submit\"class=\"button button1\">Delete</button>
      </form>
      </td>";
    echo "</tr>";
    }
  }
  else
  {
    echo "<h2>You have not shortened any URL yet!</h2>";
  }
  ?>
</table>
</div>


<div id="profile">
	
  <h2>Profile update</h2>

  <form action ="update.php" method="POST">
    
    <input type="text" id="userName" name="userName" value="<?php echo $userName?>" placeholder="User name" readonly> <br>
    <input type="text" id="fullName" name="fullName" value="<?php echo $fullname;?>" placeholder="Full Name" required> <br>
    <input type="text" id="email" name="email" value="<?php echo $email?>" placeholder="Email" required> <br>
    <input type="password" id="pass" name="pass"placeholder="Enter old password" required> <br>
    <input type="password" id="newPass"name="newPass" placeholder="Enter new password" > <br> 
    <input type="submit" name="update" value="Update">
  </form> 
</div>
</center>

</body>
</html>
