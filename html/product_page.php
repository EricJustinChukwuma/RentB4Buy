<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/product_page.css">
</head>
<body>
    <header id="header" class="section">
        <nav id="navbar-container">

            <div class="logo-container">
                <a class="logo" href="index.html">
                    <span>Rent</span>
                    <span>b4</span>
                    <span>Buy</span>
                </a>
            </div>

            <div class="navbar">
                <div class="nav-links">
                    <a href="../html/index.php">Home</a>
                    <a href="../html/product_page.php">Products</a>
                    <a href="../html/About.php">About</a>
                    <a href="../html/How_it_works.html">How it works</a>
                    <a href="../html/Contact.html">Contact Us</a>
                </div>
                <div class="cart-container">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                    <span class="cart-counter">0</span>
                </div>
                <div class="signup-container">
                    <a href="../Signup.php">Signup</a>
                    <a href="../Login.php">Login</a>
                </div>
            </div>

        </nav>
    </header>

    <section id="search-section">
        <h1>Search our products!!</h1>
        <div class="search-section-container">
            <div class="search-container">
                <input id="search-input" type="text" placeholder="Search for products...">
            </div>
            <div class="categories-container">
                <div class="category-box cat-box-1">
                    <span class="category cat-1">Gadgets</span>
                    <ul class="category-list list-1">
                        <li>Phones</li>
                        <li>Laptops</li>
                        <li>Desktops</li>
                        <li>Tablets</li>
                        <li>Audio</li>
                    </ul>
                </div>
    
                <div class="category-box cat-box-2">
                    <span class="category cat-2">Furnitures</span>
                    <ul class="category-list list-2">
                        <li>Chairs</li>
                        <li>Tables</li>
                        <li>WardRobes</li>
                        <li>Soafers</li>
                        <li>Bed Frames</li>
                    </ul>
                </div>
    
                <div class="category-box cat-box-3">
                    <span class="category cat-3">Clothings</span>
                    <ul class="category-list list-3">
                        <li>Shirts</li>
                        <li>Trousers</li>
                        <li>Shorts</li>
                        <li>Shoes</li>
                        <li>Hats</li>
                        <li>Jackets</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <h1>Available Products</h1>
        <div id="product-list" class="product-list">
            
        </div>
    </div>


    <!-- <script src="../js/index.js"></script> -->
    <script src="../js/ProductPage.js"></script>
</body>
</html>