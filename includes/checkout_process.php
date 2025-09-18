<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Unauthorized or cart empty");
}


$user_id       = $_SESSION['user_id'];
// User address details
// Fetch all POST Request variables and stores it in a variable
$house_number   = $_POST['house_number'] ?? ''; // sets houseNumber variable to the POST Request Value when the user submits the form if it exist or an empty string
$street_name    = $_POST['street_name'] ?? '';
$post_code      = $_POST['post_code'] ?? '';
$town          = $_POST['town'] ?? '';
$county        = $_POST['county'] ?? '';
$start_date    = $_POST['start_date'] ?? '';
$rental_days   = intval($_POST['rental_days'] ?? 0);
$payment_method= $_POST['payment_method'] ?? '';

// User card details
$cardholder_name = $_POST['cardholder_name'] ?? ''; // sets cardholder_name variable to the POST Request Value when the user submits the form if it exist or an empty string
$card_number     = $_POST['card_number'] ?? '';
$expiry_date     = $_POST['expiry_date'] ?? '';
$cvv             = $_POST['cvv'] ?? '';

// Cards Details Hashed
// $hashedCardName = hash("sha256", $cardholder_name);
// $hashedCardNumber = hash("sha256", $card_number);
// $hashedExpiryDate = password_hash($pwd, PASSWORD_BCRYPT, $options);
// $hashedCVV = password_hash($pwd, PASSWORD_BCRYPT, $options);

$todayPlus3 = date('Y-m-d', strtotime('+3 days')); // sets start date to never be less than 3 days after a user makes a rental request

// checks that start and rental days length is appropriate
if ($start_date < $todayPlus3 || $rental_days < 1) {
    die("Invalid rental start date or duration.");
}
// sets end date to be start date + rentals days and converted to date or in date format
$end_date = (new DateTime($start_date))->modify("+$rental_days days")->format('Y-m-d');

// Checks if any inout field for card details is empty
if (empty($cardholder_name) || empty($card_number) || empty($expiry_date) || empty($cvv)) {
    die("Please Fill in All Fields");
};

try {
    $pdo->beginTransaction();

    // Insert addresses
    $stmt = $pdo->prepare("INSERT INTO addresses (user_id, house_number, street_name, town, county, post_code)
                           VALUES (:user_id, :house_number, :street_name, :town, :county, :post_code)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':house_number', $house_number);
    $stmt->bindParam(':street_name', $street_name);
    $stmt->bindParam(':town', $town);
    $stmt->bindParam(':county', $county);
    $stmt->bindParam(':post_code', $post_code);
    $stmt->execute();
    $address_id = $pdo->lastInsertId();

    // Insert into cards
    $stmt = $pdo->prepare("INSERT INTO cards (user_id, cardholder_name, card_number, expiry_date, cvv)
                           VALUES (:user_id, :cardholder_name, :card_number, :expiry_date, :cvv)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':cardholder_name', $cardholder_name);
    $stmt->bindParam(':card_number', $card_number);
    $stmt->bindParam(':expiry_date', $expiry_date);
    $stmt->bindParam(':cvv', $cvv);
    $stmt->execute();
    $card_id = $pdo->lastInsertId(); // Gets the last inserted card id for each insert

    // Loop through each cart item and insert rentals
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity   = $item['quantity'];
        $productTotal = $item['price_per_day'] * $quantity * $rental_days;

        // Check product exists
        $checkProduct = $pdo->prepare("SELECT COUNT(*) FROM products WHERE product_id = ?");
        $checkProduct->execute([$product_id]);
        if ($checkProduct->fetchColumn() == 0) {
            throw new Exception("Product ID {$product_id} does not exist in products table.");
        }

        // Inserts into rentals
        $stmt = $pdo->prepare("INSERT INTO rentals 
            (user_id, address_id, product_id, quantity, start_date, end_date, rent_status, total_price)
            VALUES (:user_id, :address_id, :product_id, :quantity, :start_date, :end_date, 'pending', :total_price)");
        
        if (!$stmt->execute([
            ":user_id"      => $user_id, 
            ":address_id"   => $address_id, 
            ":product_id"   => $product_id, 
            ":quantity"     => $quantity, 
            ":start_date"   => $start_date, 
            ":end_date"     => $end_date, 
            ":total_price"  => $productTotal
        ])) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Failed to insert rental: " . $errorInfo[2]);
        }

        $rental_id = $pdo->lastInsertId();

        // Insert payment
        $stmt = $pdo->prepare("INSERT INTO payments (user_id, rental_id, amount, payment_method, payment_status, card_id)
                            VALUES (:user_id, :rental_id, :amount, :payment_method, 'completed', :card_id)");
        if (!$stmt->execute([
            ":user_id"      => $user_id, 
            ":rental_id"    => $rental_id, 
            ":amount"       => $productTotal, 
            ":payment_method" => $payment_method, 
            ":card_id"      => $card_id
        ])) {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Failed to insert payment: " . $errorInfo[2]);
        }

        // Reduce inventory
        $stmt = $pdo->prepare("UPDATE products SET available_qty = available_qty - :quantity WHERE product_id = :product_id");
        $stmt->execute([
            ":quantity"     => $quantity, 
            ":product_id"   => $product_id
        ]);
    }


    // Complete the update query (transaction)
    $pdo->commit();

    unset($_SESSION['cart']);
    unset($_SESSION['cart-total-price']);

    header("Location: ../html/checkout_success.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    die("Checkout failed: " . $e->getMessage());
}

