<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php";

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->bindParam(":id", $_POST['delete_id'], PDO::PARAM_INT);
    $stmt->execute();
    header("Location: admin_products.php");
    exit();
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY product_id ASC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <link rel="stylesheet" href="../styles/admin.css"> <!-- Optional styling -->
</head>
<body>
    <h1>📦 Manage Products</h1>

    <a href="add_products.php">+ Add New Product</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Price/Day</th>
                <th>Qty</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><img src="<?= $product['product_image'] ?>" width="60"></td>
                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                        <td>£<?= $product['price'] ?></td>
                        <td>£<?= $product['price_per_day'] ?>/day</td>
                        <td><?= $product['available_qty'] ?></td>
                        <td>
                            <a href="edit_products.php?id=<?= $product['product_id'] ?>">✏️ Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete this product?');" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?= $product['product_id'] ?>">
                                <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M232.7 69.9C237.1 56.8 249.3 48 263.1 48L377 48C390.8 48 403 56.8 407.4 69.9L416 96L512 96C529.7 96 544 110.3 544 128C544 145.7 529.7 160 512 160L128 160C110.3 160 96 145.7 96 128C96 110.3 110.3 96 128 96L224 96L232.7 69.9zM128 208L512 208L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 208zM216 272C202.7 272 192 282.7 192 296L192 488C192 501.3 202.7 512 216 512C229.3 512 240 501.3 240 488L240 296C240 282.7 229.3 272 216 272zM320 272C306.7 272 296 282.7 296 296L296 488C296 501.3 306.7 512 320 512C333.3 512 344 501.3 344 488L344 296C344 282.7 333.3 272 320 272zM424 272C410.7 272 400 282.7 400 296L400 488C400 501.3 410.7 512 424 512C437.3 512 448 501.3 448 488L448 296C448 282.7 437.3 272 424 272z"/></svg> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
