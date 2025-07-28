<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";


// Chacks user is not logged in or Cart session variable is empty
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart'])) {
    die("Unauthorized or cart empty");
}

if (!isset($_SESSION['cart-total-price'])) {
    die("No product selected");
}

/*
<input type="input" name="town" placeholder="town" ><br><br>
        <input type="input" name="post-code" placeholder="Post Code... (OX5 2JS)"><br><br>
        <input type="input" name="house-no" placeholder="House No." ><br><br>
        <input type="input" name="streetname" placeholder="Street name"><br><br>
        <input type="input" name="county" placeholder="county"><br><br>
*/

$user_id = $_SESSION['user_id'];
// ADRESS
$town = $_POST['town'] ?? '';
$postCode = $_POST['post-code'] ?? '';
$houseNumber = $_POST['house-number'] ?? '';
$streetName = $_POST['streetname'] ?? '';
$county = $_POST['county'] ?? '';
//////////////////////////////////////
$start_date = $_POST['start_date'] ?? '';
$rental_days = intval($_POST['rental_days']);
$payment_method = $_POST['payment_method'] ?? '';
$total_price = $_SESSION['cart-total-price'] * $rental_days;

// $address = $houseNumber . " " . $streetName . " " . $town . ", " . $postCode . ", " . $county;
$end_date = (new DateTime($start_date))->modify("+$rental_days days")->format('Y-m-d');

$todayPlus3 = date('Y-m-d', strtotime('+3 days'));
if (empty($town) || empty($postCode) || empty($houseNumber) || empty($streetName) || empty($county) || empty($start_date) || $rental_days < 1 || $start_date < $todayPlus3) {
    die("Invalid input. Start date must be at least 3 days from today.");
}

try {
    $pdo->beginTransaction();

    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $single_product_cost = $item['price_per_day'] * $quantity * $rental_days;

        // foreach ($_SESSION['single-product-cost'] as $itemCost) {
        //     if ($itemCost['product_id'] == $product_id) {
        //         $single_product_cost = $itemCost['item_cost'];
        //     }
        // }



        // INSERTS INFO INTO ADDRESSES TABLE FOR EVERY RENTAL
        $addressInsert = "INSERT INTO Addresses (user_id, house_number, street_name, town, county, post_code)
                        VALUES (:user_id, :house_no, :street_name, :town, :county, :post_code);";
        $stmt = $pdo->prepare($addressInsert);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':house_no', $houseNumber);
        $stmt->bindParam(':street_name', $streetName);
        $stmt->bindParam(':town', $town);
        $stmt->bindParam(':county', $county);
        $stmt->bindParam(':post_code', $postCode);

        $stmt->execute();

        $address_id = $pdo->lastInsertId();

        // Insert rental
        // $insertQuery = "INSERT INTO rentals (user_id, product_id, start_date, end_date, quantity, address, payment_method)
        //                 VALUES (:user_id, :product_id, :rental_start_date, :rental_duration_days, quantity, address, payment_method)";
        $insertQuery = "INSERT INTO rentals (user_id, address_id, product_id, start_date, end_date, quantity, total_price)
                        VALUES (:user_id, :address_id, :product_id, :start_date, :end_date, :quantity, :total_price)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":address_id", $address_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":start_date", $start_date);
        $stmt->bindParam(":end_date", $end_date);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":total_price", $single_product_cost);

        $stmt->execute();

        // Decrease available quantity
        $update = $pdo->prepare("UPDATE products SET available_qty = available_qty - ? WHERE product_id = ?");
        $update->execute([$quantity, $product_id]);
    }

    // Commit the update changes to take effect in database
    $pdo->commit();
    unset($_SESSION['cart']); // unset the cart session variable to remove all items from the cart
    unset($_SESSION['cart-total-price']);
    // CREATE THIS PAGE ERROR COMING FROM ITS NON EXISTENCE
    header("Location: ../html/checkout_success.php"); // send the user to a page whichs says success
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Checkout failed: " . $e->getMessage();
}
