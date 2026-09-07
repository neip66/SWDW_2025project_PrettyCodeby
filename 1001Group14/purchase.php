<?php
session_start();
include 'connectDB.php';
include 'priceName.php';

$category = $_POST['category'] ?? '';
$qty      = $_POST['qty']      ?? [];

$validCats = ['clothes', 'neces', 'orna'];
$returnPage = in_array($category, $validCats, true) ? "$category.php" : 'home.php';

// Must be logged in to submit an order.
if (empty($_SESSION['username'])) {
    header("Location: $returnPage");
    exit;
}

$bought = [];
$total  = 0;

foreach ($qty as $itemN => $q) {
    $q = (int)$q;
    if ($q <= 0) continue; // Only process positive quantities
    if (!isset($ITEMS[$itemN])) continue;
    if ($ITEMS[$itemN]['category'] !== $category) continue;

    // Add the new quantity to the running total to correctly track Best Sellers
    $sql = "UPDATE purchase SET quantity = quantity + $q WHERE itemN = '$itemN'";
    mysqli_query($conn, $sql);

    $sub = $ITEMS[$itemN]['price'] * $q;
    $bought[] = [
        'name'     => $ITEMS[$itemN]['name'],
        'price'    => $ITEMS[$itemN]['price'],
        'qty'      => $q,
        'subtotal' => $sub,
    ];
    $total += $sub;
}

if (empty($bought)) {
    header("Location: $returnPage");
    exit;
}

// Pass receipt data to receipt.php via session.
$_SESSION['receipt'] = [
    'items'    => $bought,
    'total'    => $total,
    'category' => $category,
];
header("Location: receipt.php");
exit;
?>