<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: Cart.php");
    exit();
}

$minStartDate = date('Y-m-d', strtotime('+3 days'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rental Checkout</title>
    <link rel="stylesheet" href="../css/index3.css">
</head>
<body>

<h2>Rental Checkout</h2>

<form action="../includes/checkout_process.php" method="POST">
    <h3>Order Summary</h3>
    <ul>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li>
                <img src="<?= htmlspecialchars($item['product_image']) ?>" width="180" height="160">
                <?= htmlspecialchars($item['product_name']) ?> - 
                £<?= htmlspecialchars($item['price_per_day']) ?>/day × <?= $item['quantity'] ?> qty
            </li>
        <?php endforeach; ?>
    </ul>

    <input type="text" name="house_number" placeholder="House number" required><br><br>
    <input type="text" name="street_name" placeholder="Street name" required><br><br>
    <input type="text" name="post_code" placeholder="Post code" required><br><br>
    <input type="text" name="town" placeholder="Town" required><br><br>
    <input type="text" name="county" placeholder="County" required><br><br>

    <label>Rental Start Date:</label><br>
    <input type="date" name="start_date" min="<?= $minStartDate ?>" required><br><br>

    <label>Rental Duration (days):</label><br>
    <input type="number" name="rental_days" min="1" required><br><br>

    <label>Payment Method:</label><br>
    <select name="payment_method" required>
        <option value="card">Card</option>
        <option value="paypal">PayPal</option>
    </select><br><br>

    <div>
        <input type="text" name="card-holder-name" placeholder="Card Name">
        <input type="text" name="card-number" placeholder="Card Number">
        <input type="text" name="expiry-date" placeholder="Expiry Date">
        <input type="text" name="cvv" placeholder="CVV">
    </div>
    

    <p>Total: <strong>£<?= $_SESSION['cart-total-price'] ?></strong></p>

    <button type="submit">Confirm Rental</button>
</form>

</body>
</html>
