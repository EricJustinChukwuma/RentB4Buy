<?php

declare(strict_types=1);

function get_email(object $pdo,  string $email) {
    $query = "SELECT * FROM Users WHERE  email = :email;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results;
}
