<?php 
session_start(); // Start the session

include('db_connection.php');

// Check if user is logged in and productID is posted
if (isset($_SESSION['email']) && isset($_SESSION['first_name']) && isset($_POST['productID'])) {
    $userEmail = $_SESSION['email'];
    $firstName = $_SESSION['first_name'];
    $productID = intval($_POST['productID']);

    // Sanitize product info from POST
    $productIMG = isset($_POST['productIMG']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG'])) : '';
    $productIMG_2 = isset($_POST['productIMG']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG_2'])) : '';
    $productIMG_3 = isset($_POST['productIMG']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG_3'])) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : '';
    $subtitles = isset($_POST['subtitles']) ? mysqli_real_escape_string($conn, $_POST['subtitles']) : '';
    $titles = isset($_POST['titles']) ? mysqli_real_escape_string($conn, $_POST['titles']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conn, $_POST['price']) : '';
    $discount = isset($_POST['discount']) ? mysqli_real_escape_string($conn, $_POST['discount']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($quantity <= 0) {
        echo "Error: Invalid quantity.";
        exit();
    }

    // Check if product already in cart
    $checkQuery = "SELECT * FROM cart_table WHERE cart_email = '$userEmail' AND cart_productID = $productID";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // Already exists, update quantity
        $row = $checkResult->fetch_assoc();
        $newQuantity = $row['cart_quantity'] + $quantity;

        if ($newQuantity <= 0) {
            echo "Error: Invalid updated quantity.";
            exit();
        }

        $updateQuery = "UPDATE cart_table 
                        SET cart_quantity = $newQuantity, added_to_cart = NOW() 
                        WHERE cart_email = '$userEmail' AND cart_productID = $productID";

        if ($conn->query($updateQuery) === TRUE) {
            header("Location: product.php?productID=$productID&msg=added_to_cart");
            exit();
        } else {
            echo "Error updating cart: " . $conn->error;
            exit();
        }
    } else {
        // Not in cart, insert
        $insertQuery = "INSERT INTO cart_table (
                            cart_email, cart_productID, cart_productIMG,cart_productIMG_3, cart_productIMG_3, cart_category, 
                            cart_subtitles, cart_titles, cart_description, 
                            cart_price, cart_discount, cart_quantity, added_to_cart
                        ) 
                        VALUES (
                            '$userEmail', $productID, '$productIMG', '$productIMG_2', '$productIMG_3', '$category', 
                            '$subtitles', '$titles', '$description', 
                            '$price', '$discount', $quantity, NOW()
                        )";

        if ($conn->query($insertQuery) === TRUE) {
          header("Location: product.php?productID=$productID&first_name=" . urlencode($firstName) . "&email=" . urlencode($userEmail) . "&msg=added_to_cart");
 exit();
        } else {
            echo "Error inserting product into cart: " . $conn->error;
            exit();
        }
    }
} else {
    echo "Error: User not logged in or missing productID.";
    exit();
}

$conn->close();
?>
