<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";
header('Content-Type: application/json');

try {
    $query = "SELECT products*, COUNT(rentals.rental_id) AS rental_count
        FROM rentals
        JOIN products ON rentals.product_id = products.product_id
        GROUP BY products.product_id
        ORDER BY rental_count DESC
        LIMIT 5
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}