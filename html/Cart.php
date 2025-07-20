<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Remove an item from cart
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}


$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids)");
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Your Rental Cart</h1>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li>
                    <?php echo htmlspecialchars($item['name']); ?> - £<?php echo htmlspecialchars($item['price_per_day']); ?>/day
                    <a href="cart.php?remove=<?php echo $item['product_id']; ?>">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="checkout.php">Proceed to Checkout</a>
    <?php endif; ?>
</body>
</html>