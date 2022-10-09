<!DOCTYPE html>
<html>
<head>
<title>USER - PROFILE</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header -->
<script> 
$(function(){
  $("#header").load("header.php"); 
});
</script> 
<!-- head remaining section -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/product.css">
<!-- font awesome -->
<script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
</head>
<link rel="stylesheet" href="css/m_viewproduct.css">
<link rel="stylesheet" href="css/profile.css">
</head>
<body>
<div id="header"></div>
<!-- remaining section -->
<div class="wrapper">

    <br><br>
    <div class="tab">
        <button class="tablinks" onclick="openProfile(event, 'Details')" id="defaultOpen">Details</button>
        <button class="tablinks" onclick="openProfile(event, 'Puchase_History')">Purchase History</button>
    </div>
    <div id="Details" class="tabcontent">
        <?php
        include("conn.php");
        session_start();
        //store session[customer id] as a integer
        $customer_id=$_SESSION['customer_id'];

        $sql = "SELECT * FROM customer WHERE customer_id=$customer_id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if (isset($_POST["update"])){
            if ($_POST['password']==$_POST['confirm_password']){
                include('conn.php');
                $c_id=$_SESSION['customer_id'];
                $name=$_POST['c_name'];
                $email=$_POST['email'];
                $password=$_POST['password'];
            
                $sql = "UPDATE customer 
                SET c_name = '$name',
                email = '$email',
                password = '$password'
    
                WHERE customer_id = $c_id";
                mysqli_query($con, $sql);
                if (mysqli_query($con, $sql)) {
                    echo "<script>alert('Profile updated!'); 
                    window.location.href='userprofile.php';</script>";
                    }
                else { 
                    echo "<script>alert('Could not update!'); 
                    window.location.href='userprofile.php';
                    </script>"; }
            }
            else{
                echo "<script>alert('Invalid input details. Please check your details!'); 
                window.location.href='userprofile.php';
                </script>"; 
            }

        }   
        ?>

        <form method="post">
            <div class="profile">
                <center><h1>DETAILS</h1></center><br>
                <div class="field">
                    <h2>Name</h2>
                    <input value="<?php echo $row['c_name'];?>" placeholder="Name" type="text" name="c_name" required>
                </div>

                <div class="field">
                    <h2>Email Address</h2>
                    <input value="<?php echo $row['email'];?>" placeholder="Email Address" type="text" name="email" required>
                </div>

                <div class="field">
                    <h2>Password</h2>
                    <input value="<?php echo $row['password'];?>" placeholder="Password" pattern="(?=.*?[#?!@$%^&*-_])(?=.*[a-z])(?=.*[A-Z]).{8,}" type="text" name="password" required>
                </div>

                <div class="field">
                    <h2>Confirm Password</h2>
                    <input value="" method="post" type="password" placeholder="Confirm Password" name="confirm_password" required>
                </div>
                <br>
                <div class="btn-layer">
                    <center>
                        <button style="color: white;"  type="submit" class="update" name="update" width="900px"><b>UPDATE</b></button>
                    </center>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br>
        </form>
    </div>
    <div id="Puchase_History" class="tabcontent">
        <center><h1>PURCHASE HISTORY</h1></center>
        <br>
        <table id="table">
            <tr>
                <th>Name</th>
                <th>Payment ID</th>
                <th>Card Number</th>
                <th>Order ID</th>
                <th>Order Status</th>
                <th>Payment Date</th>
                <th>Total</th>
            </tr>
        <?php
        //session_start();
        //store session[customer id] as a integer
        $customer_id=$_SESSION['customer_id'];
        $result=mysqli_query($con,"SELECT * FROM payment
        inner join customer 
        ON payment.customer_id=customer.customer_id 
        inner join c_order
        ON payment.customer_id=c_order.customer_id 
        WHERE c_order.c_order_id= payment.c_order_id
        AND customer.customer_id = $customer_id
        ORDER BY payment.payment_id");
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                // $c_num=$row['card_num'];
                // 
                // <script>
                //     function getTruncatedCCNumber($c_num){
                //         $last4Digits    = preg_replace( "#(.*?)(\d{4})$#", "$2", $c_num);
                //         $firstDigits    = preg_replace( "#(.*?)(\d{4})$#", "$1", $c_num);
                //         return preg_replace("#(\d)#", "*", $firstDigits) . $last4Digits;
                //     }
                // </script>
                // <?php
                echo "<tr>"; // alternative way is : echo ‘<trbgcolor="#99FF66">’; 
                echo "<td>";
                echo $row['c_name'];
                echo "</td>";
                echo "<td>";
                echo $row['payment_id'];
                echo "</td>";
                echo "<td>";
                echo $row['card_num'];
                echo "</td>";
                echo "<td>";
                echo $row['c_order_id'];
                echo "</td>";
                echo "<td>";
                echo $row['status'];
                echo "</td>";
                echo "<td>";
                echo $row['date'];
                echo "</td>";
                echo "<td>";
                echo $row['total'];
                echo "</td>";
            }
        } else {
            echo "0 results";
        }
        ?>
        </table>   
    </div>
</div>
<?php
        mysqli_close($con);
?>
</body>
</html>

<script>
function openProfile(event, profile) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(profile).style.display = "block";
  evt.currentTarget.className += " active";
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
