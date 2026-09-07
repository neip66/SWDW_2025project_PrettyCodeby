<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login / Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1 class="page-title">Login</h1>
<?php include 'menu.php'; ?>

<?php if (!empty($_SESSION['msg'])): ?>
    <script>
        alert("<?= $_SESSION['msg'] ?>");
    </script>
    <?php unset($_SESSION['msg']); ?>
<?php endif; ?>

<div class="loginbox">
    <div class="login-panel">
        <h2>Login Member</h2>
        <form action="checkLogin.php" method="post">
            <input type="text" name="username" placeholder="Username" required maxlength="10">
            <br>
            <input type="password" name="password" placeholder="••••••••" required maxlength="10">
            <br><br>
            <button class="btn" type="submit">Submit</button>
        </form>
    </div>

    <div class="register-panel">
        <h2>Register New Member</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required maxlength="10">
            <br>
            <input type="text" name="phone" placeholder="phone" required maxlength="10">
            <br><br>
            <span style="font-size: 1.2em;">Password:</span><br>
            <input type="password" name="password" placeholder="****" required maxlength="10">
            <br>
            <span style="font-size: 1.2em;">Confirm password:</span><br>
            <input type="password" name="confirm_password" placeholder="****" required maxlength="10">
            <br><br>
            <button class="btn" type="submit">Submit</button>
            <button class="btn" type="reset">Reset</button>
        </form>
    </div>
</div>

</body>
</html>