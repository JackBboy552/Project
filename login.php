<!-- reference from https://www.youtube.com/watch?v=V8PU_geaCCU&t=11s -->
<?php
//sign up and post the record to database if customer click signup
if (isset($_POST['signup'])) {
   if($_POST['password']==$_POST['confirm_password']){
      include("conn.php");

      $sql = "INSERT INTO customer (c_name, email, password)
      VALUES
      ('$_POST[c_name]','$_POST[email]','$_POST[password]')";
      
      if (!mysqli_query($con, $sql)){
         die('Error: ' . mysqli_error($con));
      }else {
         echo '<script>alert("New customer account added successfully! Please login with your account to get access to the system!");
         window.location.href= "login.php";
         </script>';
      }
   
      mysqli_close($con);
   }
   else{
      echo '<script>alert("Invalid input details. Please check your details");
      window.location.href= "login.php";
      </script>';
   }
   
}

//include connect database and session
// session_start();
if (isset($_POST['login'])){
   session_start();
   include('conn.php');
   $email=$_POST["email"];
   $password=$_POST["password"];
   $result=mysqli_query($con,"SELECT * FROM customer WHERE email='$email' AND password='$password' limit 1"); //==+1

   //check if form data exist
   if(mysqli_num_rows($result)==1)  
   {
      //fetch data from database
      $data=mysqli_fetch_array($result);

      //gather form data to session
      $_SESSION['customer_id']=$data['customer_id'];
      $_SESSION['c_name']=$data['c_name'];
      $_SESSION['email']=$data['email'];
      $_SESSION['password']=$data['password'];
      //back to home
      echo"<script>
         alert('Welcome, {$_SESSION['c_name']}! You have successfully logged in.');</script>";
      echo"<script>window.location.href='home.php';</script>";
   }
   else
      echo"<script>
         alert('Failed to login. Please try again');
         window.history.back();
         </script>";
   }

?>

<!DOCTYPE html>
<html>
<head>
<title>USER | LOGIN/SIGNUP</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header and footer -->
<script>
   $(function(){
   $("#header").load("header.php"); 
   $("#footer").load("footer.php"); 
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
            User Login Form
         </div>
         <div class="title signup">
            User Signup Form
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
                  <input type="email" placeholder="Email Address" name="email" required>
               </div>
               <div class="field">
                  <input type="password" placeholder="Password" name="password" required>
               </div>
               <div class="field btn">
                 <div class="btn-layer"></div>
                 <input type="submit" value="Login" name="login">
               </div>
            </form>
            <form action="" class="signup" method="post">
               <div class="field">
                 <input type="text" name="c_name" placeholder="Full Name" required>
               </div>
               <div class="field">
               <input type="email" name="email" placeholder="Email Address" required>
               </div>
               <div class="field">
                  <input type="password" name="password" placeholder="Password" pattern="(?=.*?[#?!@$%^&*-_])(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
               </div>
               <div class="field">
                  <input type="password" name="confirm_password" placeholder="Confirm Password" pattern="(?=.*?[#?!@$%^&*-_])(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
               </div>
               <div id="message">
               <h4> Password must contain the following:</h4>
               <ul type = "circle">
                     <li id="letter" class="invalid">A Lowercase & Uppercase Letter</li>
                     <li id="number" class="invalid">A Number</li>
                     <li id="#" class="invalid">A Special Character</li>
                     <li id="length" class="invalid">Minimum 8 Characters</li>
               </ul>
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
<div id="footer"></div>
</body>
</html>