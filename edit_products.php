<?php
include 'db_connection.php';

// Check if an ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch product data from the database based on productID
    $sql = "SELECT * FROM `product_table` WHERE productID = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

// Check if the form has been submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];  // Get the description
       $category = $_POST['category']; 
    $popular = isset($_POST['popular']) ? 1 : 0;  // If popular is checked, set to 1, otherwise 0
    $latest = isset($_POST['latest']) ? 1 : 0;    // If latest is checked, set to 1, otherwise 0

    // Handle the image upload if a new image is selected
    if (isset($_FILES['productIMG']) && $_FILES['productIMG']['error'] == 0) {
        $img_tmp = $_FILES['productIMG']['tmp_name'];
        $img_name = $_FILES['productIMG']['name'];
        $img_size = $_FILES['productIMG']['size'];
        $img_error = $_FILES['productIMG']['error'];
        
        // Validate the image
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = mime_content_type($img_tmp);
        
        if (in_array($file_type, $allowed_types)) {
            // Read the image file and convert it to base64
            $image_data = file_get_contents($img_tmp);
            $base64_image = base64_encode($image_data);
            
            // Update the product in the database with the base64 encoded image and description
            $sql = "UPDATE `product_table` SET titles = ?, subtitles = ?, price = ?, discount = ?, quantity = ?, description = ?, category = ?, productIMG = ?, popular = ?, latest = ? WHERE productID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssdiissiii', $title, $subtitle, $price, $discount, $quantity, $description, $category, $base64_image, $popular, $latest, $id);
            $stmt->execute();
        } else {
            echo "Invalid image type. Only JPEG, PNG, or GIF are allowed.";
        }
    } else {
        // If no new image, just update other fields
        $sql = "UPDATE `product_table` SET titles = ?, subtitles = ?, price = ?, discount = ?, quantity = ?, description = ?, category = ?, popular = ?, latest = ? WHERE productID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdiissiii', $title, $subtitle, $price, $discount, $quantity, $description, $category, $popular, $latest, $id);
        $stmt->execute();
    }

   header("Location: admin_products.php");
exit;

}
$conn->close();
?>


<!-- HTML Form for Editing Product -->
<form method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-xl space-y-6">
    <h2 class="text-2xl font-semibold text-center text-gray-800">Edit Product</h2>

    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($product['titles']); ?>" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Subtitle -->
    <div>
        <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
        <input type="text" name="subtitle" value="<?php echo htmlspecialchars($product['subtitles']); ?>" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Price -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Discount -->
        <div>
            <label for="discount" class="block text-sm font-medium text-gray-700">Discount</label>
            <input type="number" name="discount" value="<?php echo $product['discount']; ?>" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <!-- Quantity -->
    <div>
        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>

    <!-- Subtitle -->
    <div>
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required class="mt-1 w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Popular & Latest -->
    <div class="flex items-center space-x-6">
        <label class="inline-flex items-center space-x-2">
            <input type="checkbox" name="popular" <?php echo $product['popular'] == 1 ? 'checked' : ''; ?> class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="text-sm text-gray-700">Popular</span>
        </label>
        <label class="inline-flex items-center space-x-2">
            <input type="checkbox" name="latest" <?php echo $product['latest'] == 1 ? 'checked' : ''; ?> class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <span class="text-sm text-gray-700">Latest</span>
        </label>
    </div>

    <!-- Product Image -->
    <div>
        <label for="productIMG" class="block text-sm font-medium text-gray-700">Upload Product Image</label>
        <input type="file" name="productIMG" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
            Update Product
        </button>
    </div>
</form>
