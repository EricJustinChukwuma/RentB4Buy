<?php
//Performs the buy functionality
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

if (!isset($_POST['rental_id'], $_POST['product_id'], $_POST['amount'])) {
    die("Invalid request");
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    header("Location: ../Login.php");
    die();
};

$rental_id = intval($_POST['rental_id']);
$product_id = intval($_POST['product_id']);
$amount = floatval($_POST['amount']);
$user_id = $_SESSION['user_id'];

$cardholder_name = trim($_POST['cardholder_name'] ?? '');
$card_number = trim($_POST['card_number'] ?? '');
$expiry_date = trim($_POST['expiry_date'] ?? '');
$cvv = trim($_POST['cvv'] ?? '');

// Checks no card info is missing from the POST request
if (!$cardholder_name || !$card_number || !$expiry_date || !$cvv) {
    die("Please fill in all card details.");
}

// $query = "SELECT * FROM Users WHERE id = :user_id";
// $stmt = $pdo->prepare($query);
// $stmt->bindParam(':user_id', $user_id);
// $result = $stmt->fetch(PDO::FETCH_ASSOC);

// Insert card details 
$stmt = $pdo->prepare("INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES (:user_id, :cardholder_name, :card_number, :expiry_date, :cvv)");
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':cardholder_name', $cardholder_name);
$stmt->bindParam(':card_number', $card_number);
$stmt->bindParam(':expiry_date', $expiry_date);
$stmt->bindParam(':cvv', $cvv);
$stmt->execute();
$card_id = $pdo->lastInsertId(); // gets the id of the last inserted row of data to the cards table


try {
    $pdo->beginTransaction();

    // Check rental belongs to user
    $stmt = $pdo->prepare("SELECT rental_id FROM rentals WHERE rental_id = :rental_id AND user_id = :user_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Checks if no rental record matches the rental id of current product to be purchased
    if (!$stmt->fetch()) {
        throw new Exception("Rental not found or unauthorized");
    }

    // Insert simulated card entry since there are no real payment gateway here
    $stmt = $pdo->prepare("INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv) VALUES (:user_id, :cardholder_name, :card_number, :expiry_date, :cvv)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':cardholder_name', $cardholder_name);
    $stmt->bindParam(':card_number', $card_number);
    $stmt->bindParam(':expiry_date', $user_id);
    $stmt->bindParam(':cvv', $cvv);
    $stmt->execute();
    $card_id = $pdo->lastInsertId(); // gets the id of the last inserted row of data to the cards table

    // Insert payment
    $stmt = $pdo->prepare("INSERT INTO payments (user_id, rental_id, amount, payment_method, payment_status, card_id) VALUES (:user_id, :rental_id, :amount, 'card', 'completed', :card_id)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Update rental status to purchased
    $stmt = $pdo->prepare("UPDATE rentals SET rent_status = 'purchased' WHERE rental_id = :rental_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->execute();

    $pdo->commit();

    header("Location: ../html/myrentals.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
