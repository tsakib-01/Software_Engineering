<?php
include('db_connection.php');

// Get email and first_name from the URL
$email = $_GET['email'] ?? '';
$first_name = $_GET['first_name'] ?? '';

// Retrieve order details (if any)
$sql_confirmation = "SELECT * FROM order_table WHERE order_useremail = '$email' ORDER BY order_date DESC LIMIT 1";
$result_confirmation = $conn->query($sql_confirmation);

if ($result_confirmation->num_rows > 0) {
    $order = $result_confirmation->fetch_assoc();
    // You can display the order details here
    echo "<h1>Order Confirmation</h1>";
    echo "<p>Thank you for your order, $first_name!</p>";
    echo "<p>Your order details:</p>";
    echo "<ul>";
    echo "<li>Order Number: " . $order['order_id'] . "</li>";
    echo "<li>Product: " . $order['order_titles'] . "</li>";
    echo "<li>Total: Tk." . number_format($order['order_total_cost'], 2) . "</li>";
    echo "</ul>";
} else {
    echo "<p>No order found.</p>";
}

$conn->close();
?>
