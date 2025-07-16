<?php
include 'db_connection.php';


// Get the product ID from the URL
$productID = $_GET['id'];

// Delete query to remove the product from the table
$sql = "DELETE FROM `product_table` WHERE `productID` = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $productID);

    if ($stmt->execute()) {
        // Always redirect to admin_products.php after successful deletion
        header("Location: admin_products.php");
        exit;
    } else {
        // Handle error if deletion fails
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>

