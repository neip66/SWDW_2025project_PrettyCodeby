<?php
// More Features (2): print a receipt after a successful purchase.
session_start();
$receipt = $_SESSION['receipt'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container">
    <h1>Receipt</h1>

    <?php if (!$receipt): ?>
        <p class="warning">No recent purchase to show.</p>
    <?php else: ?>
        <p class="success">
            Order submitted successfully.
            Thank you, <?= $_SESSION['username'] ?>!
        </p>
        <table class="items">
            <tr>
                <th>Item</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach ($receipt['items'] as $r): ?>
            <tr>
                <td><?= $r['name'] ?></td>
                <td>$<?= (int)$r['price'] ?></td>
                <td><?= (int)$r['qty'] ?></td>
                <td>$<?= (int)$r['subtotal'] ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>$<?= (int)$receipt['total'] ?></strong></td>
            </tr>
        </table>
        <br>
        <a href="<?= $receipt['category'] ?>.php">
            Back to <?= $receipt['category'] ?>
        </a>
        <?php unset($_SESSION['receipt']); ?>
    <?php endif; ?>
</div>
</body>
</html>
