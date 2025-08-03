<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php"; // Only allows admin access

// HANDLE FILTER INPUT
$statusFilter = $_GET['status'] ?? ''; // Gets URL query string and sets it to an empty string if empty
$dateFilter = $_GET['date'] ?? '';

// Build base SQL
$sql = "SELECT rentals.*, users.username, products.product_name, products.product_image
        FROM rentals
        JOIN users ON rentals.user_id = users.id
        JOIN products ON rentals.product_id = products.product_id";

// Add filters
$conditions = [];
$params = [];

// CHECKS IF $statusFilter from the GET request query String is not empty and assigns a value to the empty arra conditions and params
if (!empty($statusFilter)) {
    $conditions[] = "rentals.rent_status = :status";
    $params[':status'] = $statusFilter;
}
if (!empty($dateFilter)) {
    $conditions[] = "DATE(rentals.request_date) = :date";
    $params[':date'] = $dateFilter;
}

// combines a string
if ($conditions) {
    $sql .= " WHERE " . implode(" AND ", $conditions); // 
}

$sql .= " ORDER BY rentals.request_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rentals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Rentals</title>
    <link rel="stylesheet" href="../styles/admin.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        .filter-bar { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Rental Management</h1>

    <div class="filter-bar">
        <form method="get">
            <label>Status:</label>
            <select name="status">
                <option value="">-- All --</option>
                <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="active" <?= $statusFilter == 'active' ? 'selected' : '' ?>>Active</option>
                <option value="delivered" <?= $statusFilter == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                <option value="returned" <?= $statusFilter == 'returned' ? 'selected' : '' ?>>Returned</option>
                <option value="cancelled" <?= $statusFilter == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                <option value="overdue" <?= $statusFilter == 'overdue' ? 'selected' : '' ?>>Overdue</option>
            </select>

            <label>Date:</label>
            <input type="date" name="date" value="<?= htmlspecialchars($dateFilter) ?>">

            <button type="submit">Filter</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Rental ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Image</th>
                <th>Dates</th>
                <th>Status</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rentals as $rental): ?>
                <tr>
                    <td><?= $rental['rental_id'] ?></td>
                    <td><?= htmlspecialchars($rental['username']) ?></td>
                    <td><?= htmlspecialchars($rental['product_name']) ?></td>
                    <td><img src="<?= htmlspecialchars($rental['product_image']) ?>" width="50"></td>
                    <td>
                        Start: <?= $rental['start_date'] ?><br>
                        End: <?= $rental['end_date'] ?><br>
                        Requested: <?= $rental['request_date'] ?>
                    </td>
                    <td><?= $rental['rent_status'] ?></td>
                    <td>£<?= number_format($rental['total_price'], 2) ?></td>
                    <td>
                        <?php if ($rental['rent_status'] === 'pending'): ?>
                            <form method="post" action="update_rental_status.php" style="display:inline-block;">
                                <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
                                <select name="new_status">
                                    <option value="active">Activate</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
