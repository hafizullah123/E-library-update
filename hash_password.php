<?php
$password = "admin123"; // your desired password
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;
?>
