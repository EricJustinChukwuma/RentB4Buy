<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";
require_once "../includes/admin_auth.inc.php";

// 1. Pending Rentals
$pending = $pdo->query("SELECT COUNT(*) AS pending_count FROM rentals WHERE rent_status = 'pending'")
              ->fetchColumn();

// 2. Most Rented Products
$topProducts = $pdo->query("
    SELECT products.product_name, products.product_image, COUNT(rentals.rental_id) AS rental_count
    FROM rentals
    JOIN products ON rentals.product_id = products.product_id
    GROUP BY products.product_id
    ORDER BY rental_count DESC
    LIMIT 5
")->fetchAll();

// 3. Revenue Over Time
$revenue = $pdo->query("
    SELECT DATE_FORMAT(request_date, '%Y-%m') AS month, SUM(total_price) AS total_revenue
    FROM rentals
    GROUP BY month
    ORDER BY month DESC
")->fetchAll();

// 4. Rentals Per User
$userRentals = $pdo->query("
    SELECT users.username, COUNT(rentals.rental_id) AS rental_count
    FROM rentals
    JOIN users ON rentals.user_id = users.id
    GROUP BY users.id
    ORDER BY rental_count DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Analytics Dashboard</title>
    <link rel="stylesheet" href="../css/index_1.css">
    <style>
        body { font-family: Arial; }
        h2 { margin-top: 2rem; }
        table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        .stat { font-size: 1.5rem; margin: 1rem 0; }
    </style>
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

                <?php if(isset($_SESSION['user_id']) && isset($_SESSION["user_role_id"]) && $_SESSION["user_role_id"] === 2) : ?>
                    <div class="cart-container">
                        <a href="./Cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                        </a>
                        <span class="cart-counter <?php echo isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ? "counter-value" : " " ?>">
                            <?php  
                                if(isset($_SESSION['cart'])) {
                                    echo  count($_SESSION['cart']);
                                } else {
                                    echo 0;
                                }
                            ?>
                        </span>
                    </div>
                <?php endif ?>

                <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION["user_initials"])) :
                ?>
                    <div class="user-menu-container">
                        <span class="user-initials">
                            <?= $_SESSION["user_initials"]; ?>
                        </span>
                        <ul class="profile-menu">
                            <li>
                                <a href="ProfilePage.php">Profile</a>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M240 192C240 147.8 275.8 112 320 112C364.2 112 400 147.8 400 192C400 236.2 364.2 272 320 272C275.8 272 240 236.2 240 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM144 544C144 473.3 201.3 416 272 416L368 416C438.7 416 496 473.3 496 544L496 552C496 565.3 506.7 576 520 576C533.3 576 544 565.3 544 552L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 552C96 565.3 106.7 576 120 576C133.3 576 144 565.3 144 552L144 544z"/></svg>
                            </li>
                            <li>
                                <a href="">Settings</a>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/></svg>
                            </li>
                            <li>
                                <a href="../includes/Logout.inc.php">Logout</a>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 160C241.7 160 256 145.7 256 128C256 110.3 241.7 96 224 96L160 96C107 96 64 139 64 192L64 448C64 501 107 544 160 544L224 544C241.7 544 256 529.7 256 512C256 494.3 241.7 480 224 480L160 480C142.3 480 128 465.7 128 448L128 192C128 174.3 142.3 160 160 160L224 160zM566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L438.6 169.3C426.1 156.8 405.8 156.8 393.3 169.3C380.8 181.8 380.8 202.1 393.3 214.6L466.7 288L256 288C238.3 288 224 302.3 224 320C224 337.7 238.3 352 256 352L466.7 352L393.3 425.4C380.8 437.9 380.8 458.2 393.3 470.7C405.8 483.2 426.1 483.2 438.6 470.7L566.6 342.7z"/></svg>
                            </li>
                        </ul>
                        <h3>Hi, <?= $_SESSION["user_firstname"] . " " . $_SESSION["user_lastname"]?></h3>
                    </div>
                <?php endif; ?>

                
        
                <?php
                    if (!isset($_SESSION['user_id'])) :
                ?>
                    <div class="signup-container">
                        <a href="../Signup.php">Signup</a>
                        <a href="../Login.php">Login</a>
                    </div>

                <?php endif; ?>
            </div>

        </nav>
    </header>

    <div>
        <h1>📈 Admin Dashboard</h1>

        <div class="stat">
            🔄 <strong>Pending Rentals:</strong> <?= $pending ?>
        </div>

        <h2>🔝 Most Rented Products</h2>
        <table>
            <tr><th>Product</th><th>Rentals</th></tr>
            <?php foreach ($topProducts as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                    <td><?= $product['rental_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>💰 Revenue Over Time (Monthly)</h2>
        <table>
            <tr><th>Month</th><th>Revenue (£)</th></tr>
            <?php foreach ($revenue as $row): ?>
                <tr>
                    <td><?= $row['month'] ?></td>
                    <td><?= number_format($row['total_revenue'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>👤 Rentals Per User</h2>
        <table>
            <tr><th>User</th><th>Total Rentals</th></tr>
            <?php foreach ($userRentals as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= $user['rental_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
