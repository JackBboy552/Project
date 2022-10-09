<!DOCTYPE html>
<html>
<head>
<title>MANAGER | VIEW PRODUCT</title>
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
$sql = "SELECT * FROM product ";
$result = mysqli_query($con, $sql);
?>

<div class="wrapper">
	<div class="title">
		<h1>View Product</h1><br>
	</div>
	<form method="post">
	Search Product Name<input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
    <button class="button" name="searchBtn" type="submit">Search</button>
    </form>
	<?php
    include("conn.php");

    $search_key = "";

    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
    }

    $result=mysqli_query($con,"SELECT * FROM product WHERE product_name LIKE '%$search_key%' ORDER BY product_name");
    ?>
<table id="product">
	<tr>
        <th>Image</th>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Genre</th>
        <th>Price</th>
	</tr>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"; // alternative way is : echo ‘<trbgcolor="#99FF66">’;
        echo "<td>";
		echo '<img src="data:image;base64,'.base64_encode($row['image']).'" width="200px" height="250px" "alt="image">';
		echo "</td>";
		echo "<td>";
		echo $row['product_id'];
		echo "</td>";
		echo "<td>";
		echo $row['product_name'];
		echo "</td>";
        echo "<td>";
		echo $row['genre'];
		echo "</td>";
        echo "<td>";
		echo $row['price'];
		echo "</td>";
    }
} else {
    echo "0 results";
}

mysqli_close($con);
?>
</table>
<br><br><br>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<div id="footer"></div>
</body>
</html>