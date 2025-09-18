<?php

// MANDATORY
ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);
// ------------------//

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => "/",
    'secure' => true,
    'httponly' => true
]);

/*-----------------*/
session_start();


// Checks if the session variable called user_id is set
if (isset($_SESSION["user_id"])) {
    // if it is set it checks if a session variable called 'last_regeneration' is not set and calls a functions called "regenrate_session_id_loggedin()" 
    // If it doesn't exist it means we haven't yet updated our session variable
    if (!isset($_SESSION["last_regeneration"])) {

        // which sets a new session ID and sets the session variable called last_regeneration to the current time.
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30; // Time in seconds
    
        // Checks if the current time minus the time of the session variable last_regeneration is >= 30 min 
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_ID();
        }
    }
} else {
    if (!isset($_SESSION["last_regeneration"])) {

        regenerate_session_ID();
    } else {
        $interval = 60 * 120; // Time is seconds
    
        if(time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_ID();
        }
    }
}

// RUNS AN UP{DATE EVERY 30MIN TO REGENERTATE AN ID FOR THE COOKIE
// if (!isset($_SESSION["last_regeneration"])) {

//     regenerate_session_ID();
// } else {
//     $interval = 60 * 30; // Time is seconds

//     if(time() - $_SESSION["last_regeneration"] >= $interval) {
//         regenerate_session_ID();
//     }
// }

function regenerate_session_id_loggedin() {
    session_regenerate_id(true); //CURRENTLY NOT NECESSARY

    // creates a variable and assigns a session variable called user_id to it.
    $userId = $_SESSION["user_id"];

    // THIS CREATES AN ENTIRELY NEW ID
    // WE CAN APPEND THIS NEW ID WITH OUR USER ID
    $newSessionId = session_create_id();

    // COMBINE THE NEW SESSION ID WITH THE USER'S ID WE GOT FROM THE RESULT OF THE QUERY STORED IN '$result' variable.
    $sessionId = $newSessionId . "_" . $userId;

    // SET THE NEW SESSION ID TO THE VARIABLE CREATED ABOVE WHICH IS THE COMBINATION OF THE USER ID AND THE NEW SESSION ID CREATED ABOVE
    session_id($sessionId);

    // Set the session variable las_regeneration to the current time
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_ID() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}

