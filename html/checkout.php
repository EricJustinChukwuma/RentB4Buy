<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

// Redirect back to cart page if checkout is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: Cart.php");
};

// Set a minimum start date to be always 3 days from the current day the user chooses a start date
// This is to specify the duration of product delivery or pickup
$minStartDate = date('y-m-d', strtotime('+3 days'));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index3.css">
</head>
<body>
    
    <h2>Rental Checkout</h2>

    <form action="../includes/process_checkout.php" method="POST">
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

            <!-- DON'T FORGET TO DO JAVASCRIPT FORM VALIDATION -->

        <!-- <label>Delivery Address:</label><br>
        <textarea name="address" required></textarea><br><br> -->

        <input type="input" name="house-number" placeholder="house number" ><br><br>
        <input type="input" name="streetname" placeholder="Street name"><br><br>
        <input type="input" name="post-code" placeholder="Post Code... (OX5 2JS)"><br><br>
        <input type="input" name="town" placeholder="town" ><br><br>
        <input type="input" name="county" placeholder="county"><br><br>
        
        

        <label>Rental Start Date:</label><br>
        <input type="date" name="start_date" min="<?= $minStartDate ?>" required><br><br>

        <label>Rental Duration (days):</label><br>
        <input type="number" name="rental_days" min="1" required><br><br>

        <p class="cart-total-price">
            <?php echo "£" . $_SESSION['cart-total-price']; ?>
        </p>

        <label>Payment Method:</label><br>
        <select name="payment_method" required>
            <option value="card">Card (Simulated)</option>
            <option value="paypal">PayPal (Simulated)</option>
        </select><br><br>
        <div>

        <button id="comfirm-rental" name="comfirm-rental" type="submit">Confirm Rental</button>
    </form>

    <script>

    </script>
</body>
</html>


























