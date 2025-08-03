<?php
require_once "../vendor/autoload.php";
require_once "config_session.inc.php";
require_once "dbh.inc.php";

\Stripe\Stripe::setApiKey("sk_test_YOUR_SECRET_KEY");

// 1. Validate input
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id || !isset($_SESSION['cart'])) {
    die("Unauthorized or empty cart");
}

$start_date = $_POST['start_date'] ?? '';
$rental_days = intval($_POST['rental_days']);
$minStartDate = date('Y-m-d', strtotime('+3 days'));
if (empty($start_date) || $start_date < $minStartDate || $rental_days < 1) {
    die("Invalid rental start date");
}

// 2. Save form data to session for use after payment
$_SESSION['rental_days'] = $rental_days;
$_SESSION['start_date'] = $start_date;
$_SESSION['address'] = [
    'house_number' => $_POST['house-number'],
    'street_name' => $_POST['streetname'],
    'town' => $_POST['town'],
    'county' => $_POST['county'],
    'post_code' => $_POST['post-code']
];

// 3. Build Stripe Line Items
$line_items = [];
foreach ($_SESSION['cart'] as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'gbp',
            'product_data' => [
                'name' => $item['product_name'],
            ],
            'unit_amount' => $item['price_per_day'] * $item['quantity'] * $rental_days * 100, // in pence
        ],
        'quantity' => 1,
    ];
}

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $line_items,
    'mode' => 'payment',
    'success_url' => 'http://localhost/Dissertation_App2/html/checkout_success.php',
    'cancel_url' => 'http://localhost/Dissertation_App2/html/checkout.php',
]);

header("Location: " . $session->url);
exit;
