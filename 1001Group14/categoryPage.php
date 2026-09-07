<?php
// Shared page body for clothes.php / neces.php / orna.php.
$isLoggedIn = !empty($_SESSION['username']);
$loggedInJs = $isLoggedIn ? 'true' : 'false';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $pageTitle ?> - BNBU Store</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function checkLogin() {
        var loggedIn = <?= $loggedInJs ?>;
        if (!loggedIn) {
            alert("Please log in first.");
            return false;
        }
        return true;
    }
    </script>
</head>
<body>

<h1 class="page-title"><?= $pageTitle ?></h1>
<?php include 'menu.php'; ?>

<form action="purchase.php" method="post" onsubmit="return checkLogin();">
    <input type="hidden" name="category" value="<?= $category ?>">
    
    <table class="items">
        <?php foreach (getItemsByCategory($category) as $itemN => $info): ?>
        <tr>
            <td>
                <img src="images/<?= $category ?>/<?= $itemN ?>.png" alt="<?= $info['name'] ?>">
            </td>
            <td>
                <?= $info['name'] ?><br><br>
                Unit Price: <?= (int)$info['price'] ?>
            </td>
            <td>
                Quantity (0 to 9): 
                <input type="number"
                       name="qty[<?= $itemN ?>]"
                       value="0" min="0" max="9"
                       style="width:50px">
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <div class="btn-container">
        <button class="btn" type="submit">Submit</button>
        <button class="btn" type="button" onclick="document.querySelectorAll('input[type=number]').forEach(i => i.value=0)">Reset</button>
    </div>
</form>

</body>
</html>