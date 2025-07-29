<?php

// MVC - MODEL VIEW CONTROL
// Have a function Connection to database and querying the database. MODEL
// Have a file the handles functions or codes for showing data on the website VIEW
// Have a 3rd file for handling user input to be run on the website CONTROLLER


// ONLY THE CONTROLLER FILES CAN INETRACT WITH THE MODEL FILE
// IT WILL HANDLE INPUT FROM THE USERS USING THE FUCNTIONS IN THE MODEL FILE BY SENDING THE USER INFO TO THE FUNCTION HERE TO DO SOMETHING WITH THE DATABASE

// USERS TABLE SQL CODE
/*
    CREATE TABLE Users (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL,
        firstname VARCHAR(50) NOT NULL,
        lastname VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        pwd VARCHAR(255) NOT NULL,
        role_id INT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
        PRIMARY KEY (id),
        FOREIGN KEY (role_id) REFERENCES Roles (role_id) 
    )
*/


// CATEGORIES TABLE SQL CODE
/*
    CREATE TABLE Categories (
        category_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        category_name VARCHAR(20) NOT NULL
    )
*/



// PRODUCT TABLE SQL CODE
/*
    CREATE TABLE Products (
        product_id INT NOT NULL AUTO_INCREMENT,
        product_name VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        category_id INT NOT NULL,
        product_image VARCHAR(255),
        price FLOAT NOT NULL,
        price_per_day FLOAT NOT NULL,
        deposit FLOAT NOT NULL,
        available_qty INT NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
        PRIMARY KEY (product_id),
        FOREIGN KEY (category_id) REFERENCES Categories (category_id)
    );
*/



