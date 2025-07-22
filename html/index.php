<?php
    require_once "../includes/config_session.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent B4 Buy/Home</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <header id="header" class="section">
        <nav id="navbar-container">

            <div class="logo-container">
                <a class="logo" href="../html/index.html">
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
                    <a href="../html/How_it_works.php">How it works</a>
                    <a href="../html/Contact.php">Contact Us</a>
                </div>

                <div class="cart-container">
                    <a href="./Cart.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                    </a>
                    <span class="cart-counter">0</span>
                </div>

                
        
                <div class="signup-container">
                    <a href="../Signup.php">Signup</a>
                    <a href="../Login.php">Login</a>
                </div>
            </div>

        </nav>
    </header>


    <main id="banner-container">
        <div class="banner">
            <h1>Experience Products Before You Commit</h1>
            <p>Transform your shopping route. Rent-efore-buy let's you experience products before you decide. Get a first hand experience of products b4 you commit to purchasing. Our Products are offered at the most affordable prices. Spend a day with the product, a week or a month.</p>
            <a href="">Get Started</a>
        </div>
    </main>

    <section id="offers-section">
        <div class="offers-container">
            <h1>WHAT WE OFFER</h1>
            <div>
                <div class="offer">
                    <h3>High quality products</h3>
                    <p>We provide high quality tech gadgets with certified quality check</p>
                </div>
                <div class="offer">
                    <h3>No hidden cost</h3>
                    <p>No extra hidden fees for any transaction. Never pay more than 20% product price for any rental.</p>
                </div>
                <div class="offer">
                    <h3>Damage protection</h3>
                    <p>You are covered for damages to product by up to 70% of the product cost</p>
                </div>
                <div class="offer">
                    <h3>Best deals you can trust</h3>
                    <p>Pay less for a longer rental period above 1 month</p>
                </div>
            </div>
            <div class="line"></div>
        </div>
    </section>


    <section>
        <div>
            <h1>Top Rentals</h1>
            <div>
                <img src="" alt="img of most rented and bought app">
                <img src="" alt="img of most rented and bought app">
                <img src="" alt="img of most rented and bought app">
                <img src="" alt="img of most rented and bought app">
            </div>
        </div>
    </section>

    <section id="rent-section">
        <div class="rent-container">
            <h1>How To Rent</h1>
            <div>
                <div class="rent-steps">
                    <span>1</span>
                    <div>
                        <p>Register</p> <br>
                        <p>with</p> <br>
                        <p>us</p>
                    </div>
                </div>

                <div class="rent-steps">
                    <span>2</span>
                    <div>
                        <p>Browse and</p> <br>
                        <p>choose a</p> <br>
                        <p>product</p>
                    </div>
                </div>

                <div class="rent-steps">
                    <span>3</span>
                    <div>
                        <p>Proceed</p> <br>
                        <p>to</p> <br>
                        <p>checkout</p>
                    </div>
                </div>

                <div class="rent-steps">
                    <span>4</span>
                    <div>
                        <p>Sit and</p> <br>
                        <p>wait for</p> <br>
                        <p>delivery</p>
                    </div>
                </div>
            </div>
            <div class="line"></div>
        </div>  
    </section>

    <footer>
        <div class="footer-container">
            <a class="footer-logo" href="index.html">
                <span>Rent</span> <br>
                <span>b4</span> <br>
                <span>Buy</span>
            </a>
            <div>
                <h5>The Company</h5>
                <a href="">About the company</a>
                <a href="">Help Center</a>
                <a href="">Reviews</a>
            </div>
            <div>
                <h5>Info</h5>
                <a href="">How it works</a>
                <a href="">Terms & Conditions</a>
                <a href="">FAQ's</a>
                <a href="">Legal</a>
                <a href="">Privacy Policy</a>
            </div>
        </div>
    </footer>
</body>
</html>

<!-- <div class="category-container">
    <div class="category">
        <a href="">Gadgets</a>
        <div>
            <ul>
                <li>Phones</li>
                <li>Laptops</li>
                <li>Desktops</li>
                <li>Tablets</li>
                <li>Phones</li>
            </ul>
        </div>
    </div>
    <div class="category">
        <a href="">Furnitures</a>
        <div>
            <ul>
                <li>Chairs</li>
                <li>Tables</li>
                <li>WardRobes</li>
                <li>Soafers</li>
                <li>Bed Frames</li>
            </ul>
        </div>
    </div>
    <div class="category">
        <a href="">Clothings</a>
        <div>
            <ul>
                <li>Shirts</li>
                <li>Trousers</li>
                <li>Shorts</li>
                <li>Shoes</li>
                <li>Hats</li>
                <li>Jackets</li>
            </ul>
        </div>
    </div>

    
</div> -->