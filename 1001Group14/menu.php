<?php
// Shared navigation menu — included at the top of every page.
// session_status() avoids "session already started" warnings.
// https://www.w3schools.com/php/php_sessions.asp
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="clothes.php">Clothes</a>
    <a href="neces.php">Necessities</a>
    <a href="orna.php">Ornaments</a>
    <a href="report.php">Best Sellers</a>
    <?php if (!empty($_SESSION['username'])): ?>
        <span class="welcome">Welcome, <?= $_SESSION['username']?></span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login / Register</a>
    <?php endif; ?>
</div>
