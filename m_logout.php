<?php
session_start();
header("location: m_login.php");
session_destroy();
?>