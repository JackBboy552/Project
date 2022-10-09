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
            <a href="home.php">
            <img src="images/intifudeLogo.png">
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <?php
            session_start();
            if(isset($_SESSION["email"])){
                echo "<li><a href='userprofile.php'>My Profile</a></li>";
                echo "<li><a href='cart.php'>Cart</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
            }
            else{
                echo "<li><a href='login.php'>Login</a></li>";
            }
            ?>            
        </ul>
        </div>
    </nav>
    <!--end of navigation bar-->
</body>
</html>