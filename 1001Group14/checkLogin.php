<?php
session_start();
include 'connectDB.php';
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
if ($username === '' || $password === '') {    
$_SESSION['msg'] = 'Please enter username and password.';    
header("Location: login.php");    
exit;
}
// Prepared statement avoids SQL injection.
// https://www.w3schools.com/php/php_mysql_prepared_statements.asp
$sql = "SELECT username FROM members WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 1) {    
$row = mysqli_fetch_assoc($result);    
$_SESSION['username'] = $row['username'];    
header("Location: home.php");    
exit;
}
$_SESSION['msg'] = 'Invalid username or password.';
header("Location: login.php");
exit;