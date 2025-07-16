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
                    <?php
                        if(isset($_SESSION["user_role_id"]) && $_SESSION["user_role_id"] === 2) {
                    ?>
                        <a href="../html/Contact.php">Contact Us</a>
                    <?php
                        } else {
                            echo "";
                        };
                    ?>
                </div>
        
                <div class="signup-container">
                    <a href="../Signup.php">Signup</a>
                    <a href="../Login.php">Login</a>
                </div>
            </div>

        </nav>
    </header>


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