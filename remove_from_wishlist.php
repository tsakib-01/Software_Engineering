<?php


include('db_connection.php');  

$email = isset($_GET['email']) ? $_GET['email'] : (isset($_POST['email']) ? $_POST['email'] : null);


if ($email === null) {
    header("Location: login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productTitle'])) {
    $productTitle = $_POST['productTitle'];

    $query = "SELECT wishlist FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {

        $wishlistItems = explode(',', $row['wishlist']);
        $newWishlist = array_filter($wishlistItems, function($item) use ($productTitle) {
            return $item !== $productTitle; 
        });
        
    
        $newWishlistString = implode(',', $newWishlist);
        $updateQuery = "UPDATE users SET wishlist = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $newWishlistString, $email);
        $updateStmt->execute();

        
        if ($updateStmt->affected_rows > 0) {

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
          
            echo "Error: Could not remove product from wishlist.";
        }
    } else {

        echo "Error: User not found.";
    }
}
?>
