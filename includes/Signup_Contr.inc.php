<?php
declare(strict_types=1);

function is_input_empty(string $username, string $firstName, string $lastName, string $email, string $pwd) {
    if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($pwd))  {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {
    // CHECKS IF THE EMAIL IS NOT A VALID EMAIL
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

// WHEN WRITING A FUNCTION THAT HAS TO QUERY THE DATABASE ALWAYS INCLUDE YOUR DATABASE CONNECTIO VARIABLE AS A PARAMETER
function is_username_taken(object $pdo, string $username) {
    // CHECKS IF THE EMAIL IS NOT A VALID EMAIL
    if (get_username($pdo, $username)) {
        return true;
    } else {
        return false;
    }
}

function is_email_registered(object $pdo, string $email) {
    // CHECKS IF THE EMAIL Already exist in the database
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}


function create_user(object $pdo, string $username, string $firstname, string $lastname, string $email, string $pwd) {
    //
    set_user($pdo, $username, $firstname, $lastname, $email, $pwd);
}