<!-- refer to https://www.youtube.com/watch?v=S9PpWeN-MrU&t=5s -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>
    <!--this is navigation bar-->
    <nav>
        <div class="mainlogo">
            <a href="m_home.php">
            <img src="images/intifudeLogo.png">
        </div>
        <div class="navBar">
        <ul>
            <?php
            session_start();
            if(isset($_SESSION['ic'])){
                echo "<li><a href='m_home.php'>Home</a></li>";
                echo "<li><a href='m_logout.php'>Logout</a></li>";
            }
            else{
                echo "<li><a href='m_login.php'>Login</a></li>";
            }
            ?>      
        </ul>
        </div>
    </nav>
    <!--end of navigation bar-->
</body>
</html>