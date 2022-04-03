<?php

    session_start();

    include('db_config.php');
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_error)
        {
            die("Connection error: " . $conn->connect_error);
        }

        $shortUrl = substr(md5(time()), 0, 6);

        $originalUrl = $_GET['originalUrl'];
        $title = $_GET['title'];
        $password = $_GET['password'];
        $userId = $_SESSION['userId'];
        $customUrl = $_GET['customUrl'];

        if($password=="")
        {
            $password = "-";
        }
        else
        {
            $password = hash('ripemd160', $password);
        }
        if($title=="")
        {
            $title = "-";
        }
        if($customUrl!="")
        {
            $result = $conn->query("SELECT * from url where short_url='$customUrl'");
            if ($result->num_rows > 0)
            {
                $_SESSION['shortUrl'] = "ERROR";
                header('Location: dash.php');
                exit();
            }
            else
            {
                $shortUrl = $customUrl;
            }
        }
        $sql = "INSERT INTO url (short_url,orig_url,title,password,user_id)
        VALUES ('$shortUrl','$originalUrl','$title','$password','$userId')";

            if ($conn->query($sql) === TRUE)
            {
                echo "Your data was entered successfully!";
            }
            else
            {
                echo "There was some problem adding your data!";
            }
        $_SESSION['shortUrl'] = $shortUrl;
        $_SESSION['urlPass'] = $password;
    header('Location: dash.php');
    exit();
?>