// RENTALS TABLE SQL CODE
/*
    CREATE TABLE Rentals (
        rental_id INT NOT NULL AUTO_INCREMENT,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        start_date DATE NOT NULL DEFAULT CURRENT_DATE,
        end_date DATE NOT NULL,
        rent_status VARCHAR(20) NOT NULL,
        total_price INT NOT NULL,
        PRIMARY KEY (rental_id),
        FOREIGN KEY (user_id) REFERENCES Users (id),
        FOREIGN KEY (product_id) REFERENCES products (product_id)
    );



    CREATE TABLE rentals (
        rental_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        start_date DATE DEFAULT NULL,
        end_date DATE DEFAULT NULL,
        rent_status ENUM('pending', 'delivered', 'active', 'returned', 'overdue') DEFAULT 'pending',
        total_price DECIMAL(10, 2),
        rental_date
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    );

    CREATE TABLE rentals (
        rental_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        start_date DATE DEFAULT NULL,
        end_date DATE DEFAULT NULL,
        rent_status ENUM('pending', 'delivered', 'active', 'returned', 'overdue') DEFAULT 'pending',
        total_price DECIMAL(10, 2),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    );

    // NEW RENTALS SQL
    CREATE TABLE rentals (
        rental_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        start_date DATE DEFAULT NULL,
        end_date DATE DEFAULT NULL,
        address TEXT NOT NULL,
        rent_status ENUM('pending', 'delivered', 'active', 'returned', 'overdue') DEFAULT 'pending',
        payment_method VARCHAR(50) NOT NULL,
        total_price DECIMAL(10, 2),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(product_id)
    );

    CREATE TABLE rentals (
        rental_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        address_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        start_date DATE DEFAULT NULL,
        end_date DATE DEFAULT NULL,
        rent_status ENUM('pending', 'delivered', 'active', 'returned', 'overdue', 'cancelled') DEFAULT 'pending',
        payment_method VARCHAR(50) NOT NULL,
        total_price DECIMAL(10, 2),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (product_id) REFERENCES products(product_id),
        FOREIGN KEY (address_id) REFERENCES addresses(address_id)
    );
    //////////////////////////////////


    // SQL EVENT CODES
    // Update Rentals after 3 days or request. 
    SET GLOBAL event_scheduler = ON;

    CREATE EVENT IF NOT EXISTS activate_rentals_after_3_days
    ON SCHEDULE EVERY 1 DAY
    DO
    BEGIN
        UPDATE rentals
        SET rent_status = 'active'
        WHERE rent_status = 'pending'
        AND request_date <= NOW() - INTERVAL 3 DAY;
    END;

    //////////////////  Update Rentals after 3 days or request. /////////////////////
    SET GLOBAL event_scheduler = ON;

    DELIMITER $$

    CREATE EVENT IF NOT EXISTS activate_rentals_after_3_days
    ON SCHEDULE EVERY 1 DAY
    DO
    BEGIN
        UPDATE rentals
        SET rent_status = 'active'
        WHERE rent_status = 'pending'
        AND request_date <= NOW() - INTERVAL 3 DAY;
    END$$

    DELIMITER ;
    /////////////////////////////////////////////////

    // ADDRESS TABLE SQL CODES
    CREATE TABLE addresses (
        address_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        house_number VARCHAR(50),
        street_name VARCHAR(255),
        town VARCHAR(100),
        county VARCHAR(100),
        post_code VARCHAR(20),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ///////////////////////////////




    INSERT INTO Products (product_name, description, product_image, price, price_per_day, available_qty)
VALUES ("iPhone 16 pro", "Apple M2 Chip with 16GB RAM and 512GB SSD", "../images/iPhone-1.jpg", 1300, 11.89, 10),
("iPhone 16 pro max", "Apple M2 Pro chip with 16GB RAM and 512GB SSD.", "../images/Sony-headphones.jpg", 1900, 15.5, 8),
("Sony WH-1000XM5 Headphones", "Industry-leading noise cancelling headphones.", "../images/Sony-headphones.jpg", 900, 15.5, 8),
("Sony vH-3000Xz5 Headphones", "Industry-leading noise cancelling headphones that's durable.", "../images/Headphones-1.jpg", 710, 10.5, 8),
("Olympus Camera", "Mirrorless camera with 4K video and 24.2MP sensor.", "../images/Olympus_camera.jpg", 1200, 12.5, 6),
("Canon EOS R50 Camera", "A state of the art camera with 4 hight tech lences.", "../images/Camera-1.jpg", 650, 11.5, 8),
("Kodak E3050 Camera", "A fine photo-centric camera that focuses on clarity.", "../images/Camera-2.jpg", 540, 9.5, 8),
("Asus Rog Strix Gaming Laptop", "Intel Quad Core 11th Gen with 32GB RAM and 1TB SSD.", "../images/Laptop-1.jpg", 3540, 9.5, 8),
("Intel HP Laptop", "intel Octa Core 11th Gen with 16GB and 512GB SSD.", "../images/Laptop-2.jpg", 2640, 45.5, 8),
("Mac Book Pro Laptop", "intel Octa Core 11th Gen with 16GB and 512GB SSD.", "../images/Laptop-3.jpg", 1640, 35.5, 8),
("Acer Nitro Laptop", "intel Octa Core 11th Gen with 64GB and 512GB SSD.", "../images/Laptop-4.jpg", 2349.99, 38, 12),
("Apple Tablet", "iOS Octa Core 14inch Screen with 16GB and 512GB SSD.", "../images/Tablets-1.jpg", 949.99, 38, 12),
("Beach Chair", "A stylish beach chair that fits anywhere", "../images/chair.jpg", 250.99, 5.5, 12),
("Mahoganny Table", "A stylish table fit for your special work place.", "../images/Table-1.jpg", 350.99, 5.5, 12),
("Vanier Table", "A stylish table that fits almost anywhere.", "../images/Table-2.jpg", 350.99, 5.5, 12),
("Checkered Table", "An expensive checkered tablecrafted with precision and sweat.", "../images/Table-3.jpg", 470.99, 9.5, 12),
("Bolo Shirt", "A stylish and trendy shirt for any occasion.", "../images/Shirt-1.jpg", 70.99, 5.5, 12),
("Manny Shirt", "A uniqely designed and aesthetic table that make the room come alive.", "../images/Shirt-2.jpg", 50.99, 2.5, 12),
("Armani Shirt", "A beautiful shirt that goes well with any shirt", "../images/Shirt-3.jpg", 250.99, 2.5, 12)

*/



// RETURNS TABLE SQL CODE
/*
    CREATE TABLE Returns (
 	return_id INT NOT NULL AUTO_INCREMENT,
    rental_id INT NOT NULL,
    return_date DATETIME NOT NULL DEFAULT CURRENT_TIME,
    return_condition TEXT NOT NULL,
    is_damaged BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (return_id),
    FOREIGN KEY (rental_id) REFERENCES Rentals (rental_id)
);
*/


