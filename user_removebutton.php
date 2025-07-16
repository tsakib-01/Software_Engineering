<?php
include('db_connection.php');  // Make sure this file contains the database connection setup

// Check if the POST request contains the necessary data
if (isset($_POST['cart_productID'])) {
    // Get the product ID from the form
    $cartProductID = $_POST['cart_productID'];

    // Prepare the SQL query to delete the item from the cart_table
    $sql = "DELETE FROM cart_table WHERE cart_productID = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the product ID parameter to the SQL statement
        $stmt->bind_param('i', $cartProductID);  // 'i' is for integer type

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to a page (e.g., cart.php or previous page) after successful deletion
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            // Error executing the query
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Error preparing the query
        echo "Error: " . $conn->error;
    }
} else {
    // If no cart_productID is provided
    echo "No product ID provided!";
}

// Close the database connection
$conn->close();
?>
