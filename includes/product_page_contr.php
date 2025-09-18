<?php
require_once "config_session.inc.php";
file_put_contents('debug_product.log', "RAW: " . file_get_contents("php://input") . "\n", FILE_APPEND);
file_put_contents('debug_product.log', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);
require_once "dbh.inc.php";

// Sets the HTTP response type to application/json. This tells the browser (or any client) that the server will respond with JSON data.
header("Content-Type: application/json");

// CHECK IF USER IS LOGGED IN
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION["user_id"];
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $product_id = 0;

    // if (!empty($data['product_id'])) {
    //     $product_id = intval($data['product_id']);
    // } elseif (!empty($_POST['product_id'])) {
    //     $product_id = intval($_POST['product_id']);
    // }

    if (!isset($_SESSION["user_id"])) {
        echo json_encode([
            "status" => "error",
            "message" => "User not logged in"
        ]);
        exit();
    } else {
        if (!empty($data['product_id'])) {
            $product_id = intval($data['product_id']);
        } elseif (!empty($_POST['product_id'])) {
            $product_id = intval($_POST['product_id']);
        }
    }


    try {

        // INSERT INTO RENTALS
        $insertQuery = "INSERT INTO Rentals (user_id, product_id, rent_status) 
                        VALUES (:user_id, :product_id, 'Pending');";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':user_id', $user_id);
        $insertStmt->bindParam(':product_id', $product_id);
        $insertStmt->execute();

        echo json_encode([
            "status" => "success",
            "message" => "Product rental being processed"
        ]);
        exit();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Database Error: " . $e->getMessage()
        ]);
        exit();
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit();
}




