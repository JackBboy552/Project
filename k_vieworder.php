<!DOCTYPE html>
<html>
<head>
<title>KITCHEN | VIEW CUSTOMERS ORDER</title>
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

<?php
include('conn.php');
// Check connection
$sql = "SELECT * FROM c_order inner join customer ON c_order.customer_id=customer.customer_id ";
$result = mysqli_query($con, $sql);
?>
<div class="wrapper">
	<div class="title">
		<H2>Customer Orders</H2>
	</div>
	<form method="post">
		Search Status <input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
		<button class="button" name="searchBtn" type="submit">Search</button>
		<button name="view_all" type="submit">View All</button>
    </form>
	<?php
	include("conn.php");
	$result = mysqli_query($con, 'SELECT * FROM c_order inner join customer ON c_order.customer_id=customer.customer_id');
    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
	$result=mysqli_query($con,"SELECT * FROM c_order inner join customer ON c_order.customer_id=customer.customer_id  WHERE status LIKE '$search_key' ORDER BY c_order_id");
    }
	if(isset($_POST['view_all'])){
	$result = mysqli_query($con, 'SELECT * FROM c_order inner join customer ON c_order.customer_id=customer.customer_id ');
	}
    ?>
<table id="contacts">
	<tr>
		<th>Customer ID</th>
		<th>Customer Name</th>
		<th>Order ID</th>
		<th>Status</th>
	</tr>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"; // alternative way is : echo ‘<trbgcolor="#99FF66">’;
        echo "<td>";
		echo $row['customer_id'];
		echo "</td>";
        echo "<td>";
		echo $row['c_name'];
		echo "</td>";
		echo "<td>";
		echo $row['c_order_id'];
		echo "</td>";
		echo "<td>";
		echo $row['status'];
		echo "</td>";
    }
} else {
    echo "0 results";
}

mysqli_close($con);
?>
</table>
</div>
</body>
</html>