<?php
    // NEED TO HAVE A SESSION STARTED HENCE I HAVE TO REQUIRE THE 'config_session.inc.php' file where i have a more secured session started and managed.
    require_once "includes/config_session.inc.php";
    require_once "includes/Signup_View.inc.php";
    // require_once "includes/Login_View.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Signup</h1>
    <form action="includes/Signup.inc.php" method="POST">
        <!-- <input type="text" name="username" placeholder="Username">
        <input type="text" name="firstname" placeholder="Firstname">
        <input type="text" name="lastname" placeholder="Lastname">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="pwd" placeholder="Password"> -->

        <?php
            signup_inputs();
        ?>

        <button type="submit">Signup</button>
    </form>
    
    <?php
        check_signup_errors();
    ?>
    

    <!-- <h1>Logout</h1>
    <form action="includes/Logout.inc.php" method="POST">
        <button>Logout</button>
    </form> -->

</body>
</html>