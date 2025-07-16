<?php
include('db_connection.php');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch settings from the table
$sql = "SELECT address, logo  FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Check if there's a row fetched
if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $address = $row['address'];
    $logo = $row['logo'];
   
} else {
    echo "No settings found.";
}
$conn->close();
?>

<?php
include 'db_connection.php';

// Initialize filter values
$category = isset($_GET['category']) ? $_GET['category'] : 'fish';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';
$firstName = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';



// Create SQL query based on filters
$sql = "SELECT * FROM `product_table` WHERE 1";

// Apply category filter if selected
if ($category != '') {
    $sql .= " AND `category` = '$category'";
}

// Apply price range filter if provided
if ($min_price != '' && $max_price != '') {
    $sql .= " AND `price` BETWEEN $min_price AND $max_price";
} elseif ($min_price != '') {
    $sql .= " AND `price` >= $min_price";
} elseif ($max_price != '') {
    $sql .= " AND `price` <= $max_price";
}

// Execute query
$result = $conn->query($sql);

// Store results in an array
$products = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();

// Set default title as 'All Products'
$title = 'All Products';

// Check if a category is selected and update the title accordingly
if ($category) {
    $title = ucfirst($category) . ' Products'; // Capitalize the first letter of the category
}
?>

<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" type="image/png" href="data:image/png;base64,<?php echo $logo; ?>">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>


  <div class="bg-blue-400 font-medium font-sans flex justify-center items-center h-9  text-white">
    Quick Order by Phone or Whatsapp:&nbsp;<a href="tel:+8801747536594">
      <div class="underline">01747536594</div>
    </a>
  </div>


<!-- Home Button -->
<!-- <div class="fixed top-20 right-1 mr-10  p-3 w-16 h-16 flex items-center justify-center text-white rounded-lg shadow-lg hover:bg-orange-500">
 <a href="welcome.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>"><i class="fa fa-home text-4xl"></i></a>
</div> -->

  <?php
// Initialize total price variable
$total_price = 0;
$coupon_discount = 0;

// Apply coupon logic
if (isset($_POST['coupon_code']) && $_POST['coupon_code'] == 'NewUSER') {
    $coupon_discount = 0.05; // 5% discount
}

// Get the cart_email from the URL
$cart_email = isset($_GET['email']) ? $_GET['email'] : '';
// Update cart based on quantity changes or product deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


// Include database connection (make sure it's correct)
include('db_connection.php');

// Check if connection is open
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the 'update_quantity' button was clicked
if (isset($_POST['update_quantity'])) {
    // Get the product ID and new quantity from the form input
    $product_id = $_POST['product_id'];  // Form field to capture product ID
    $new_quantity = $_POST['new_quantity'];  // New quantity entered by user

    // Make sure the values are not empty and valid (you can add further validation)
    if (!empty($product_id) && !empty($new_quantity) && is_numeric($new_quantity) && $new_quantity > 0) {
        
        // Query to get the available quantity of the product from the product_table
        $stock_query = "SELECT quantity FROM product_table WHERE productID = '$product_id'";
        $stock_result = mysqli_query($conn, $stock_query);
        
        if ($stock_result && mysqli_num_rows($stock_result) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_result);
            $available_quantity = $stock_row['quantity'];
            
            // Check if the new quantity is less than or equal to the available stock
            if ($new_quantity <= $available_quantity) {
                // Update the quantity in the cart table
                $update_query = "UPDATE cart_table SET cart_quantity = '$new_quantity' WHERE cart_productID = '$product_id'";

                // Execute the update query
                $update_result = mysqli_query($conn, $update_query);

                if ($update_result) {
    // Successfully updated the quantity
    echo "<div style='color: white; background-color: #28a745; padding: 15px; border-radius: 5px; font-size: 16px; font-family: Arial, sans-serif; margin-top: 10px;'>
            <strong>Success:</strong> Cart updated successfully!
          </div>";
} else {
    // Error updating the cart
    echo "<div style='color: white; background-color: red; padding: 15px; border-radius: 5px; font-size: 16px; font-family: Arial, sans-serif; margin-top: 10px;'>
            <strong>Error:</strong> There was an issue updating your cart.
          </div>";
}

            } else {
                // Display an error message if the requested quantity exceeds available stock
                echo 
                "<div style='color: white; background-color: red; padding: 15px; border-radius: 5px; font-size: 16px; font-family: Arial, sans-serif; margin-top: 10px;'>
            <strong>Error:</strong> Quantity exceeds available stock. Only $available_quantity units are available.
          </div>";
                
            }
        } else {
            // If no product found for the given product_id
            echo "<div style='color: white; background-color: red; padding: 15px; border-radius: 5px; font-size: 16px; font-family: Arial, sans-serif; margin-top: 10px;'>
            <strong>Error:</strong> Product Not Found!
          </div>";
        }
    } else {
        echo "Invalid quantity!";
    }
}


    // Check if the 'delete_product' button was clicked
    if (isset($_POST['delete_product'])) {
        // Get the product ID from the form input
        $product_id = $_POST['product_id'];  // Form field to capture product ID

        // Make sure product ID is provided
        if (!empty($product_id)) {
            // Delete the product from the cart using product ID
            $delete_query = "DELETE FROM cart_table WHERE cart_productID = '$product_id'";

            // Execute the query
            $delete_result = mysqli_query($conn, $delete_query);

            if ($delete_result) {
                // Successfully deleted the product
                echo "Product deleted from the cart.";
            } else {
                // Error deleting the product
                echo "Error deleting product.";
            }
        } else {
            echo "Product ID missing!";
        }
    }
}

