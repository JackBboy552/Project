<!DOCTYPE html>
<html>
<head>
<title>MANAGER | VIEW CUSTOMERS</title>
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

<?php
include('conn.php');
// Check connection
$sql = "SELECT * FROM customer";
$result = mysqli_query($con, $sql);
?>
<div class="wrapper">
	<div class="title">
		<H2>Customers Details</H2>
	</div>
	<form method="post">
		Search Customer Email <input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
		<button class="button" name="searchBtn" type="submit">Search</button>
    </form>
	<?php
	include("conn.php");

    $search_key = "";

    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
    }

    $result=mysqli_query($con,"SELECT * FROM customer WHERE email LIKE '%$search_key%' ORDER BY c_name");
    ?>
    
<table id="contacts">
	<tr>
		<th>Customer ID</th>
		<th>Customer Name</th>
		<th>Email</th>
		<th>Password</th>
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
		echo "<a href=\"mailto:".$row['email']."\">".$row['email']."</a> "; // Hyperlink 
		echo "</td>";
		echo "<td>";
		echo $row['password'];
		echo "</td>";
    }
} else {
    echo "0 results";
}

mysqli_close($con);
?>
</table>
</div>



<div id="footer"></div>
</body>
</html>