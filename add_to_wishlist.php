<?php
// Include the database connection
include('db_connection.php');

// Get product ID, email, and product title from the URL
$product_id = isset($_GET['productID']) ? $_GET['productID'] : null;
$email = isset($_GET['email']) ? $_GET['email'] : null;
$title = isset($_GET['titles']) ? $_GET['titles'] : null;

// Capture the referring page to redirect back later
$referrer = $_SERVER['HTTP_REFERER'];

if ($product_id && $email && $title) {
    // Fetch the current wishlist for the user
    $query = "SELECT wishlist FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $current_wishlist = $user['wishlist'];

        // Convert comma-separated string to array and clean it
        $wishlist_items = explode(',', $current_wishlist);
        $wishlist_items = array_map('trim', $wishlist_items);         // remove extra spaces
        $wishlist_items = array_filter($wishlist_items);              // remove empty strings
        $wishlist_items = array_unique($wishlist_items);              // remove duplicates

        // Add the new title if it's not already in the wishlist
        if (!in_array($title, $wishlist_items)) {
            $wishlist_items[] = $title;

            // Clean again before saving
            $wishlist_items = array_map('trim', $wishlist_items);
            $wishlist_items = array_filter($wishlist_items);
            $wishlist_items = array_unique($wishlist_items);

            $updated_wishlist = implode(',', $wishlist_items);

            // Update the wishlist in the database
            $update_query = "UPDATE users SET wishlist = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $updated_wishlist, $email);
            $update_stmt->execute();
        }
    }
}

// Redirect back to the referring page
header("Location: $referrer");
exit;

$conn->close();
?>
