<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) {
    $query = "SELECT username FROM Users WHERE username = :username;";

    // create prepared statement
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':username', $username);

    $stmt->execute();

    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results;
}

function get_email(object $pdo, string $email) {
    $query = "SELECT username FROM Users WHERE email = :email;";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":email", $email);

    $stmt->execute();

    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    return $results;
}

function set_user(object $pdo, string $username, string $firstname, string $lastname, string $email, string $pwd) {
    $query = "INSERT INTO Users (username, firstname, lastname, email, pwd, role_id) VALUES (:username, :firstname, :lastname, :email, :pwd, :role_id);";

    $stmt = $pdo->prepare($query);

    $admin_id = 1;
    $user_role_id = 2;

    // ENSURES IT COST MORE TO RUN THIS HASH FUNCTION AND ALSO PREVENTS BRUTE FORCE ATTACK TO THE WEBSITE
    $options = [
        "cost" => 12
    ];

    // Hashed the password and makes it effective in withstanding a brute force attack
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":role_id", $admin_id);

    $stmt->execute();
}