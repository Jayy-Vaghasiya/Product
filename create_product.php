<?php
// check if the user is logged in
session_start();
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
}

// handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // validate user input
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image = $_FILES['image']['name'];
    $price = floatval($_POST['price']);

    // sanitize user input
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $price = filter_var($price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // validate the image file
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    if (!in_array($file_ext, $allowed_types)) {
        echo "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.";
        exit();
    }

    // move the uploaded image to the server
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // insert the new product into the database
    $sql = "INSERT INTO Product (name, description, image, price, created_at, updated_at) VALUES (:name, :description, :image, :price, NOW(), NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'description' => $description, 'image' => $image, 'price' => $price]);

    // redirect to the product list page
    header("Location: login.php");
    exit();
}
?>