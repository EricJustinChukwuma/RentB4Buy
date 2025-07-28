<?php
require_once "config_session.inc.php";
require_once "dbh.inc.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in. Please login to rent now!"
    ]);
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;
$quantity   = isset($data['quantity']) ? intval($data['quantity']) : 1;

if ($product_id > 0) {
    try {
        $query = "SELECT product_id, product_name, product_image, price, price_per_day 
                  FROM Products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = [
                    "product_id"    => $product["product_id"],
                    "product_name"  => $product["product_name"],
                    "product_image" => $product["product_image"],
                    "price"         => $product["price"],
                    "price_per_day" => $product["price_per_day"],
                    "quantity"      => $quantity
                ];
            } else {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            }

            echo json_encode([
                "status" => "success",
                "message" => "Product added to cart.",
                "cart" => $_SESSION['cart']
            ]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Product not found in database."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
}







































// // ob_clean(); // Clear output buffer
// require_once "config_session.inc.php";
// require_once "dbh.inc.php";

// // file_put_contents('debug_product.log', "RAW: " . file_get_contents("php://input") . "\n", FILE_APPEND);
// // file_put_contents('debug_product.log', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);

// // Sets the HTTP response type to application/json. This tells the browser (or any client) that the server will respond with JSON data.
// header("Content-Type: application/json");

// // CHECKS IF THE USER IS LOGGED IN
// if (!isset($_SESSION["user_id"])) {
//     echo json_encode([
//         "status" => "Success",
//         "message" => "User not logged in. Please login to rent now!"
//     ]);
//     exit();
//     // header("Location: ../Login.php");
// };

// // CHECKS IF CART SESSION VARIABLE IS NOT SET(EXISTING)
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = []; // ASSINGS SESSION VARIABLE CART TO AN EMPTY ARRAY
// }

// // RECEIVES THE DATA SENT IN THE BODY OF THE FETCH ELEMENT WHEN A USER CLICKS THE ADD TO CART BUTTON WHICH IS A STRINGIFIED OBJECT THAT BECOMES A JSON
// // reads the raw POST request body sent by fetch() in your JavaScript code
// $rawData = file_get_contents("php://input");
// $data = json_decode($rawData, true); // DECODES THE RAW DATA GOTTEN FROM THE FETCH REQUEST IN THE "ProductPage.js";

// // Validate JSON and get product data
// // And creates a new varaiable product_id and assigns it the value of data['product_id'] 
// // gotten from the fetch request in 'productpage.js' if the "data['product_id']" exist and if it doesn't exist assign Zero as the value
// $product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;

// // checks if quantity in the data sent from the POST request actually exist and sets it to the quantity passed and if not sets it to 1
// $quantity = isset($data['quantity']) ? intval($data['quantity']) : 1; // Default to 1 if not provided


// if ($product_id > 0) {
//     try {
//         $query = "SELECT product_id, product_name, product_image, price, price_per_day, FROM Products WHERE product_id = :product_id;";
//         // $query = "SELECT * FROM Products WHERE product_id = :product_id;";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
//         $stmt->execute();
//         $product = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($product) {
//             if (isset($_SESSION['cart'])) {
//                 $_SESSION['cart'][$product_id] = [
//                     "product_id"    => $product["product_id"],
//                     "product_name"  => $product["product_name"],
//                     "product_image" => $product["product_image"],
//                     "price"         => $product["price"],
//                     "price_per_day" => $product["price_per_day"],
//                     "quantity"      => $quantity   
//                 ];
//             } else {
//                 $_SESSION['cart'][$product_id]['quantity'] += $quantity;
//             };

//             if (json_last_error() !== JSON_ERROR_NONE) {
//                 error_log("JSON encoding error: " . json_last_error_msg());
//             }

//             echo json_encode([
//                 "status" => "success",
//                 "message" => "Product added to cart.",
//                 "cart" => $_SESSION['cart']
//             ]);
//             exit;
//         } else {
//             echo json_encode(["status" => "error", "message" => "Product not found in database."]);
//         }


//     } catch(PDOException $e) {
//         echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
// }

/*
$total_price = 0;

if (isset($_SESSION['cart-total-price'])) {
    $total_price = $_SESSION['cart-total-price'];
}
*/