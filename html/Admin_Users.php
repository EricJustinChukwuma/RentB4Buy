<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php"; // Restrict to admins only

// Fetch all users
$sql = "SELECT id, username, email, created_at FROM users WHERE role_id = 2 ORDER BY created_at DESC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Users</title>
    <link rel="stylesheet" href="../styles/admin.css"> <!-- Optional -->
</head>
<body>
    <h1>All Users</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Registered On</th>
                <th>Rental History</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($users): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <a href="user_rentals.php?user_id=<?= $user['id'] ?>">View Rentals</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
