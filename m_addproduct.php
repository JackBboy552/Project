<!DOCTYPE html>
<html>
<head>
<title>MANAGER | ADD PRODUCT</title>
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
if (isset($_POST["upload"])){
    include('conn.php');
    //store post variable into a variable
    //$image=$_POST["image"];
    $product_name=$_POST["product"];
    $genre=$_POST["genre"];
    $price=$_POST["price"];
    
    $image = $_FILES['image']['tmp_name'];
	$img = file_get_contents($image); //get binary data
	$sql = "INSERT INTO product (product_name, genre, price, image) 
    VALUES
    ('$product_name', '$genre',$price, ?)";
	$stmt = mysqli_prepare($con,$sql);
	mysqli_stmt_bind_param($stmt,"s",$img);
	mysqli_stmt_execute($stmt);
	$check = mysqli_stmt_affected_rows($stmt);
	if($check == 1) { 
		echo '<script>alert("Product added successfully!"); 
        window.location.href="m_addproduct.php";</script>'; } 
	else { 
		echo '<script>alert("Product could not upload!"); 
        window.location.href="m_addproduct.php";</script>';  }

    mysqli_close($con);
}
?>

<div class="wrapper">
	<div class="title">
		<h1>Add Product</h1><br>
	</div>
<form method="post" ENCTYPE="multipart/form-data">
<table id="product">
	<tr>
        <th>Image</th>
		<th>Dish Name</th>
		<th>Genre</th>
        <th>Price</th>
	</tr>
    <tr>
        <td>
            <input type="file" accept="image/png, image/jpeg" name="image" required>
        </td>
        <td>
            <input type="text" id="row" name="product" placeholder="Maggi" required>
        </td>
        <td>
            <input type="text" id="row" name="genre" placeholder="Food / Beverage" required>
        </td>
        <td>
            <input type="number" id="row" name="price" placeholder="10" min="0" required>
        </td>
    </tr>

</table>
<br><br><br>
<input type="submit" name="upload" value="Upload Product" class="btn">
</form>
<br><br><br>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<div id="footer"></div>
</body>
</html>