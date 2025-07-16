<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$productID = $_POST['productID'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$email = $_SESSION['email'];

// Fetch fname from users table
$stmt = $conn->prepare("SELECT fname FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$fname = $user ? $user['fname'] : 'Anonymous';

// Insert review with fname from user table
$query = "INSERT INTO reviews (productID, name, email, rating, comment) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("issis", $productID, $fname, $email, $rating, $comment);
$stmt->execute();

header("Location: product.php?id=$productID&first_name=" . urlencode($fname) . "&email=" . urlencode($email));
exit;

?>
