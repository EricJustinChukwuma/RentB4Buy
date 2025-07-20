<?php

require_once "config_session.inc.php";
require_once "dbh.inc.php";

header("Content-Type: application/json");

// CHECK IF USER IS LOGGED IN
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $product_id = intval($_POST["product_id"] ?? 0);

    if ($product_id <= 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid Product"
        ]);
        exit();
    }

    try {
        // CHECK IF RENTAL ALREADY EXISTS
        // PREVENTS THE PRODUCT FROM BEING INSERTED INTO RENTALS TABLE IF PRODUCT ALREADY EXIST THERE
        // $query = "SELECT * FROM Rentals 
        //           WHERE user_id = :user_id AND product_id = :product_id 
        //           AND rent_status = 'Pending';";
        // $stmt = $pdo->prepare($query);
        // $stmt->bindParam(":user_id", $user_id);
        // $stmt->bindParam(":product_id", $product_id);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // if (!empty($result)) {
        //     echo json_encode([
        //         "status" => "error",
        //         "message" => "Product already processed for renting"
        //     ]);
        //     exit();
        // }
        ///////////////////////////////////////////////////////////////////////////////////////////////

        // INSERT INTO RENTALS
        $insertQuery = "INSERT INTO Rentals (user_id, product_id, rent_status) 
                        VALUES (:user_id, :product_id, 'Pending');";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(":user_id", $user_id);
        $insertStmt->bindParam(":product_id", $product_id);
        $insertStmt->execute();

        echo json_encode([
            "status" => "success",
            "message" => "Product requested for rental successfully"
        ]);
        exit();

    } catch(PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Database Error: " . $e->getMessage()
        ]);
        exit();
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit();
}





















































// require_once "config_session.inc.php";
// require_once "dbh.inc.php";

// header("Content-Type: application/json");


// // CHECKS IF USER HAS LOGGED IN 
// if (!isset($_SESSION["user_id"])) {
//     json_encode([
//         "status" => "Error",
//         "message" => "User not logged in"
//     ]);
//     // header("Location: ../Login.php"); // Redirects the user to the login page when they click rent now if they aren't logged in
//     exit();
// };


// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $user_id = $_SESSION["user_id"];
//     $product_id = intval($_POST["product_id"] ?? 0);

//     if ($product_id <= 0) {
//         echo json_encode([
//             "status" => "Error",
//             "message" => "Invalid Product"
//         ]);
//         exit();
//     };

//     try {
//         require_once "dbh.inc.php";

//         // Checks if the rentals already exist in the rental table by the same user
//         $query = "SELECT * FROM Rentals WHERE user_id = :user_id AND product_id = :product_id AND rent_status = 'Pending';";

//         $stmt = $pdo->prepare($query);

//         $stmt->bindParam(':user_id', $user_id);
//         $stmt->bindParam(':product_id', $product_id);

//         $stmt->execute();

//         $result = $stmt->fetch(PDO::FETCH_ASSOC);


//         if (!empty($result)) {
//             echo json_encode([
//                 "status" => "Error",
//                 "message" => "Product already processed for renting"
//             ]);
//             exit();
//         };


//         // INSERT DATA INTO RENTALS TABLE
//         $insertQuery = "INSERT INTO Rentals (user_id, product_id, rent_status) VALUES (:user_id, :product_id, 'Pending');";

//         $insertStmt = $pdo->prepare($insertQuery);

//         $insertStmt->bindParam(':user_id', $user_id);
//         $insertStmt->bindParam(':product_id', $product_id);

//         $insertStmt->execute();

//     }
//     catch(PDOException $e) {
//         // die("Error: " . $e->getMessage());
//         echo json_encode([
//             "status" => "Error",
//             "message" => "Database Error: " . $e->getMessage()
//         ]);
//     };
// };






/*
try {
    require_once 'dbh.inc.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        exit();
    }

    if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    $stmt = $pdo->prepare("INSERT INTO rentals (user_id, product_id, status) VALUES (?, ?, 'pending')");
    if ($stmt->execute([$user_id, $product_id])) {
        echo json_encode(['status' => 'success', 'message' => 'Product rented successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

*/































































