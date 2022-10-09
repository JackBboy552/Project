<!DOCTYPE html>
<html>
<head>
<title>MAANGER | MODIFY/DELETE PRODUCT</title>
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
		<h1>Modify/Delete Product</h1><br>
	</div>
    <form method="post">
	Search Product ID  <input type="text" style="width: 250px; padding: 8px; margin: 3px 0 11px 0; display: inline-block; font-size:12pt;" name="search_key"> 
    <button class="button" name="searchBtn" type="submit">Search</button>
    </form>
    <?php
    include("conn.php");

    $search_key = "";

    if(isset($_POST['searchBtn'])){
    $search_key = $_POST['search_key'];
    }

    $result=mysqli_query($con,"SELECT * FROM product WHERE product_id LIKE '%$search_key%' ORDER BY product_name");
    ?>

<table id="product">
	<tr>
        <th>Image</th>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Genre</th>
        <th>Price</th>
        <th>Update Item</th>
        <th>Remove Item</th>
	</tr>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) { ?>
        <?php
        include('conn.php');
        if (isset($_POST["update"])){
            include('conn.php');

            // $manufacturer=$_POST["manufacturer"];
            $product_id=$_POST["product_id"];
            $product=$_POST["product"];
            $genre=$_POST["genre"];
            $price=$_POST["price"];
            

            $sql = "UPDATE product 
            SET product_name = '$product',
            genre = '$genre',
            price = $price

            WHERE product_id = $product_id";
            mysqli_query($con, $sql);
            if (mysqli_query($con, $sql)) {
                echo "<script>alert('Record updated!'); 
                window.location.href='m_modifydelete.php';</script>";
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
		<?php echo '<img src="data:image/png;base64,' . base64_encode($row['image']) . '" width="150px" height="200px"/>'?> 
        <input type="hidden" value="<?php echo $row['product_id'];?>" name="product_id">
        </td>

		<td>
        <?php echo $row['product_id'];?>
		</td>

		<td>
        <textarea name="product" cols="20" rows="10"><?php echo $row['product_name'];?></textarea>
		</td>

        <td>
        <input value="<?php echo $row['genre'];?>" name="genre">
		</td>

        <td>
        <input type="number" min="0" value="<?php echo $row['price'];?>" name="price">
		</td>

        <td>
        <button type="submit" class="updateBtn" name="update">Update</button>
        </td>

        <td>
        <?php 
        $remove = "<a href='m_deleteproduct.php?pid={$row['product_id']}' style='text-decoration: none; color: #000000';>Remove</a>";
        echo $remove;
        ?>
		</td>
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