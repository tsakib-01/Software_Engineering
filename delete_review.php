<?php
session_start();
include('db_connection.php');

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$reviewID = $_POST['reviewID'];
$userEmail = $_SESSION['email'];

// Verify review belongs to logged-in user
$stmt = $conn->prepare("SELECT email FROM reviews WHERE reviewID = ?");
$stmt->bind_param("i", $reviewID);
$stmt->execute();
$result = $stmt->get_result();
$review = $result->fetch_assoc();

if (!$review || $review['email'] !== $userEmail) {
    // Unauthorized delete attempt
    die('You do not have permission to delete this review.');
}

// Delete review
$deleteStmt = $conn->prepare("DELETE FROM reviews WHERE reviewID = ?");
$deleteStmt->bind_param("i", $reviewID);
$deleteStmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>
