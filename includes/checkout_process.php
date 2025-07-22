<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id'] ?? 0);
$start_date = intval($_POST['start_date']);
$end_date = intval($_POST['end_data']);
$rental_days = $end_date - $start_date;

if ($product_id <= 0 || $rental_days <= 0) {
    die("Invalid data.");
}

try {
    $stmt = $pdo->prepare("INSERT INTO rentals (user_id, product_id, rent_status, start_date, end_date, total_price) 
                           VALUES (:user_id, :product_id, 'pending', NOW(), DATE_ADD(NOW(), INTERVAL :days DAY), 
                           (SELECT price_per_day * :days FROM products WHERE product_id = :product_id))");
    $stmt->execute([
        ':user_id' => $user_id,
        ':product_id' => $product_id,
        ':days' => $rental_days
    ]);

    echo "Rental confirmed!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
