<?php
    require_once "../includes/config_session.inc.php";

    // Ensure that the profile page cannot be accessed if user is not logged in
    if (!isset($_SESSION["user_id"]) || !isset($_SESSION["user_role_id"])) {
        header("Location: ../Login.php");
        exit();
    };
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent B4 Buy/Home</title>
    <link rel="stylesheet" href="../css/index_7.css">
    <link rel="stylesheet" href="../css/Profile_2.css">
</head>
<body>
    <header id="header" class="section">
        <nav id="navbar-container">

            <div class="logo-container">
                <a class="logo" href="../html/index.php">
                    <span>Rent</span>
                    <span>b4</span>
                    <span>Buy</span>
                </a>
            </div>

            <div class="navbar">
                <div class="nav-links">
                    <a class="active" href="../html/index.php">Home</a>
                    <a href="../html/product_page.php">Products</a>
                    <a href="../html/About.php">About</a>
                    <a href="../html/How_it_works.php">How it works</a>
                    <a href="../html/Contact.php">Contact Us</a>
                </div>

                <?php if(isset($_SESSION['user_id']) && isset($_SESSION["user_role_id"]) && $_SESSION["user_role_id"] === 1) { 
                        echo "";
                    } else {
                ?>
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
                <?php }; ?>


                <?php
                    if (isset($_SESSION['user_id']) && isset($_SESSION["user_initials"])) :
                ?>
                    <div class="user-menu-container">
                        <span class="user-initials">
                            <?= $_SESSION["user_initials"]; ?>
                        </span>
                        <ul class="profile-menu">
                            <li>
                                <a href="ProfilePage.php">
                                    Profile
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M240 192C240 147.8 275.8 112 320 112C364.2 112 400 147.8 400 192C400 236.2 364.2 272 320 272C275.8 272 240 236.2 240 192zM448 192C448 121.3 390.7 64 320 64C249.3 64 192 121.3 192 192C192 262.7 249.3 320 320 320C390.7 320 448 262.7 448 192zM144 544C144 473.3 201.3 416 272 416L368 416C438.7 416 496 473.3 496 544L496 552C496 565.3 506.7 576 520 576C533.3 576 544 565.3 544 552L544 544C544 446.8 465.2 368 368 368L272 368C174.8 368 96 446.8 96 544L96 552C96 565.3 106.7 576 120 576C133.3 576 144 565.3 144 552L144 544z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    Settings
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/></svg>
                                </a>
                            </li>
                            <li>
                                <a href="../includes/Logout.inc.php">
                                    Logout
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 160C241.7 160 256 145.7 256 128C256 110.3 241.7 96 224 96L160 96C107 96 64 139 64 192L64 448C64 501 107 544 160 544L224 544C241.7 544 256 529.7 256 512C256 494.3 241.7 480 224 480L160 480C142.3 480 128 465.7 128 448L128 192C128 174.3 142.3 160 160 160L224 160zM566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L438.6 169.3C426.1 156.8 405.8 156.8 393.3 169.3C380.8 181.8 380.8 202.1 393.3 214.6L466.7 288L256 288C238.3 288 224 302.3 224 320C224 337.7 238.3 352 256 352L466.7 352L393.3 425.4C380.8 437.9 380.8 458.2 393.3 470.7C405.8 483.2 426.1 483.2 438.6 470.7L566.6 342.7z"/></svg>
                                </a>
                            </li>
                        </ul>
                        <h3>Hi, <?= $_SESSION["user_firstname"] . " " . $_SESSION["user_lastname"];?></h3>
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

            <span id="sidenav-open">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 160C96 142.3 110.3 128 128 128L512 128C529.7 128 544 142.3 544 160C544 177.7 529.7 192 512 192L128 192C110.3 192 96 177.7 96 160zM96 320C96 302.3 110.3 288 128 288L512 288C529.7 288 544 302.3 544 320C544 337.7 529.7 352 512 352L128 352C110.3 352 96 337.7 96 320zM544 480C544 497.7 529.7 512 512 512L128 512C110.3 512 96 497.7 96 480C96 462.3 110.3 448 128 448L512 448C529.7 448 544 462.3 544 480z"/></svg>
            </span>


            <div id="sidenav" class="sidenav">
                <button id="close-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
                <a href="ProfilePage.php" id="view-profile">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/></svg>
                    <span>View Profile</span>
                </a>
                <a href="index.php">Home</a>
                <a href="product_page.php">Products</a>
                <a href="about.php">About</a>
                <a href="How_it_works.php">How it works</a>
                <a href="contact.php">Contact Us</a>

                <?php
                    if (!isset($_SESSION['user_id'])) {
                ?>
                    <div class="signup-container">
                        <a href="../Signup.php">Signup</a>
                        <a href="../Login.php">Login</a>
                    </div>

                <?php } else { ?>
                    <div class="sidenav-logout-container">
                        <a href="../includes/Logout.inc.php">
                            Logout
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M224 160C241.7 160 256 145.7 256 128C256 110.3 241.7 96 224 96L160 96C107 96 64 139 64 192L64 448C64 501 107 544 160 544L224 544C241.7 544 256 529.7 256 512C256 494.3 241.7 480 224 480L160 480C142.3 480 128 465.7 128 448L128 192C128 174.3 142.3 160 160 160L224 160zM566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L438.6 169.3C426.1 156.8 405.8 156.8 393.3 169.3C380.8 181.8 380.8 202.1 393.3 214.6L466.7 288L256 288C238.3 288 224 302.3 224 320C224 337.7 238.3 352 256 352L466.7 352L393.3 425.4C380.8 437.9 380.8 458.2 393.3 470.7C405.8 483.2 426.1 483.2 438.6 470.7L566.6 342.7z"/></svg>
                        </a>
                    </div>
                <?php }; ?>
            </div>

        </nav>
    </header>

    <main id="profile-main">
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 1) { ?>

            <div class="profile-main-info">
                <h1><?= $_SESSION['user_firstname'] . " " . $_SESSION['user_lastname'] ?></h1>
                <h5><?= $_SESSION['user_email'] ?></h5>
            </div>

            <div class="profile-info-settings">
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/></svg></span>
                    <h3>Your Personal Information</h3>
                    <p>Review and update your personal information such as username, name, email, address and password as an admin.</p>
                    <a href="update_profile.php">Manage your profile</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 64L288 128C288 136.8 295.2 144 304 144L336 144C344.8 144 352 136.8 352 128L352 64L384 64C419.3 64 448 92.7 448 128L448 256C448 261.5 447.3 266.9 446 272L194 272C192.7 266.9 192 261.5 192 256L192 128C192 92.7 220.7 64 256 64L288 64zM384 576C372.8 576 362.2 573.1 353 568C362.5 551.5 368 532.4 368 512L368 384C368 363.6 362.5 344.5 353 328C362.2 322.9 372.7 320 384 320L416 320L416 384C416 392.8 423.2 400 432 400L464 400C472.8 400 480 392.8 480 384L480 320L512 320C547.3 320 576 348.7 576 384L576 512C576 547.3 547.3 576 512 576L384 576zM64 384C64 348.7 92.7 320 128 320L160 320L160 384C160 392.8 167.2 400 176 400L208 400C216.8 400 224 392.8 224 384L224 320L256 320C291.3 320 320 348.7 320 384L320 512C320 547.3 291.3 576 256 576L128 576C92.7 576 64 547.3 64 512L64 384z"/></svg></span>
                    <h3>Update products listings</h3>
                    <p>Manage your card information. Update an existing card payment information or add another card for payment.</p>
                    <a href="Admin_Products.php" class="card-setting">Manage Product Listing</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M432 96C387.8 96 352 131.8 352 176L352 424.2L54.8 513.4C37.9 518.4 28.3 536.3 33.4 553.2C38.5 570.1 56.3 579.7 73.2 574.7L388.7 480.1L432.4 480.1C432.2 482.7 432 485.4 432 488.1C432 536.7 471.4 576.1 520 576.1C568.6 576.1 608 536.7 608 488.1L608 96.1L432 96.1zM560 488C560 510.1 542.1 528 520 528C497.9 528 480 510.1 480 488C480 465.9 497.9 448 520 448C542.1 448 559.9 465.9 560 487.9L560 488zM83.9 213.5C50.1 223.8 31.1 259.6 41.4 293.4L69.5 385.2C79.8 419 115.6 438 149.4 427.7L241.2 399.6C275 389.3 294 353.5 283.7 319.7L255.6 227.9C245.3 194.1 209.5 175.1 175.7 185.4L83.9 213.5z"/></svg></span>
                    <h3>Manage and View All Rental</h3>
                    <p>View and manage ongoing rentals. Here you can set or update rental status of user</p>
                    <a href="../html/Admin_Rentals_Page.php">Manage Rentals</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M432 96C387.8 96 352 131.8 352 176L352 424.2L54.8 513.4C37.9 518.4 28.3 536.3 33.4 553.2C38.5 570.1 56.3 579.7 73.2 574.7L388.7 480.1L432.4 480.1C432.2 482.7 432 485.4 432 488.1C432 536.7 471.4 576.1 520 576.1C568.6 576.1 608 536.7 608 488.1L608 96.1L432 96.1zM560 488C560 510.1 542.1 528 520 528C497.9 528 480 510.1 480 488C480 465.9 497.9 448 520 448C542.1 448 559.9 465.9 560 487.9L560 488zM83.9 213.5C50.1 223.8 31.1 259.6 41.4 293.4L69.5 385.2C79.8 419 115.6 438 149.4 427.7L241.2 399.6C275 389.3 294 353.5 283.7 319.7L255.6 227.9C245.3 194.1 209.5 175.1 175.7 185.4L83.9 213.5z"/></svg></span>
                    <h3>Manage all users</h3>
                    <p>View and manage ongoing rentals. Here you can set or update rental status of user</p>
                    <a href="../html/Admin_Users.php">View Users</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 160C544 124.7 515.3 96 480 96L160 96zM216 288C229.3 288 240 298.7 240 312L240 424C240 437.3 229.3 448 216 448C202.7 448 192 437.3 192 424L192 312C192 298.7 202.7 288 216 288zM400 376C400 362.7 410.7 352 424 352C437.3 352 448 362.7 448 376L448 424C448 437.3 437.3 448 424 448C410.7 448 400 437.3 400 424L400 376zM320 192C333.3 192 344 202.7 344 216L344 424C344 437.3 333.3 448 320 448C306.7 448 296 437.3 296 424L296 216C296 202.7 306.7 192 320 192z"/></svg></span>
                    <h3>View Admin Dashboard</h3>
                    <p>View and analyse all stats related to entire platform</p>
                    <a href="../html/Admin_Dashboard.php">View Stats</a>
                </div>
            </div>


        <?php } elseif (isset($_SESSION['user_id']) && isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 2) { ?>


            <div class="profile-info-settings">
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z"/></svg></span>
                    <h3>Your Personal Information</h3>
                    <p>Review and update your personal information such as username, name, email, address and password for a better and smoother rental experience you trust.</p>
                    <a href="update_profile.php">Manage your profile</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 192L64 224L576 224L576 192C576 156.7 547.3 128 512 128L128 128C92.7 128 64 156.7 64 192zM64 272L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 272L64 272zM128 424C128 410.7 138.7 400 152 400L200 400C213.3 400 224 410.7 224 424C224 437.3 213.3 448 200 448L152 448C138.7 448 128 437.3 128 424zM272 424C272 410.7 282.7 400 296 400L360 400C373.3 400 384 410.7 384 424C384 437.3 373.3 448 360 448L296 448C282.7 448 272 437.3 272 424z"/></svg></span>
                    <h3>Your Card Information</h3>
                    <p>Manage your card information. Update an existing card payment information or add another card for payment.</p>
                    <a href="update_card_info.php" class="card-setting">Manage card payment</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 64C46.3 64 32 78.3 32 96C32 113.7 46.3 128 64 128L136.9 128L229 404.2C206.5 421.8 192 449.2 192 480C192 533 235 576 288 576C340.4 576 383.1 534 384 481.7L586.1 414.3C602.9 408.7 611.9 390.6 606.3 373.8C600.7 357 582.6 348 565.8 353.6L363.8 421C346.6 398.9 319.9 384.5 289.8 384L197.7 107.8C188.9 81.6 164.5 64 136.9 64L64 64zM240 480C240 453.5 261.5 432 288 432C314.5 432 336 453.5 336 480C336 506.5 314.5 528 288 528C261.5 528 240 506.5 240 480zM312.5 153.3C287.3 161.5 273.5 188.6 281.7 213.8L321.3 335.5C329.5 360.7 356.6 374.5 381.8 366.3L503.5 326.7C528.7 318.5 542.5 291.4 534.3 266.2L494.8 144.5C486.6 119.3 459.5 105.5 434.3 113.7L312.5 153.3z"/></svg></span>
                    <h3>Your Rental</h3>
                    <p>View and manage ongoing rentals. here you can see all your current rentals that are already booked for delivery, already delivered, active, or cancelled</p>
                    <a href="../html/MyRentals.php">View Rentals</a>
                </div>
                <div class="info-setting">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 128C64 110.3 78.3 96 96 96L544 96C561.7 96 576 110.3 576 128L576 160C576 177.7 561.7 192 544 192L96 192C78.3 192 64 177.7 64 160L64 128zM96 240L544 240L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 240zM248 304C234.7 304 224 314.7 224 328C224 341.3 234.7 352 248 352L392 352C405.3 352 416 341.3 416 328C416 314.7 405.3 304 392 304L248 304z"/></svg></span>
                    <h3>Your Rental History</h3>
                    <p>View your rentals since being a part of us. Take a look at all you've rented and you might fancy one of them again</p>
                    <a href="../html/MyRentalsHistory.php" class="rent-history">View Rental History</a>
                </div>
            </div>

        <?php } else {
            echo "<h1>You are not logged in </h1>";
        } ?>
    </main>
    
    <footer>
        <div class="footer-container">
            <a class="footer-logo" href="./index.php">
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

    <script src="../js/index.js"></script>
</body>
</html>