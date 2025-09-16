<?php

// Example from a Tutorial on YouTube
declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";
        require_once "Login_Model.inc.php";
        require_once "Login_View.inc.php";
        require_once "Login_Contr.inc.php";

        // ERRORS
        $errors = [];

        // CHECKS IF ANY OF THE INPUTS ARE EMPTY
        // USING A FUCTION FROM THE SIGNUP_CONTR.INC.PHP FILE OF THE MVC METHOD.
        if (is_input_empty($email, $pwd)) {
            $errors["empty_input"] = "Fill in all fields";
        };

        // STORES THE END RESULT OF THE 'get_email()' FUNCTION FROM THE 'LOGIN_MODEL.INC.PHP' FILE 
        // WHICH FETCHES THE USER DETAILS WHICH CORRESPONDS TO THE EMAIL THE USER INPUTS
        $result = get_email($pdo, $email);

        // CHECKS IF THE EMAIL THE USER ENTERED IS WRONG WHEN THEY TRY TO LOG IN. THIS IS DONE IN THE LOGIN_CONTR.INC.PHP' FILE
        if (is_email_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        };

        if (!is_email_wrong($result) && is_password_wrong($pwd, $result['pwd'])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        };


        // REQUIRE THE CONFIG FILE THAT HAS A MUICH SAFER SESSION
        require_once "config_session.inc.php";

        // checks if any errors exist in the errors array and if it does stops the user from registering
        if ($errors) {
            $_SESSION['errors_login'] = $errors;

            header("Location: ../Login.php");
            die();
        }

        // Create  anew session id for security
        // not really neccessary
        $newSesseionId = session_create_id();
        $sessionId = $newSesseionId . "_" . $result['id'];
        session_id($sessionId);

        // create session variables to store result data from the database query so it's always accessible in all pages.
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_role_id"] = $result["role_id"];
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["user_firstname"] = htmlspecialchars($result["firstname"]);
        $_SESSION["user_lastname"] = htmlspecialchars($result["lastname"]);

        $_SESSION["last_regeneration"] = time();


        ////////////////////////////////////////////////////////////
        // SHOULD BE DIRECTED TO THE USER-PROFILE PAGE or ADMIN PAGE BASED ON THE ROLE_ID
        if(isset($_SESSION["user_role_id"]) && $_SESSION["user_role_id"] === 2) {
            $_SESSION['is_admin'] = false;
            header("Location: ../html/index.php?User_login=success");
        } elseif (isset($_SESSION["user_role_id"]) && $_SESSION["user_role_id"] === 1) {
            $_SESSION['is_admin'] = true;
            header("Location: ../html/index.php?Admin_login=success");
        }
        // header("Location: ../html/index.php?login=success");
        ////////////////////////////////////////////////////////////

        $pdo = null;
        $stmt = null;
        
        die();

    } catch(PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }

    
} else {
    header("Location: ../Login.php");
    die();
}