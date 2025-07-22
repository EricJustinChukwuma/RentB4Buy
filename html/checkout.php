<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login.php");
    exit();
}

// 
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id <= 0) {
    die("Invalid product.");
}

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :product_id");
$stmt->execute([':product_id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - <?php echo htmlspecialchars($product['product_name']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
    <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" width="300">
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price per day:</strong> £<?php echo htmlspecialchars($product['price_per_day']); ?></p>
    <p><strong>Available Quantity:</strong> <?php echo htmlspecialchars($product['available_qty']); ?></p>

    <form action="checkout_process.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
        <label for="rental_days">Start Date:</label>
        <input type="date" name="start_date" id="start_date"  required>
        <br>
        <label for="rental_days">End Date:</label>
        <input type="date" name="end_date" id="end_date"  required>
        <button type="submit">Confirm Rental</button>
    </form>
</body>
</html>
