<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];  
    $category = $_POST['category']; 
    $popular = isset($_POST['popular']) ? 1 : 0;  
    $latest = isset($_POST['latest']) ? 1 : 0;    

    // Function to convert image to base64
    function encodeImage($inputName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === 0) {
            $tmp = $_FILES[$inputName]['tmp_name'];
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (in_array(mime_content_type($tmp), $allowed_types)) {
                return base64_encode(file_get_contents($tmp));
            }
        }
        return null;
    }

    $productIMG = encodeImage('productIMG');
    $productIMG_2 = encodeImage('productIMG_2');
    $productIMG_3 = encodeImage('productIMG_3');

    $sql = "INSERT INTO `product_table` 
    (titles, subtitles, price, discount, quantity, description, productIMG, productIMG_2, productIMG_3, category, popular, latest) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssddisssssii', $title, $subtitle, $price, $discount, $quantity, $description, $productIMG, $productIMG_2, $productIMG_3, $category, $popular, $latest);
    
    if ($stmt->execute()) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-semibold text-center text-gray-800 mb-6">Create New Product</h1>

        <!-- New Product Form -->
        <form action="create_products.php" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <!-- Title -->
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>

            <!-- Subtitle -->
            <label for="subtitle" class="block text-sm font-medium text-gray-700 mt-4">Subtitle</label>
            <input type="text" name="subtitle" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>

<!-- Description -->
<label for="description" class="block text-sm font-medium text-gray-700 mt-4">Description</label>
<textarea name="description" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>


            <!-- Price -->
            <label for="price" class="block text-sm font-medium text-gray-700 mt-4">Price</label>
            <input type="number" name="price" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>

            <!-- Discount -->
            <label for="discount" class="block text-sm font-medium text-gray-700 mt-4">Discount</label>
            <input type="number" name="discount" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>

            <!-- Quantity -->
            <label for="quantity" class="block text-sm font-medium text-gray-700 mt-4">Quantity</label>
            <input type="number" name="quantity" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>

         <!-- Product Image 1 -->
<label for="productIMG" class="block text-sm font-medium text-gray-700 mt-4">Product Image 1</label>
<input type="file" name="productIMG" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">

<!-- Product Image 2 -->
<label for="productIMG_2" class="block text-sm font-medium text-gray-700 mt-4">Product Image 2</label>
<input type="file" name="productIMG_2" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">

<!-- Product Image 3 -->
<label for="productIMG_3" class="block text-sm font-medium text-gray-700 mt-4">Product Image 3</label>
<input type="file" name="productIMG_3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">

            
            <!-- Category -->
            <label for="category" class="block text-sm font-medium text-gray-700 mt-4">Category</label>
            <input type="text" name="category" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>


            <!-- Popular -->
            <label for="popular" class="block text-sm font-medium text-gray-700 mt-4">Popular</label>
            <input type="checkbox" name="popular" class="mt-1">

            
            <!-- Latest -->
            <label for="latest" class="block text-sm font-medium text-gray-700 mt-4">Latest</label>
            <input type="checkbox" name="latest" class="mt-1">

            <!-- Submit Button -->
            <button type="submit" class="mt-6 bg-blue-500 text-white p-2 rounded-lg w-full">Create Product</button>
        </form>
    </div>
</body>
</html>
