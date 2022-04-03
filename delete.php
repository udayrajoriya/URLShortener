<?php
session_start();
if(!isset($_SESSION['username']))
{
  header('Location: index.php');
  exit();
}
else
{
    $urlId = $_POST['urlId'];
    include('db_config.php');
    $conn = new mysqli($host, $user, $password, $db);
	
	if ($conn->connect_error)
	{
		die("Connection error: " . $conn->connect_error);
    }
    $sql = "DELETE FROM url WHERE url_id='$urlId'";

    if (mysqli_query($conn, $sql))
    {
        echo "Record deleted successfully";
    }
    else
    {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    header('Location: dash.php#tab');
    exit();
}
?>