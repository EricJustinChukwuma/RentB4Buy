<?php
require_once "../includes/config_session.inc.php";
require_once 'includes/dbh.inc.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    die();
}

$user_id = $_SESSION['user_id'];

foreach ($_POST['start_date'] as $cart_id => $start_date) {
    $end_date = $_POST['end_date'][$cart_id];

    // Get product from cart
    $stmt = $conn->prepare("SELECT product_id FROM cart WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($product_id);
    $stmt->fetch();
    $stmt->close();

    // Insert into rentals
    $insert = $conn->prepare("INSERT INTO rentals (user_id, product_id, rental_start, rental_end) VALUES (?, ?, ?, ?)");
    $insert->bind_param("iiss", $user_id, $product_id, $start_date, $end_date);
    $insert->execute();

    // Remove from cart
    $delete = $conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
    $delete->bind_param("ii", $cart_id, $user_id);
    $delete->execute();
}

header('Location: rental_success.php'); // Create a success page
exit;
?>
