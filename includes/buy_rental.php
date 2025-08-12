<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

if (!isset($_POST['rental_id'], $_POST['product_id'], $_POST['amount'])) {
    die("Invalid request");
}

$rental_id = intval($_POST['rental_id']);
$product_id = intval($_POST['product_id']);
$amount = floatval($_POST['amount']);
$user_id = $_SESSION['user_id'];

$cardholder_name = trim($_POST['cardholder_name'] ?? '');
$card_number = trim($_POST['card_number'] ?? '');
$expiry_date = trim($_POST['expiry_date'] ?? '');
$cvv = trim($_POST['cvv'] ?? '');

if (!$cardholder_name || !$card_number || !$expiry_date || !$cvv) {
    die("Please fill in all card details.");
}

// Insert card details
$stmt = $pdo->prepare("INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$user_id, $cardholder_name, $card_number, $expiry_date, $cvv]);
$card_id = $pdo->lastInsertId();


try {
    $pdo->beginTransaction();

    // Check rental belongs to user
    $stmt = $pdo->prepare("SELECT rental_id FROM rentals WHERE rental_id = ? AND user_id = ?");
    $stmt->execute([$rental_id, $user_id]);
    if (!$stmt->fetch()) {
        throw new Exception("Rental not found or unauthorized");
    }

    // Insert simulated card entry (since no real payment gateway here)
    $stmt = $pdo->prepare("INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES (?, 'Simulated User', '0000000000000000', '12/30', '000')");
    $stmt->execute([$user_id]);
    $card_id = $pdo->lastInsertId();

    // Insert payment
    $stmt = $pdo->prepare("INSERT INTO payments (user_id, rental_id, amount, payment_method, payment_status, card_id) VALUES (?, ?, ?, 'card', 'completed', ?)");
    $stmt->execute([$user_id, $rental_id, $amount, $card_id]);

    // Update rental status to purchased
    $stmt = $pdo->prepare("UPDATE rentals SET rent_status = 'purchased' WHERE rental_id = ?");
    $stmt->execute([$rental_id]);

    $pdo->commit();

    header("Location: ../html/myrentals.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
