<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT rentals.*, products.product_name, products.product_image, products.price_per_day, products.price
          FROM rentals 
          JOIN products ON rentals.product_id = products.product_id 
          WHERE rentals.user_id = :user_id 
          ORDER BY rentals.request_date DESC";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rentals</title>
    <style>
        .rental-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .rental-card img {
            max-width: 120px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <h1>My Rentals</h1>

    <?php if (empty($rentals)): ?>
        <p>You have not rented any products yet.</p>
        <a href="./product_page.php">Rent Now</a>
    <?php else: ?>
        <?php foreach ($rentals as $rental): ?>
            <div class="rental-card">
                <img src="<?= htmlspecialchars($rental['product_image']) ?>" alt="<?= htmlspecialchars($rental['product_name']) ?>">
                <h3><?= htmlspecialchars($rental['product_name']) ?></h3>
                <p><strong>Status:</strong> <?= htmlspecialchars($rental['rent_status']) ?></p>
                <p><strong>Quantity:</strong> <?= $rental['quantity'] ?></p>
                <p><strong>Rental Period:</strong> <?= $rental['start_date'] ?> to <?= $rental['end_date'] ?></p>
                <p><strong>Total Cost:</strong> £<?= number_format($rental['total_price'], 2) ?></p>

                <?php
                    $today = date('Y-m-d');
                    $rentalExpired = ($rental['end_date'] < $today);
                ?>

                <?php if ($rental['rent_status'] === 'pending'): // checks if rental status of the current row of product in rentals is equal to pending?>
                    <form method="POST" action="../includes/cancel_rentals.php">
                        <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
                        <button type="submit">Cancel</button>
                    </form>
                <?php endif; ?>

                <?php if ($rentalExpired && in_array($rental['rent_status'], ['active', 'overdue'])): // checks if the rent_status which is an ENUM contains two element 'active' and 'overdue' ?>
                    <form method="POST" action="../includes/return_rental.php" style="display:inline;">
                        <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
                        <button type="submit">Return</button>
                    </form>

                    <?php
                        $discountedPrice = $rental['price'] - $rental['total_price'];
                        if ($discountedPrice < 0) $discountedPrice = 0;
                    ?>
                    <form method="POST" action="../includes/buy_rental.php" style="display:inline;">
                        <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
                        <input type="hidden" name="product_id" value="<?= $rental['product_id'] ?>">
                        <input type="hidden" name="amount" value="<?= $discountedPrice ?>">

                        <label>Cardholder Name:</label>
                        <input type="text" name="cardholder_name" required>

                        <label>Card Number:</label>
                        <input type="text" name="card_number" maxlength="16" required>

                        <label>Expiry Date (MM/YYYY):</label>
                        <input type="text" name="expiry_date" placeholder="MM/YYYY" required>

                        <label>CVV:</label>
                        <input type="text" name="cvv" maxlength="4" required>


                        <button type="submit">Buy for £<?= number_format($discountedPrice, 2) ?></button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>