?>
<div class="p-8">
<div class="container mx-auto p-6 bg-white rounded-lg flex items-center justify-center">
  <div class="w-full max-w-6xl">
    <div class="flex items-center justify-between">
      <!-- Step 1 -->
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white font-bold transition duration-300 ease-in-out transform hover:scale-110">
          1
        </div>
        <span class="mt-2 text-gray-800 text-sm">Shopping Cart</span>
      </div>

      <!-- Line between Step 1 and Step 2 -->
      <div class="flex-1 h-1 bg-green-500 mx-4 rounded-lg"></div>

      <!-- Step 2 -->
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 font-bold transition duration-300 ease-in-out transform hover:scale-110">
          2
        </div>
        <span class="mt-2 text-gray-600 text-sm">Shipping and Checkout</span>
      </div>

      <!-- Line between Step 2 and Step 3 -->
      <div class="flex-1 h-1 bg-gray-300 mx-4 rounded-lg"></div>

      <!-- Step 3 -->
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 font-bold transition duration-300 ease-in-out transform hover:scale-110">
          3
        </div>
        <span class="mt-2 text-gray-600 text-sm">Confirmation</span>
      </div>
    </div>
  </div>
</div>


<!-- 
<style>
*{
    outline: 1px solid red;
} -->

</style>
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Shopping Cart :</h2>
    <table class="min-w-full table-auto border-separate border-spacing-2">
        <thead>
            <tr class="text-left bg-gray-100">
                <th class="px-6 py-4 font-medium text-gray-700 border border-gray-200">Product</th>
                <th class="px-6 py-4 font-medium text-gray-700 border border-gray-200">Price</th>
                <th class="px-6 py-4 font-medium text-gray-700 border border-gray-200">Quantity</th>
                <th class="px-6 py-4 font-medium text-gray-700 border border-gray-200">Total</th>
                <th class="px-6 py-4 font-medium text-gray-700 border border-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody>

<?php
// Include the database connection file
include('db_connection.php');  // This will make $conn available

