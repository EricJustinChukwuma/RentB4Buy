<?php

declare (strict_types=1);

function rental_product_exist_already(object $pdo, int $user_id, int $product_id, string $rent_status) {
    $query = "SELECT * FROM Rentals WHERE user_id = :user_id AND product_id = :product_id AND rent_status = 'Pending';";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':product_id', $product_id);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}