<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $cartID = $_GET['id'];

    $sql = "DELETE FROM cart_table WHERE cartID = $cartID";
    
    if ($conn->query($sql)) {
        header('Location: admin_orders.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
