<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";
header('Content-Type: application/json');

try {
    $query = "SELECT * FROM products WHERE available_qty > 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products); // encodes the products result from the query
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

