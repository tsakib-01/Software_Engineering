<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['productID'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $popular = isset($_POST['popular']) ? 1 : 0;
    $latest = isset($_POST['latest']) ? 1 : 0;

    // Start SQL update query
    $sql = "UPDATE product_table SET 
                titles=?, 
                subtitles=?, 
                price=?, 
                discount=?, 
                quantity=?, 
                description=?, 
                category=?, 
                popular=?, 
                latest=?";
    $types = "ssdiissii";
    $params = [$title, $subtitle, $price, $discount, $quantity, $description, $category, $popular, $latest];

    // Function to handle image processing
    function processImage($fieldName, $columnName, &$sql, &$types, &$params) {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === 0) {
            $tmp = $_FILES[$fieldName]['tmp_name'];
            $file_type = mime_content_type($tmp);
            $allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

            if (in_array($file_type, $allowed)) {
                $image_data = file_get_contents($tmp);
                $base64_image = base64_encode($image_data);
                $sql .= ", $columnName=?";
                $types .= "s";
                $params[] = $base64_image;
            }
        }
    }

    // Check and add image fields if uploaded
    processImage('productIMG', 'productIMG', $sql, $types, $params);
    processImage('productIMG_2', 'productIMG_2', $sql, $types, $params);
    processImage('productIMG_3', 'productIMG_3', $sql, $types, $params);

    // Finish query
    $sql .= " WHERE productID=?";
    $types .= "i";
    $params[] = $productID;

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    // Redirect
    header("Location: admin_products.php");
    exit;
}

$conn->close();
?>
