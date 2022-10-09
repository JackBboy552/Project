<?php
//sign up and post the record to database if customer click signup
if (isset($_POST['signup'])) { 
   if ($_POST['password']==$_POST['confirm_password']){
   include("conn.php");

   $sql = "INSERT INTO kitchen (k_name, ic, password)
   VALUES
   ('$_POST[k_name]','$_POST[ic]','$_POST[password]')";
   
   if (!mysqli_query($con, $sql)){
      die('Error: ' . mysqli_error($con));
   }else {
      echo '<script>alert("New kitchen account added successfully! Please login with your account to get access to the system!");
      window.location.href= "k_login.php";
      </script>';
   }

   mysqli_close($con);
   }
   else {
      echo '<script>alert("Invalid input details. Please check your details");
      window.location.href= "k_login.php";
      </script>';
   }
}
//include connect database and session
// session_start();
if (isset($_POST['login'])){

   include('conn.php');
   $ic=$_POST["ic"];
   $password=$_POST["password"];
   $result=mysqli_query($con,"SELECT * FROM kitchen WHERE ic='$ic' AND password='$password' limit 1"); //==+1

   //check if form data exist
   if(mysqli_num_rows($result)==1)  
   {
      //fetch data from database
      $data=mysqli_fetch_array($result);

      //gather form data to session
      session_start();
      $_SESSION['ic']=$data['ic'];
      $_SESSION['k_name']=$data['k_name'];
      $_SESSION['password']=$data['password'];

      //back to home
      echo"<script>
         alert('Welcome, {$_SESSION['k_name']}! You have successfully login.');
         </script>";
      echo"<script>window.location.href='k_home.php';</script>";
   }
   else
      echo"<script>
         alert('Failed to login.');
         window.history.back();
         </script>";
   }

?>

<!DOCTYPE html>
<html>
<head>
<title>KITCHEN | LOGIN/SIGNUP</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header -->
<script>
   $(function(){
   $("#header").load("k_header.php"); 
   });
</script> 
<!-- login -->
<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div id="header"></div>
   <!--this is login-->
   <div class="wrapper">
      <div class="title-text">
         <div class="title login">
            Kitchen Login Form
         </div>
         <div class="title signup">
            Kitchen Signup Form
         </div>
      </div>
      <div class="form-container">
         <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
         </div>
         <div class="form-inner">
            <form action="#" class="login" method="post">
               <div class="field">
                  <input type="text" placeholder="IC" name="ic" required>
               </div>
               <div class="field">
                  <input type="password" placeholder="Password" name="password" required>
               </div>
               <div class="field btn">
                 <div class="btn-layer"></div>
                 <input type="submit" value="Login" name="login">
               </div>
            </form>
            <!-- INSERT.PHP is here -->
            <form action="" class="signup" method="post">
               <div class="field">
                 <input type="text" name="k_name" placeholder="Full Name" required>
               </div>
               <div class="field">
               <input type="text" name="ic" placeholder="IC" required>
               </div>
               <div class="field">
                  <input type="password" name="password" placeholder="Password" required>
               </div>
               <div class="field">
                  <input type="password" name="confirm password" placeholder="Confirm password" required>
               </div>
               <div class="field btn">
                  <div class="btn-layer"></div>
                  <input type="submit" value="Signup" name="signup">
               </div>
            </form>
         </div>
      </div>
   </div>
   <script>
      const loginText = document.querySelector(".title-text .login");
      const loginForm = document.querySelector("form.login");
      const loginBtn = document.querySelector("label.login");
      const signupBtn = document.querySelector("label.signup");
      const signupLink = document.querySelector("form .signup-link a");
      signupBtn.onclick = (()=>{
         loginForm.style.marginLeft = "-50%";
         loginText.style.marginLeft = "-50%";
      });
      loginBtn.onclick = (()=>{
         loginForm.style.marginLeft = "0%";
         loginText.style.marginLeft = "0%";
      });
      signupLink.onclick = (()=>{
         signupBtn.click();
         return false;
      });
   </script>
   <br>
   <br>
   <br>
   <br>
   <br>
</body>
</html>
