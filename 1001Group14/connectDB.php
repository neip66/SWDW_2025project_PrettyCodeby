<?php

// Adjust $db to match the database name you created in phpMyAdmin.

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bnbu";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>
