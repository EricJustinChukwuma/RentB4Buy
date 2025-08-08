<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Unauthorized or cart empty");
}

$user_id = $_SESSION['user_id'];

$houseNumber = $_POST['house_number'] ?? '';
$streetName = $_POST['street_name'] ?? '';
$postCode = $_POST['post_code'] ?? '';
$town = $_POST['town'] ?? '';
$county = $_POST['county'] ?? '';
$start_date = $_POST['start_date'] ?? '';
$rental_days = intval($_POST['rental_days'] ?? 0);
$payment_method = $_POST['payment_method'] ?? '';

$todayPlus3 = date('Y-m-d', strtotime('+3 days'));

// Ensures start date is always at least 3 days after the rental request is made
if ($start_date < $todayPlus3 || $rental_days < 1) {
    die("Start date must be at least 3 days from today and rental duration must be valid.");
}

$end_date = (new DateTime($start_date))->modify("+$rental_days days")->format('Y-m-d');

try {
    $pdo->beginTransaction();

    // 1. Insert Address
    $stmt = $pdo->prepare("INSERT INTO addresses (user_id, house_number, street_name, town, county, post_code) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $houseNumber, $streetName, $town, $county, $postCode]);
    $address_id = $pdo->lastInsertId();

    $rental_ids = [];  // To collect all inserted rental_ids
    $total_amount = 0;

    // 2. Insert Rentals (One per item)
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $pricePerDay = $item['price_per_day'];
        $productTotal = $pricePerDay * $quantity * $rental_days;

        $stmt = $pdo->prepare("INSERT INTO rentals (user_id, product_id, address_id, start_date, end_date, quantity, total_price, rent_status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $product_id, $address_id, $start_date, $end_date, $quantity, $productTotal]);

        $rental_ids[] = $pdo->lastInsertId();
        $total_amount += $productTotal;

        // Decrease stock
        $stmt = $pdo->prepare("UPDATE products SET available_qty = available_qty - ? WHERE product_id = ?");
        $stmt->execute([$quantity, $product_id]);
    }

    // 3. Insert Payment after rentals
    foreach ($rental_ids as $rental_id) {
        $stmt = $pdo->prepare("INSERT INTO payments (user_id, rental_id, amount, payment_method, payment_date)
                               VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id, $rental_id, $total_amount, $payment_method]);
    }

    $pdo->commit();

    unset($_SESSION['cart']);
    unset($_SESSION['cart-total-price']);

    header("Location: ../html/checkout_success.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Checkout failed: " . $e->getMessage());
}
