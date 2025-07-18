<?php

require_once "../includes/config_session.inc.php";
require_once 'dbh.inc.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in to add rentals.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // Check if already in cart
    $check = $conn->prepare("SELECT id FROM cart WHERE user_id=? AND product_id=? AND rental_flag=1");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['status' => 'info', 'message' => 'Product already in your rental cart']);
    } else {
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, rental_flag) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $user_id, $product_id);
        if ($insert->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Added to rental cart']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add to cart']);
        }
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
