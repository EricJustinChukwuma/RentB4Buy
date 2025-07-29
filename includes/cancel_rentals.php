<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (!isset($_POST['rental_id']) || !isset($_SESSION['user_id'])) {
    die("Unauthorized.");
}

$rental_id = $_POST['rental_id'];
$user_id = $_SESSION['user_id'];

// Only allow cancellation if rental is still pending
$sql = "UPDATE rentals SET rent_status = 'cancelled' 
        WHERE rental_id = :rental_id AND user_id = :user_id AND rent_status = 'pending'";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':rental_id', $rental_id);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

header("Location: ../html/MyRentals.php");
exit();
