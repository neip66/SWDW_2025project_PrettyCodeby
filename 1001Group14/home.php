<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BNBU Memorabilia Store</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1 class="page-title">Welcome to the BNBU Memorabilia Store</h1>
<?php include 'menu.php'; ?>

<div style="padding: 20px; font-size: 1.2em;">
    <p>Browse our collection of <a href="clothes.php" style="color: blue;">clothes</a>,
       <a href="neces.php" style="color: blue;">necessities</a> and
       <a href="orna.php" style="color: blue;">ornaments</a>.</p>
    
    <?php if (empty($_SESSION['username'])): ?>
    <p>You can browse the site without logging in. To submit a purchase,
       you must <a href="login.php" style="color: blue;">log in</a> first.</p>
    <?php endif; ?>
</div>

</body>
</html>