// Check if cart_email exists and is not empty
if (!empty($cart_email)) {
    // Query to select everything from the cart_table for this specific user
    $query = "SELECT * FROM cart_table WHERE cart_email = '$cart_email'"; // Filter by cart_email

    // Execute the query using $conn (the connection from db_connection.php)
    $cart_items = mysqli_query($conn, $query);

    // Check if the query returned any rows
    if (mysqli_num_rows($cart_items) > 0) {
        // Loop through the results if there are any rows
        while ($row = mysqli_fetch_assoc($cart_items)) {
            // Your table rendering code goes here...
            ?>
            <tr class="hover:bg-gray-50">
                <td class="border px-6 py-4 flex items-center space-x-4">
                <img src="data:image/jpeg;base64,<?php echo $row['cart_productIMG']; ?>" alt="Product Image" class="w-32 h-32 object-scale-down rounded-lg shadow-md">
                <span class="text-gray-700"><?= str_replace('+', ' ', $row['cart_titles']) ?></span>

                </td>
                <td class="border px-6 py-4 text-gray-600">Tk.<?= number_format($row['cart_discount'], 2) ?></td>
                <td class="border px-6 py-4 text-center">
    <!-- Increase/Decrease Quantity -->
    <form method="POST" class="inline-block">
        <input type="number" name="new_quantity" value="<?= $row['cart_quantity'] ?>" min="1" class="w-20 px-2 py-1 border rounded">
        <input type="hidden" name="product_id" value="<?= $row['cart_productID'] ?>">
        <button type="submit" name="update_quantity" class="ml-2 bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Update</button>
    </form>
</td>

                <td class="border px-6 py-4 text-gray-600">
                    <?php
                    $product_total = $row['cart_discount'] * $row['cart_quantity'];
                    $total_price += $product_total;
                    ?>
                    Tk.<?= number_format($product_total, 2) ?>
                </td>
                <td class="border px-6 py-4">
                    <!-- Delete Product -->
                    <form method="POST" class="inline-block">
                    <input type="hidden" name="product_id" value="<?= $row['cart_productID'] ?>">

                        <button type="submit" name="delete_product" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                    </form>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<p>Your cart is empty.</p>";
    }
} else {
    echo "<p>No cart found for this user.</p>";
}
?>

        </tbody>
    </table>

    <!-- Coupon Code Section -->
    <!-- <div class="mt-6">
        <form method="POST" class="flex items-center">
            <input type="text" name="coupon_code" class="border px-4 py-2 rounded-lg w-48" placeholder="Enter Coupon Code" />
            <button type="submit" class="ml-4 bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">Apply Coupon</button>
        </form>
        <?php if ($coupon_discount > 0): ?>
            <p class="mt-2 text-green-600">Coupon applied! You received a 5% discount.</p>
        <?php endif; ?>
    </div> -->

    <!-- Total Price Section -->
    <div class="flex justify-between items-center mt-6 border-t pt-4">
        <h3 class="text-xl font-semibold text-gray-800">Total Price: <span class="text-lg text-gray-600">Tk.<?= number_format($total_price - ($total_price * $coupon_discount), 2) ?></span></h3>
        <a href="checkout.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>"class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">
    
        Proceed to Checkout
        </a>
    </div>
</div>



    <!-- footer section -->
    <footer>
      <div class="h-80 bg-black mt-20 pl-8 pr-8">

        <!-- part-A -->
        <div class="text-red-50 flex pt-16 justify-between">

          <!-- column-1 -->
          <div>
            <div class="pb-2 font-semibold">About</div>
            <div class="text-gray-400">Company</div>
            <div class="text-gray-400">Orders</div>
            <div class="text-gray-400">Quality</div>
            <div class="text-gray-400">Privacy Policy</div>
            <div class="text-gray-400">Gift Cards</div>
          </div>

          <!-- column-2 -->
          <div>
            <div class="pb-2 font-semibold">Help</div>
            <div class="text-gray-400">My Account</div>
            <div class="text-gray-400">Customer Help</div>
            <div class="text-gray-400">Contact Us</div>
            <div class="text-gray-400">Terms & Conditions</div>
            <div class="text-gray-400">FAQ</div>
          </div>


          <!-- column-3 -->
          <div>
            <div class="pb-2 font-semibold">Follow</div>
            <div class="text-gray-400">Facebook</div>
            <div class="text-gray-400">Instagram</div>
            <div class="text-gray-400">Pinterest</div>
            <div class="text-gray-400">Youtube</div>
          </div>



          <!-- column-4 -->
          <div>
  <div class="pb-2 font-semibold">Address</div>
  <div class="text-gray-400">
    <?php echo nl2br(htmlspecialchars($address)); ?>
  </div>
</div>


        </div>


        <!-- part-B -->
        <div class="text-white pt-14">
          <div>
            <hr style="border: 1px solid rgb(50, 50, 50);">
          </div>
          <div class="flex justify-center text-center pt-3">All Rights Reserved © Yummy.com 2025</div>
        </div>


      </div>

    </footer>


</body>
</html>
