<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

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
    $product_id = intval($_POST["product_id"] ?? 0);

    if ($product_id <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid Product"
        ]);
        exit();
    }

    try {
        // CHECK IF RENTAL ALREADY EXISTS
        // $query = "SELECT * FROM Rentals 
        //           WHERE user_id = :user_id AND product_id = :product_id 
        //           AND rent_status = 'Pending';";
        // $stmt = $pdo->prepare($query);
        // $stmt->execute([
        //     ':user_id' => $user_id,
        //     ':product_id' => $product_id
        // ]);
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (!empty($result)) {
        //     echo json_encode([
        //         "status" => "error",
        //         "message" => "Product already processed for renting"
        //     ]);
        //     exit();
        // }

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
