<!DOCTYPE html>
<html>
<head>
<title>MANAGER | MODIFY/DELETE CUSTOMER</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header and footer -->
<script>
   $(function(){
   $("#header").load("m_header.php"); 
   $("#footer").load("m_footer.php"); 
   });
</script> 
<link rel="stylesheet" href="css/m_viewproduct.css">
</head>
<body>
<div id="header"></div>

<br><br><br><br><br><br><br><br>
<?php
include('conn.php');
$sql = "SELECT * FROM customer ";
$result = mysqli_query($con, $sql);
?>

<div class="wrapper">
	<div class="title">
		<h1>Modify/Delete Customer</h1><br>
	</div>
    <form method="post">
	Search Customer ID <input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
    <button class="button" name="searchBtn" type="submit">Search</button>
    </form>
    <?php
    include("conn.php");

    $search_key = "";

    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
    }

    $result=mysqli_query($con,"SELECT * FROM customer WHERE customer_id LIKE '%$search_key%' ORDER BY customer_id");
    ?>

<table id="product">
	<tr>
        <th>Customer ID</th>
		<th>Customer Name</th>
		<th>Email</th>
		<th>Password</th>
        <th>Update Account</th>
        <th>Remove Account</th>
	</tr>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { ?>
        <?php
        include('conn.php');
        if (isset($_POST["update"])){

            // $manufacturer=$_POST["manufacturer"];
            $customer_id=$_POST["customer_id"];
            $name=$_POST["name"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            

            $sql = "UPDATE customer 
            SET c_name = '$name',
            email = '$email',
            password = '$password'

            WHERE customer_id = $customer_id";
            mysqli_query($con, $sql);
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Record updated!'); 
                window.location.href='m_modifydeletecustomer.php';</script>";
                }
            else { 
                echo "<script>alert('Could not update!'); 
                window.location.href='m_modifydelete.php';
                </script>"; }

            mysqli_close($con);
        }
        ?>
        <form method="post">
        <tr>
		<td>
        <input type="hidden" value="<?php echo $row['customer_id'];?>" name="customer_id">
        <?php echo $row['customer_id'];?>
		</td>

        <td>
        <input type="text" value="<?php echo $row['c_name'];?>" name="name">
		</td>

        <td>
        <input type="text" value="<?php echo $row['email'];?>" name="email">
		</td>

        <td>
        <input type="text" value="<?php echo $row['password'];?>" name="password">
		</td>

        <td>
        <button type="submit" class="updateBtn" name="update">Update</button>
        </td>

        <td>
        <?php 
        $remove = "<a href='deletecustomer.php?id={$row['customer_id']}' style='text-decoration: none; color: #000000';>Remove</a>";
        echo $remove;
        ?>
		</td>
        </tr>
        </form>
    <?php
    }
} else {
    echo "0 results";
}

mysqli_close($con);
?>
</table>
<br><br><br>

<br><br><br>
</div>


<div id="footer"></div>
</body>
</html>