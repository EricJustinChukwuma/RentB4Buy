<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in. Please login to rent now!"
    ]);
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$quantity   = isset($data['quantity']) ? intval($data['quantity']) : 1;

if ($product_id > 0) {
    try {
        $query = "SELECT product_id, product_name, product_image, price, price_per_day 
                  FROM Products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = [
                    "product_id"    => $product["product_id"],
                    "product_name"  => $product["product_name"],
                    "product_image" => $product["product_image"],
                    "price"         => $product["price"],
                    "price_per_day" => $product["price_per_day"],
                    "quantity"      => $quantity
                ];
            } else {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            }

            echo json_encode([
                "status" => "success",
                "message" => "Product added to cart.",
                "cart" => $_SESSION['cart']
            ]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Product not found in database."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
}

