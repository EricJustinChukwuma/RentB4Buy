<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php";

$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST['product_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = floatval($_POST['price']);
    $pricePerDay = floatval($_POST['price_per_day']);
    $availableQty = intval($_POST['available_qty']);
    $imagePath = $_POST['product_image'] ?? ''; // Assume URL or relative path for now

    if ($productName && $price && $pricePerDay && $availableQty) {
        $query = "INSERT INTO products (product_name, description, price, price_per_day, available_qty, product_image)
                VALUES (:name, :desc, :price, :ppd, :qty, :img)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":name", $productName);
        $stmt->bindParam(":desc", $description);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":ppd", $pricePerDay);
        $stmt->bindParam(":qty", $availableQty);
        $stmt->bindParam(":img", $imagePath);
        $stmt->execute();

        $successMessage = "✅ Product added successfully!";
    } else {
        $errorMessage = "❌ Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h1>Add New Product</h1>

    <?php if ($successMessage): ?>
        <p style="color: green;"><?= $successMessage ?></p>
    <?php elseif ($errorMessage): ?>
        <p style="color: red;"><?= $errorMessage ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="40" required></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Price Per Day:</label><br>
        <input type="number" step="0.01" name="price_per_day" required><br><br>

        <label>Available Quantity:</label><br>
        <input type="number" name="available_qty" required><br><br>

        <label>Product Image (URL or relative path):</label><br>
        <input type="text" name="product_image" required><br><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
