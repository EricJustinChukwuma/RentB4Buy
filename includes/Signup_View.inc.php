<?php
// Example from a YouTube Tutorial

declare(strict_types=1);

function signup_inputs() {

    if(isset($_SESSION["signup_data"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION["signup_data"]["username"] . '">';
    } else {
        echo '<input type="text" name="username" placeholder="Username">';
    }

    if(isset($_SESSION["signup_data"]["firstname"])) {
        echo '<input type="text" name="firstname" placeholder="Firstname" value="' . $_SESSION["signup_data"]["firstname"] . '">';
    } else {
        echo '<input type="text" name="firstname" placeholder="Firstname">';
    }

    if(isset($_SESSION["signup_data"]["lastname"])) {
        echo '<input type="text" name="lastname" placeholder="Lastname" value="' . $_SESSION["signup_data"]["lastname"] . '">';
    } else {
        echo '<input type="text" name="lastname" placeholder="Lastname">';
    }

    if(isset($_SESSION["signup_data"]["email"]) && !isset($_SESSION["errors_signup"]["email_taken"]) && !isset($_SESSION["errors_signup"]["invalid_email"])) {
        echo '<input type="text" name="email" placeholder="Email" value="' . $_SESSION["signup_data"]["email"] . '">';
    } else {
        echo '<input type="text" name="email" placeholder="Email">';
    }

    echo '<input type="text" name="pwd" placeholder="Password">';
}

// Checks if any errors exist in a Session variable called "errors_signup"
function check_signup_errors() {
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        echo '<br>';

        foreach($errors as $error) {
            echo '<p class="signup_errors">' . $error . '</p>';
        }


        unset($_SESSION['errors_signup']);
    } 
    // Checks is the URL has a Global variable signup existing and if that variable is equal to 'success'
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '<br>';
        echo "<p class='form-success'>Signup Success!</p>";
    }
}