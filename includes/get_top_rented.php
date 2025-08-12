<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";
header('Content-Type: application/json');

try {
    // selects product from the rental table that has the highest rent count
    $query = "
        SELECT 
            p.product_id,
            p.product_name, 
            p.product_image, 
            COUNT(r.rental_id) AS rental_count
        FROM rentals r
        JOIN products p ON r.product_id = p.product_id
        WHERE r.request_date >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY p.product_id, p.product_name, p.product_image
        ORDER BY rental_count DESC
        LIMIT 5
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}