<?php
	include("conn.php");
	//$_GET[âidâ] â Get the integer value from id parameter in URL.
	//intval() will returns the integer value of a variable
	$id = intval($_GET['id']);
	$result = mysqli_query($con,"DELETE FROM customer WHERE customer_id=$id");
	mysqli_close($con); //close database connection
    echo "<script>alert('Customer account deleted!'); 
    window.location.href='m_modifydeletecustomer.php';</script>";

	
?>