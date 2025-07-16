<?php

require_once "../includes/config_session.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_SESSION['user_id'])) {
        die("User not logged in.");
    }
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id']; // make sure user is logged in

    require_once "dbh.inc.php";

    // $stmt = $conn->prepare("INSERT INTO rentals (user_id, product_id, rent_status, request_date) VALUES (?, ?, 'pending', NOW())");
    // $stmt->bind_param("ii", $user_id, $product_id);

    $query = "INSERT INTO rentals (user_id, product_id, rent_status, request_date) VALUES (:user_id, :product_id, 'pending', NOW());";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":product_id", $product_id);

    // if ($stmt->execute()) {
    //     echo "Rental request for product $product_id added successfully!";
    // } else {
    //     echo "Error: " . $stmt->error;
    // }

    $stmt->execute();

    // $stmt->close();
    // $conn->close();
} else {
    echo "Invalid request.";
}
?>