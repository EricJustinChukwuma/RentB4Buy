<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php";

// Fetches the GET Request query string from the form submit
$productId = $_GET['id'] ?? null;
if (!$productId) {
    die("No product ID provided.");
}

// Fetch product info
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :id");
$stmt->bindParam(":id", $productId);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

$successMessage = "";
$errorMessage = "";

// Handle update form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['product_name'];
    $desc = $_POST['description'];
    $price = floatval($_POST['price']);
    $ppd = floatval($_POST['price_per_day']);
    $qty = intval($_POST['available_qty']);
    $img = $_POST['product_image'];

    if ($name && $desc && $price && $ppd && $qty && $img) {
        $update = $pdo->prepare("UPDATE products 
                                 SET product_name = :name, description = :desc, price = :price, 
                                     price_per_day = :ppd, available_qty = :qty, product_image = :img 
                                 WHERE product_id = :id");
        $update->execute([
            ':name' => $name,
            ':desc' => $desc,
            ':price' => $price,
            ':ppd' => $ppd,
            ':qty' => $qty,
            ':img' => $img,
            ':id' => $productId
        ]);

        $successMessage = "✅ Product updated successfully!";
        // Refresh product data
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $errorMessage = "❌ Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product #<?= htmlspecialchars($product['product_id']) ?></h1>

    <?php if ($successMessage): ?>
        <p style="color: green;"><?= $successMessage ?></p>
    <?php elseif ($errorMessage): ?>
        <p style="color: red;"><?= $errorMessage ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required><br><br>

        <label>Price Per Day:</label><br>
        <input type="number" name="price_per_day" step="0.01" value="<?= htmlspecialchars($product['price_per_day']) ?>" required><br><br>

        <label>Available Quantity:</label><br>
        <input type="number" name="available_qty" value="<?= htmlspecialchars($product['available_qty']) ?>" required><br><br>

        <label>Product Image URL:</label><br>
        <input type="text" name="product_image" value="<?= htmlspecialchars($product['product_image']) ?>" required><br><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
