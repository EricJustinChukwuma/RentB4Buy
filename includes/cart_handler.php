<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$product_id = intval($_POST['product_id'] ?? 0);

if ($product_id > 0) {
    // Add product with default quantity 1
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Product added to cart.",
        "cart" => $_SESSION['cart']
    ]);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid product ID."]);