<?php

$host = "localhost";
// $dbname = "mydatabase2";
$dbname = "rentb4buy";
$dbusername = "root";
$dbpassword = "";


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection Failed! " . $e->getMessage());
}



// $dsn = 'mysql:host=localhost;dbname=your_database;charset=utf8mb4';
// $username = 'your_username';
// $password = 'your_password';

// try {
//     $pdo = new PDO($dsn, $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }