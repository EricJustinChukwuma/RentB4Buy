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


<?php
    if(isset($_SESSION["user_id"])) {
?>
    <div class="cart-container">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
        <span class="cart-counter">0</span>
    </div>
<?php
    } else {
        echo "";
    }
?>