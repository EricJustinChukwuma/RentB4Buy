<?php
require_once "config_session.inc.php";
header("Content-Type: application/json");

if (!isset($_SESSION['cart'])) {
    echo json_encode(["status" => "error", "message" => "Cart not found."]);
    exit;
}

// Decode the fetched data from the post request when the user clicks a button to either increase, decrease or remove a product
$data = json_decode(file_get_contents("php://input"), true);
$product_id = intval($data['product_id'] ?? 0);
$change = intval($data['change'] ?? 0);
$action = $data['action'] ?? '';

if ($action === 'remove' && isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    echo json_encode(["status" => "success", "message" => "Product removed."]);
    exit;
}

if ($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] += $change;

    if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
        unset($_SESSION['cart'][$product_id]);
    }

    echo json_encode(["status" => "success", "message" => "Quantity updated.", "cart" => $_SESSION['cart']]);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid product or action."]);
