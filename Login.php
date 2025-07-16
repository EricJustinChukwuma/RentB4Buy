<?php
    require_once "includes/config_session.inc.php";
    // require_once "includes/Signup_View.inc.php";
    require_once "includes/Login_View.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>
        <?php
            output_username();
        ?>
    </h3>


    <h1>Login</h1>

    <form action="includes/Login.inc.php" method="POST">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="pwd" placeholder="Password">

        <button type="submit">Login</button>
    </form>

    <?php
        check_login_errors();
    ?>

    

    <h1>Logout</h1>
    <form action="includes/Logout.inc.php" method="POST">
        <button>Logout</button>
    </form>

</body>
</html>