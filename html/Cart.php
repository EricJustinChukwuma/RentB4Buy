<?php
require_once "../includes/config_session.inc.php";
require_once "../includes/dbh.inc.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];
$totalCost = 0;

// $_SESSION['cart-total-price'] = $totalCost;

$_SESSION['single-product-cost'] = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../css/index3.css">
    <link rel="stylesheet" href="../css/cart.css">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
        }
        .cart-container { 
            max-width: 800px; 
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: center; }
        img { width: 70px; height: auto; }
        .btn { padding: 5px 10px; margin: 2px; cursor: pointer; }
        .btn-remove { background: #e74c3c; color: white; border: none; }
        .btn-update { background: #3498db; color: white; border: none; }
        .btn-checkout { background: #2ecc71; color: white; padding: 10px 20px; border: none; }
    </style>
</head>
<body>
    <div class="cart-container">
        <h1>Your Rental Cart</h1>
        
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price/Day (£)</th>
                        <th>Quantity</th>
                        <th>Total (£)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): 
                        $itemTotal = $item['price_per_day'] * $item['quantity']; // sets product total price
                        $totalCost += $itemTotal;
                        $_SESSION['cart-total-price'] = $totalCost;

                        // Creates a session variable for each of the item and adds its total cost to the variable with the product id as the key to 
                        // the associative array which is the value. only if the variable is not set.
                        if(!isset($_SESSION['single-product_cost'])) {
                            $_SESSION['single-product_cost'][$item['product_id']] = [
                                "item_cost" => $itemTotal
                            ];
                        };
                    ?>
                        <tr data-id="<?php echo $item['product_id']; ?>">
                            <td><img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>"></td>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>£<?php echo htmlspecialchars($item['price_per_day']); ?></td>
                            <td>
                                <button class="btn btn-update decrease">-</button>
                                <span class="quantity"><?php echo $item['quantity']; ?></span>
                                <button class="btn btn-update increase">+</button>
                            </td>
                            <td class="item-total">£<?php echo number_format($itemTotal, 2); ?></td>
                            <td><button class="btn btn-remove remove">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
                        <td colspan="2">£<?php echo number_format($totalCost, 2); ?></td>
                    </tr>
                </tfoot>
            </table>

            <button id="btn-checkout" class="btn-checkout" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        <?php endif; ?>
    </div>

    <script>
        // Handle quantity updates and removal
        document.querySelectorAll(".increase").forEach(button => {
            button.addEventListener("click", function() {
                updateQuantity(this.closest("tr").dataset.id, 1);
            });
        });

        document.querySelectorAll(".decrease").forEach(button => {
            button.addEventListener("click", function() {
                updateQuantity(this.closest("tr").dataset.id, -1);
            });
        });

        document.querySelectorAll(".remove").forEach(button => {
            button.addEventListener("click", function() {
                removeItem(this.closest("tr").dataset.id);
            });
        });

        function updateQuantity(productId, change) {
            fetch("../includes/update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ product_id: productId, change: change })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    location.reload(); // Refresh cart page when there is a change to product quantity
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        }

        function removeItem(productId) {
            fetch("../includes/update_cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ product_id: productId, action: "remove" })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    location.reload(); // Refresh cart page
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error(err));
        }
    </script>
</body>
</html>
