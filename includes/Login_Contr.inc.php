<?php

declare(strict_types=1);

function is_input_empty(string $email, string $pwd) {
    if (empty($email) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function is_email_wrong(bool|array $result) {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

// Checks if the password return from the databasde query does not matche the user's input and if it doesn't, 
// return true which means the password entered does not exist in the databases
function is_password_wrong(string $pwd, string $hashedPwd) {
    // checks both user input password and password stored in the database don't match
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}

