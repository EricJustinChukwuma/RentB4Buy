<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

if (!isset($_POST['rental_id'])) {
    die("Invalid request");
}

$rental_id = intval($_POST['rental_id']); // gets the integer value of the post request by the user
$user_id = $_SESSION['user_id'];

try {
    // Begins the transaction
    $pdo->beginTransaction();

    // Get rental details
    $stmt = $pdo->prepare("SELECT product_id, quantity FROM rentals WHERE rental_id = :rental_id AND user_id = :user_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $rental = $stmt->fetch(PDO::FETCH_ASSOC);

    // checks if the rentals does not exist in the rentals and if not throw an error
    if (!$rental) {
        throw new Exception("Rental not found or unauthorized");
    }

    // Update rental status to returned if the user chose not to purchase the product
    $stmt = $pdo->prepare("UPDATE rentals SET rent_status = 'returned' WHERE rental_id = :rental_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->execute();

    // Restore product stock and add back the returned quantity
    $stmt = $pdo->prepare("UPDATE products SET available_qty = available_qty + :quantity WHERE product_id = :product_id");
    $stmt->bindParam(':quantity', $rental['quantity']);
    $stmt->bindParam(':product_id', $rental['product_id']);
    $stmt->execute();

    $pdo->commit();

    header("Location: ../html/myrentals.php");
    exit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
