<?php

include("conn.php");

$sql="INSERT INTO contacts (contact_name, contact_phone, contact_email, contact_gender, contact_relationship, contact_dob)

VALUES

('$_POST[name]','$_POST[phone_num]','$_POST[email_address]','$_POST[gender]','$_POST[relationship]',
'$_POST[dob]')";

if(!mysqli_query($con,$sql)) {
    die('Error: '.mysqli_error($con));
}
else {
    echo '<script>alert("1 record added!");
    window.location.href= "view.php";
    </script>';
    }

mysqli_close($con);

?>