/*
 Survey Questions for Stakeholder Feedback
Have you ever rented a product before purchasing it? If yes, what was the product?
(Open-ended – helps understand experience level and product categories)

On a scale of 1–5, how likely would you be to use a 'try-before-you-buy' rental service?
(Scale question – for gauging general interest)

What would increase your trust in a product rental service before purchase?

A. Verified product quality

B. Clear return/refund policy

C. Low rental price

D. Customer reviews
(Multiple choice – identify top trust factors)

What are your biggest concerns with renting a product before buying it?
(Open-ended – may reveal legal, safety, or financial fears)

How much would you be willing to pay (as a percentage of the product price) to rent an item for 3 days?
(Multiple choice: 5%, 10%, 15%, 20%+)

Which type of products would you consider renting before buying? (Select all that apply)

A. Electronics

B. Furniture

C. Fashion/clothing

D. Fitness equipment

E. Kitchen appliances
(Gives insights into popular categories)

Would a deposit/refundable fee make you more or less likely to use the service? Why?
(Open-ended or scale – addresses payment/commitment concerns)

What would you expect from the return process (e.g. cost, time, packaging)?
(Open-ended – understand expectations around returns and friction points)

How important is insurance or damage coverage when renting an item?

Not important

Somewhat important

Very important
(Risk sensitivity – essential for your legal and sustainability planning)

Do you think a try-before-you-buy model is more sustainable than traditional retail? Why or why not?
(Good academic insight into perception of environmental value)

*/












/*
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M399 384.2C376.9 345.8 335.4 320 288 320l-64 0c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>









INSERT INTO Users (username, firstname, lastname, email, pwd, role_id) 
VALUES ("MikhailErics", "Eric", "Ifemeje", "EricJRiley@gmail.com", 12345, 1),
("LuciosVanhein", "Lucios", "Vanhein", "LuciosVan@gmail.com", 12345, 1)

*/


/*
<?php
// ob_clean(); // Clear output buffer
require_once "config_session.inc.php";
require_once "dbh.inc.php";

// file_put_contents('debug_product.log', "RAW: " . file_get_contents("php://input") . "\n", FILE_APPEND);
// file_put_contents('debug_product.log', "POST: " . print_r($_POST, true) . "\n", FILE_APPEND);

// Sets the HTTP response type to application/json. This tells the browser (or any client) that the server will respond with JSON data.
header("Content-Type: application/json");

// CHECKS IF THE USER IS LOGGED IN
if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "Success",
        "message" => "User not logged in. Please login to rent now!"
    ]);
    exit();
    // header("Location: ../Login.php");
};

// CHECKS IF CART SESSION VARIABLE IS NOT SET(EXISTING)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // ASSINGS SESSION VARIABLE CART TO AN EMPTY ARRAY
}

// RECEIVES THE DATA SENT IN THE BODY OF THE FETCH ELEMENT WHEN A USER CLICKS THE ADD TO CART BUTTON WHICH IS A STRINGIFIED OBJECT THAT BECOMES A JSON
// reads the raw POST request body sent by fetch() in your JavaScript code
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true); // DECODES THE RAW DATA GOTTEN FROM THE FETCH REQUEST IN THE "ProductPage.js";

// Validate JSON and get product data
// And creates a new varaiable product_id and assigns it the value of data['product_id'] 
// gotten from the fetch request in 'productpage.js' if the "data['product_id']" exist and if it doesn't exist assign Zero as the value
$product_id = isset($data['product_id']) ? intval($data['product_id']) : 0;

// checks if quantity in the data sent from the POST request actually exist and sets it to the quantity passed and if not sets it to 1
$quantity = isset($data['quantity']) ? intval($data['quantity']) : 1; // Default to 1 if not provided


if ($product_id > 0) {
    try {
        $query = "SELECT product_id, product_name, product_image, price, price_per_day, FROM Products WHERE product_id = :product_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($product) {
            if (isset($_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] = [
                    "product_id" => $product["product_id"],
                    "product_name" => $product["product_name"],
                    "product_image" => $product["product_image"],
                    "price" => $product["price"],
                    "price_per_day" => $product["price_per_day"],
                    "quantity" => $quantity   
                ];
            } else {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            };

            echo json_encode([
                "status" => "success",
                "message" => "Product added to cart.",
                "cart" => $_SESSION['cart']
            ]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Product not found in database."]);
        }


    } catch(PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid product ID."]);
}








// Check if product ID is valid
if ($product_id > 0) {
    // Add product with given quantity
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = $quantity;
        $_SESSION['cart'][$productImg] = $productImg;
        $_SESSION['cart'][$productPrice] = $productPrice;
    } else {
        $_SESSION['cart'][$product_id] += $quantity;
    }

    echo json_encode([
        "status" => "success",
        "message" => "Product added to cart.",
        "cart" => $_SESSION['cart']
    ]);
    exit;
}

echo json_encode(["status" => "error", "message" => "Invalid product ID."]);

*/



/*

NEXT STEP ADD USER PROFILE PAGE THAT SHOW CERTAIN FEATURES IF A USER IS LOGGED IN











*/