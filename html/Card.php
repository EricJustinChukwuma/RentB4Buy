<?php

    //don't forget to add a conditions thats lets you save their card if they want and not if they don't
    $sql = "SELECT Cards.*, users.username 
            FROM Cards
            Join users ON Cards.card_id = users.id
            ORDER BY Cards.card_id"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>