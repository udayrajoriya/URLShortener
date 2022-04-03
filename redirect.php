<?php
session_start();
include('db_config.php');

if(array_key_exists('pass', $_POST))
		        {
		            checkPassword(); 
                }
                
function checkPassword()
{
    include('db_config.php');
    $shortUrl = $_GET['shortUrl'];
    $pass = $_POST['pass'];
    
    $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error)
        {
            die("Connection error: " . $conn->connect_error);
        }
        $pass = hash('ripemd160', $pass);
        $result = $conn->query("SELECT * from url where short_url='$shortUrl' and password='$pass'");
	
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
		    {
                    $url = $row['orig_url'];
                    header("Location: {$url}");
                    exit();
            }
        }
        else
        {
            echo "Your entered password was incorrect!";
        }
}

if(isset($_GET['shortUrl']))
    {
        $shortUrl = $_GET['shortUrl'];
        
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error)
        {
            die("Connection error: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * from url where short_url='$shortUrl'");
	
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
		    {
                if($row['password']=="-")
                {
                    $url = $row['orig_url'];
                    header("Location: {$url}");
                    exit();
                }
                else
                {
                    ?>
                    <form method="post">
                        <h3>
                            Please enter password to access link:
                            <input type="textbox" name="pass"></input>
                            <button type="submit">Visit</button>
                        </h3>
                    </form>
                    <?php
                }
                
            }
        }
        else
        {
            header('Location: index.php');
            exit();
        }
    }
else
{
    header('Location: index.php');
    exit();
}


?>