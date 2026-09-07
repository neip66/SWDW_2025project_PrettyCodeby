<?php
session_start();
include 'connectDB.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$phone    = $_POST['phone']    ?? '';

if ($username === '' || $password === '' || $phone === '') {
    $_SESSION['msg'] = 'All fields are required.';
    header("Location: login.php");
    exit;
}


$sql = "SELECT username, phone FROM members WHERE username = '$username' OR phone = '$phone'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['msg'] = 'Username or phone already exists.';
    header("Location: login.php");
    exit;
}

$sql = "INSERT INTO members (username, password, phone) VALUES ('$username', '$password', '$phone')";

if (mysqli_query($conn, $sql)) {
    // alert pop-out and redirect
    echo "<script>
            alert('Registration successful! Please login.');
            window.location.href = 'login.php';
          </script>";
    exit;
} else {
    $_SESSION['msg'] = 'Registration failed. Please try again.';
    header("Location: login.php");
    exit;
}