<?php
session_start();

// check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// connect to the database
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=phpfinal';
 $username = 'root';
 $password = '*38BF1955F98718C9D7B76E384E6477B64818FCF0';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// retrieve the product information from the database
$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>