<?php
    //get pid and oid from the link and store into variable
    session_start();
	include("conn.php");
	$product_id =intval($_GET['pid']);
    $c_order_id =intval($_GET['oid']);
	$result = mysqli_query($con,"DELETE FROM order_detail 
    WHERE c_order_id=$c_order_id AND product_id=$product_id");


	mysqli_close($con); //close database connection
    
	header('Location: cart.php'); //redirect the page to cart.php page
?>

