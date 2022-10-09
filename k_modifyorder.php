<!DOCTYPE html>
<html>
<head>
<title>KITCHEN | MODIFY ORDER</title>
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
<link rel="stylesheet" href="css/k_viewproduct.css">
</head>
<body>
<div id="header"></div>
<br><br><br><br><br><br><br><br>
<?php
include('conn.php');
$sql = "SELECT * FROM c_order, customer.c_name INNER JOIN customer ON c_order.customer_id=customer.customer_id ";
$result = mysqli_query($con, $sql);
?>

<div class="wrapper">
	<div class="title">
		<h1>KITCHEN | Modify Order</h1><br>
	</div>
    <form method="post">
	Search Order ID  <input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
    <button class="button" name="searchBtn" type="submit">Search</button>
    </form>
    <?php
    include("conn.php");

    $search_key = "";

    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
    }

    $result=mysqli_query($con,"SELECT * FROM c_order INNER JOIN customer ON c_order.customer_id=customer.customer_id  WHERE c_order_id LIKE '%$search_key%' ORDER BY c_name");
    ?>

<table id="product">
	<tr>
		<th>Customer ID</th>
		<th>Customer Name</th>
        <th>Order ID</th>
		<th>Status</th>
		<th>Update Order</th>
	</tr>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { ?>
        <?php
        include('conn.php');
        if (isset($_POST["update"])){
            include('conn.php');

            $customer_id=$_POST["customer_id"];
            $order_id=$_POST["c_order_id"];
            $status=$_POST["status"];

            $sql = "UPDATE c_order 
            SET status = '$status'

            WHERE c_order_id = $order_id";
            mysqli_query($con, $sql);
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Record updated!'); 
                window.location.href='k_modifyorder.php';</script>";
                }
            else { 
                echo "<script>alert('Could not update!'); 
                window.location.href='k_modifyorder.php';
                </script>"; }

            mysqli_close($con);
        }
        ?>
       <form method="post"> 
        <tr>
		<td>
            <?php echo $row['customer_id'];?>
		</td>
		<td>
            <?php echo $row['c_name'];?>
            <!-- <input type="text" value="<?php echo $row['c_name'];?>" name="customer_name"> -->
		</td>
        <td>
            <?php echo $row['c_order_id'];?>
            <input type="hidden" name="c_order_id" value="<?php echo $row['c_order_id'];?>">
		</td>
        <td>
            <input value="<?php echo $row['status'];?>" name="status">
        </td>
        <td>
            <button type="submit" class="updateBtn" name="update">Update</button>
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
<br><br><br><br><br><br><br><br><br><br><br><br>
<div id="footer"></div>
</body>
</html>