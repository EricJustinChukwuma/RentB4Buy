<?php
// Load Stripe library
require_once __DIR__ . '/stripe/Stripe.php';  // base class
require_once __DIR__ . '/stripe/Customer.php';
require_once __DIR__ . '/stripe/Charge.php';
require_once __DIR__ . '/stripe/Token.php';
require_once __DIR__ . '/stripe/ApiResource.php';
// (You can require additional files if needed, or use an autoloader if one is included)

// Set your secret Stripe API key
\Stripe\Stripe::setApiKey('sk_test_YOUR_SECRET_KEY_HERE'); // Replace with your secret key
