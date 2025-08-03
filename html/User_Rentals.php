<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php";

$userId = $_GET['user_id'] ?? null;
if (!$userId) die("User ID missing.");

// Fetch user info
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = :id");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) die("User not found.");

// Fetch rental history
$sql = "SELECT rentals.*, products.product_name, products.product_image
        FROM rentals
        JOIN products ON rentals.product_id = products.product_id
        WHERE rentals.user_id = :user_id
        ORDER BY rentals.request_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($user['username']) ?>'s Rentals</title>
</head>
<body>
    <h2>Rental History: <?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Product</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Total (£)</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rentals): ?>
                <?php foreach ($rentals as $rental): ?>
                    <tr>
                        <td>
                            <img src="<?= $rental['product_image'] ?>" width="50"> 
                            <?= htmlspecialchars($rental['product_name']) ?>
                        </td>
                        <td><?= $rental['start_date'] ?></td>
                        <td><?= $rental['end_date'] ?></td>
                        <td><?= ucfirst($rental['rent_status']) ?></td>
                        <td>£<?= number_format($rental['total_price'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No rentals found for this user.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
