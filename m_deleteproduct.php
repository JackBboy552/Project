<?php
	include("conn.php");
	$product_id =intval($_GET['pid']);
	$result = mysqli_query($con,"DELETE FROM product 
    WHERE product_id=$product_id");


	mysqli_close($con); //close database connection

    echo "<script>alert('Record deleted!'); 
    window.location.href='m_modifydelete.php';</script>";

?>
