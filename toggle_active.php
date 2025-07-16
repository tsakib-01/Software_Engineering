<?php
// toggle_active.php
require 'db_connection.php'; // your DB connection file

if (isset($_GET['productID']) && isset($_GET['active'])) {
    $productID = (int) $_GET['productID'];
    $active = (int) $_GET['active'];

    $stmt = $conn->prepare("UPDATE product_table SET active = ? WHERE productID = ?");
    $stmt->bind_param("ii", $active, $productID);

    if ($stmt->execute()) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Failed to update status.";
    }
} else {
    echo "Invalid request.";
}
?>
