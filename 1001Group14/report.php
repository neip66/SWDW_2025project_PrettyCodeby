<?php
session_start();
include 'connectDB.php';
include 'priceName.php';

$result = mysqli_query($conn,
    "SELECT category, itemN, price, quantity
       FROM purchase
      WHERE quantity > 0
      ORDER BY quantity DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Best Sellers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1 class="page-title">Best Sellers</h1>
<?php include 'menu.php'; ?>

<div style="padding: 20px; font-size: 1.2em;">
    <p>Items sorted by total quantity sold.</p>

    <?php if (mysqli_num_rows($result) === 0): ?>
        <p>No purchases have been made yet.</p>
    <?php else: ?>
    <table class="items">
        <tr>
            <th>Category</th>
            <th>Item</th>
            <th>Unit Price</th>
            <th>Total Sold</th>
            <th>Revenue</th>
        </tr>
        <?php
        $grand = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $displayName = $ITEMS[$row['itemN']]['name'] ?? $row['itemN'];
            $revenue = (int)$row['price'] * (int)$row['quantity'];
            $grand  += $revenue;
        ?>
        <tr>
            <td><?= $row['category'] ?></td>
            <td><?= $displayName ?></td>
            <td>$<?= (int)$row['price'] ?></td>
            <td><?= (int)$row['quantity'] ?></td>
            <td>$<?= $revenue ?></td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Grand Total Revenue</strong></td>
            <td><strong>$<?= $grand ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
</div>

</body>
</html>