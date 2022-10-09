<?php
session_start();
if (!isset($_SESSION['customer_id']))
{
  //header("location: login.php");
  echo "<script>alert('Please login!'); window.location.href='login.php';</script>";
}
?>