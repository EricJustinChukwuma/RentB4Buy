<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in.");
}

$user_id = $_SESSION['user_id'];

// SELECTS ALL RENTALS FROM RENTALS TABLE AND ALL PRODUCTS NAME AND IMAGE FROM PRODUCTS TABLE 
// WHERE PRODUCT_ID IN PRODUCTS TABLE IS EQUAL TO PRODUCT_ID IN RENTALS TABLE AND RENT_STATUS IS EQUAL TO 'RETURNED'
$query = "SELECT rentals.*, products.product_name, products.product_image 
          FROM rentals 
          JOIN products ON rentals.product_id = products.product_id 
          WHERE rentals.user_id = :user_id AND rentals.rent_status = 'returned'
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
    <title>Document</title>
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
    <h1>My Rental History</h1>

    <?php if (empty($rentals)): ?>
        <p>You have not rented any products before.</p>
    <?php else: ?>
        <?php foreach ($rentals as $rental): ?>
            <div class="rental-card">
                <img src="<?= htmlspecialchars($rental['product_image']) ?>" alt="<?= htmlspecialchars($rental['product_name']) ?>" width="100">
                <h3><?= htmlspecialchars($rental['product_name']) ?></h3>
                <p><strong>Status:</strong> <?= htmlspecialchars($rental['rent_status']) ?></p>
                <p><strong>Quantity:</strong> <?= htmlspecialchars($rental['quantity']) ?></p>
                <p><strong>Rental Period:</strong> <?= htmlspecialchars($rental['start_date']) ?> to <?= $rental['end_date'] ?></p>
                <p><strong>Total Cost:</strong> £<?= htmlspecialchars($rental['total_price']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
