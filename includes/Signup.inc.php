<?php
// Example from a Tutorial on YouTube
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    // $role_id = $_POST["role_id"];

    try {
        require_once "dbh.inc.php";
        require_once "Signup_Model.inc.php";
        require_once "Signup_Contr.inc.php";

        // ERRORS
        $errors = [];

        // CHECKS IF ANY OF THE INPUTS ARE EMPTY
        // USING A FUCTION FROM THE SIGNUP_CONTR.INC.PHP FILE OF THE MVC METHOD.
        if (is_input_empty($username, $firstName, $lastName, $email, $pwd)) {
            $errors["empty_input"] = "Fill in all fields";
        };

        // CHECKS IF IT IS AN INVALID EMAIL
        // USING A FUCTION FROM THE SIGNUP_CONTR.INC.PHP FILE OF THE MVC METHOD.
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used";
        };

        // CHECKS IF THE USERNAME HAS BEEN TAKEN
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "Username already taken";
        };

        // CHECKS IF THE EMAIL ALREADY EXIST
        if (is_email_registered($pdo, $email)) {
            $errors["email_taken"] = "Email already taken";
        }

        // REQUIRE THE CONFIG FILE THAT HAS A MUCH SAFER SESSION
        require_once "config_session.inc.php";


        // checks if any errors exist in the errors array and if it does stops the user from registering
        if ($errors) {
            $_SESSION['errors_signup'] = $errors;

            $signupData = [
                "username" => $username,
                "firstname" => $firstName,
                "lastname" => $lastName,
                "email" => $email,
            ];

            $_SESSION["signup_data"] = $signupData;

            header("Location: ../Signup.php");
            die();
        }

        create_user($pdo, $username, $firstName, $lastName, $email, $pwd);

        header("Location: ../Login.php?signup=success");
        die();

        $pdo = null;
        $stmt = null;
        
        die();

    } catch(PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }

    
} else {
    header("Location: ../Signup.php");
    die();
}