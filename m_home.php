<!DOCTYPE html>
<html>
<head>
<title>MANAGER | HOME</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header and footer -->
<script>
   $(function(){
   $("#header").load("m_header.php"); 
   });
</script> 
<link rel="stylesheet" href="css/m_home.css">
</head>
<body>
<div id="header"></div>
<br><br><br><br><br><br><br><br>
<div id="wrapper">
    <div id="row">
        <ul><h1>Manage Product</h1><br>
            <li><h3><a href="m_viewproduct.php">View Product</a></h3></li>
            <li><h3><a href="m_addproduct.php">Add Product</a></h3></li>
            <li><h3><a href="m_modifydelete.php">Modify/Delete Product</a></h3></li>
        </ul>
   </div>
   <div id="row">
        <ul><h1>Manage Order</h1><br>
            <li><h3><a href="m_vieworder.php">View Order</a></h3></li>
            <li><h3><a href="m_modifyorder.php">Modify Order</a></h3></li>
        </ul>
   </div>
   <div id="row">
        <ul><h1>Manage Customer</h1><br>
            <li><h3><a href="m_viewcustomer.php">View Customer Record</a></h3></li>
            <li><h3><a href="m_viewpayment.php">View Customer Payment</a></h3></li>
            <li><h3><a href="m_modifydeletecustomer.php">Modify/Delete Customer Record</a></h3></li>
        </ul>
   </div>
</div>
<br><br><br><br><br><br><br><br>
<div id="footer"></div>
</body>
</html>