/////////////////////////////// TRY 4 ///////////////////////////////////////////////////////////////
/*
<?php
session_start();
header('Content-Type: application/json'); // Force JSON output

require_once 'dbh.inc.php'; // Ensure this returns a PDO instance in $pdo

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id'] ?? 0);
    if ($product_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        exit();
    }

    $user_id = $_SESSION['user_id'];

    try {
        // Insert rental record using prepared statement
        $sql = "INSERT INTO rentals (user_id, product_id, status) VALUES (:user_id, :product_id, 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Product rented successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}









////////////////////////// TRY 3  //////////////////////////////////////////////////////

// if(!isset($_SESSION["user_id"])) {
//     echo json_encode([
//         "status" => "error",
//         "message" => "User not logged in"
//     ]);
//     exit();
// };

// // checks if the server request from the user is a POST request
// if ($_SERVER["REQUEST_METHOD"] === "POST") {

//     try {

//         // Validate the product_id
//         if(!isset($_POST['product_id']) || empty($_POST['product_id'])) {
//             echo json_encode([
//                 "status" => "error",
//                 "message" => "Invalid Product"
//             ]);
//         };

//         $user_id = $_SESSION["user_id"]; // store the user_id in a variable only if the user is logged in which creates a $_SESSION["user_id"]
//         $product_id = intval($_POST["product_id"]); // gets the integer value of a variable product_id and stores it in a variable.

//         /*
//             THIS PART CAN BE TRANFERED TO ANOTHER FILE CALLED "PRODUCT_PAGE_MODEL.INC.PHP" AND IMPORTED HERE AS A FUNCTION
//         */
//         // CHECKS IF THE PRODUCT ALREADY EXIST IN THE DATABASE TABLE RENTALS
//         $checkQuery = "SELECT * FROM Rentals WHERE user_id = :user_id AND product_id = :product_id AND rent_status = 'Pending';";
//         $checkStmt = $pdo->prepare($checkQuery);
//         $checkStmt->bindParam(":user_id", $user_id); // BINDS THE :USER_ID PLACE HOLDER TO $USER_ID
//         $checkStmt->bindParam(":product_id", $product_id); // BINDS THE :PRODUCT_ID PLACE HOLDER TO $PRODUCT_ID
//         $checkStmt->execute(); // EXECUTES THE STATEMENT
//         $result = $checkStmt->fetch(PDO::FETCH_ASSOC); // FETCH THE RESULT AND STORE IT IN A VARIABLE

//         // if ($result->num_rows > 0) {
//         //     echo json_encode(['status' => 'error', 'message' => 'Already requested this rental']);
//         //     exit();
//         // }

//         if(!empty($result)) {
//             echo json_encode([
//                 "status" => "error",
//                 "message" => "Already requested this rental"
//             ]);
//             die("rental requested already");
//         };
//         /*-------------------------------------------ALL THE WAY TO THIS PART---------------------------------------------*/


//         // THIS PART CAN ALSO BE TRANFERED TO ANOTHER FILE CALLED "PRODUCT_PAGE_MODEL.INC.PHP" AND IMPORTED HERE AS A FUNCTION
//         $insertQuery = "INSERT INTO Rentals (user_id, product_id, rent_status, request_date) VALUES (:user_id, :product_id, 'Pending', NOW());";
//         $insertStmt = $pdo->prepare($insertQuery);
//         $insertStmt->bindParam(":user_id", $user_id);
//         $insertStmt->bindParam(":product_id", $product_id);
//         $insertStmt->execute();

//         if($insertStmt->execute()) {
//             echo json_encode([
//                 "status" => "Success",
//                 "message" => "Rental Request sent Successfully"
//             ]);
//         } else {
//             echo json_encode([
//                 'status' => 'error', 
//                 'message' => 'Failed to process request'
//             ]);
//         };
//         //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//     } catch(PDOException $e) {
//         die("Query Failed:" . $e->getMessage());
//     };

// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
// };













/////////////////////// TRY 2 /////////////////////////////////////////////////////////

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
//     exit();
// }

// // Validate product_id
// if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
//     echo json_encode(['status' => 'error', 'message' => 'Product ID missing']);
//     exit();
// }

// $userId = intval($_SESSION['user_id']);
// $productId = intval($_POST['product_id']);

// // Check if rental table exists
// // Example rental table: rentals(id, user_id, product_id, status, rental_date)
// $query = "INSERT INTO rentals (user_id, product_id, status, rental_date) VALUES (?, ?, 'pending', NOW())";
// $stmt = mysqli_prepare($conn, $query);

// if ($stmt === false) {
//     echo json_encode(['status' => 'error', 'message' => 'Query prepare failed: ' . mysqli_error($conn)]);
//     exit();
// }

// mysqli_stmt_bind_param($stmt, "ii", $userId, $productId);

// if (mysqli_stmt_execute($stmt)) {
//     echo json_encode(['status' => 'success', 'message' => 'Product rented successfully!']);
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Query execution failed: ' . mysqli_error($conn)]);
// }

// mysqli_stmt_close($stmt);
// mysqli_close($conn);













/*
and how can i make this show up as an error message in the front-end prompting the user to log in before they can rent
*/


////////////////////////////// TRY 1 ///////////////////////////////////////////////////////////////////////////////////

/*
<?php
session_start();
require_once '../includes/dbh.inc.php'; // DB connection

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // Validate product_id
    if (!$product_id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid product']);
        exit();
    }

    // Check if already rented
    $checkStmt = $conn->prepare("SELECT * FROM rentals WHERE user_id = ? AND product_id = ? AND rent_status = 'pending'");
    $checkStmt->bind_param("ii", $user_id, $product_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Already requested this rental']);
        exit();
    }

    // Insert rental request
    $stmt = $conn->prepare("INSERT INTO rentals (user_id, product_id, rent_status, request_date) VALUES (?, ?, 'pending', NOW())");
    $stmt->bind_param("ii", $user_id, $product_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Rental request sent successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to process request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}


*/
