    <?php
    include('db_connection.php');

   // Get the product ID from the URL
if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    
    // Query to fetch product details from the products_table (or similar)
    $sql = "SELECT * FROM cart_table WHERE cartID = ?"; // Replace 'products_table' with the actual table name
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);  // Binding the product ID as an integer parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the product details
        $row = $result->fetch_assoc();
    } else {
        // If the product is not found, display an error message
        echo "Product not found.";
        exit();
    }
} else {
    // If no product ID is provided, redirect to orders page
    header('Location: admin_orders.php');
    exit();
}

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Details</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/x-icon" href="LOGO.png">
    </head>
    <body class="bg-gray-100">




        <h2 class="text-3xl font-semibold text-gray-800 flex justify-center">Product Details</h2>
    <!-- Main content area -->
    <div class="flex justify-center py-10">


        <!-- Product Details Section -->
        <div class="max-w-6xl w-full p-6 bg-white rounded-lg shadow-xl flex flex-col md:flex-row items-center md:items-start">

            <!-- Product Image Section -->
            <div class="w-full md:w-1/3 flex justify-center items-center h-full md:mb-0">
        <img src="data:image/jpeg;base64,<?php echo $row['cart_productIMG']; ?>" alt="Product Image" class="w-72 h-72 object-cover rounded-lg shadow-md">
    </div>



            <!-- Product Details Section -->
            <div class="w-full md:w-2/3 md:pl-8">
            
                <!-- Product Info Table -->
                <table class="w-full text-left table-auto mb-6">
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Product ID:</td>
                        <td class="py-2 px-4"><?= $row['cart_productID'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Category:</td>
                        <td class="py-2 px-4"><?= str_replace('+', ' ', $row['cart_category']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Subtitles:</td>
                        <td class="py-2 px-4"><?= str_replace('+', ' ', $row['cart_subtitles']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Title:</td>
                        <td class="py-2 px-4"><?= str_replace('+', ' ', $row['cart_titles']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Description:</td>
                        <td class="py-2 px-4"><?= str_replace('+', ' ', $row['cart_description']) ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Price:</td>
                        <td class="py-2 px-4"><?= $row['cart_price'] ?> Tk.</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Discount:</td>
                        <td class="py-2 px-4"><?= $row['cart_discount'] ?> Tk.</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Quantity:</td>
                        <td class="py-2 px-4"><?= $row['cart_quantity'] ?></td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2 px-4">Added to Cart:</td>
                        <td class="py-2 px-4"><?= $row['added_to_cart'] ?></td>
                    </tr>
                </table>

                <!-- Action Buttons -->
                <div class="flex space-x-4 justify-center md:justify-start">
                    <a href="order_delete.php?id=<?= $row['cartID'] ?>" class="bg-red-500 text-white py-2 px-6 rounded-md hover:bg-red-600 transition-all">Delete</a>
                </div>
            </div>
        </div>

    </div>

    <!-- <style>
        *{
            outline: 1px solid red;
        }
    </style> -->

    </body>
    </html>
