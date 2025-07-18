<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login.php');
    die();
};

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT c.id as cart_id, p.name, p.price, p.image FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ? AND c.rental_flag = 1");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
?>

<h2>Your Rental Cart</h2>
<form action="checkout_rentals.php" method="POST">
<?php while ($row = $result->fetch_assoc()): ?>
    <div class="cart-item">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="80" />
        <p><?php echo htmlspecialchars($row['name']); ?> - $<?php echo $row['price']; ?></p>
        <label>Start Date: <input type="date" name="start_date[<?php echo $row['cart_id']; ?>]" required></label>
        <label>End Date: <input type="date" name="end_date[<?php echo $row['cart_id']; ?>]" required></label>
    </div>
<?php endwhile; ?>
<button type="submit">Confirm Rentals</button>
</form>
