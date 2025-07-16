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
$category = isset($_GET['category']) ? $_GET['category'] : 'fish'; // Default to 'cat'
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
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white font-bold transition duration-300 ease-in-out transform hover:scale-110">
          2
        </div>
        <span class="mt-2 text-gray-800 text-sm">Shipping and Checkout</span>
      </div>

      <!-- Line between Step 2 and Step 3 -->
      <div class="flex-1 h-1 bg-green-500 mx-4 rounded-lg"></div>

      <!-- Step 3 -->
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white font-bold transition duration-300 ease-in-out transform hover:scale-110">
          3
        </div>
        <span class="mt-2 text-gray-800 text-sm">Confirmation</span>
      </div>
    </div>
  </div>
</div>



<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_order'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $address = $_POST['address'];
    $district = $_POST['district'];          // New field
    $postcode = $_POST['postcode'];          // New field
    $phone_number = $_POST['phone_number'];
    $additional_email = $_POST['additional_email'];  // New field
    $notes = $_POST['notes'];
    $payment_method = $_POST['payment'];  // Payment method (Bkash, Pay on Delivery, SSL Bank)

    // Get cart details
    $sql_cart = "SELECT * FROM cart_table WHERE cart_email = '$email'";
    $result_cart = $conn->query($sql_cart);

    // Start a transaction for order processing
    $conn->begin_transaction();

    // Insert into order_table for each item in the cart
    if ($result_cart->num_rows > 0) {
        while ($row = $result_cart->fetch_assoc()) {
            // Retrieve product info
            $product_id = $row['cart_productID'];
            $product_title = $row['cart_titles'];
            $product_img = $row['cart_productIMG'];
            $discount_price = $row['cart_discount'];
            $quantity = $row['cart_quantity'];
            $total_cost = $discount_price * $quantity;

            // Insert into order_table with additional details filled in
            $sql_order = "INSERT INTO order_table (
                order_useremail, order_userfname, 
                shipping_address, district, postcode, phone_number, 
                additional_email, order_notes, order_productID, 
                order_productIMG, order_titles, order_discount_price, 
                order_quantity, order_total_cost, payment
            ) VALUES (
                '$email', '$first_name', '$address', '$district', '$postcode', '$phone_number', 
                '$additional_email', '$notes', '$product_id', '$product_img', '$product_title', 
                '$discount_price', '$quantity', '$total_cost', '$payment_method'
            )";

            // Check if the insert was successful
            if (!$conn->query($sql_order)) {
                $conn->rollback();
                die("Error inserting order: " . $conn->error);
            }

            // Update the product quantity in product_table
            $new_quantity = "UPDATE product_table SET quantity = quantity - $quantity WHERE productID = '$product_id'";
            if (!$conn->query($new_quantity)) {
                $conn->rollback();
                die("Error updating product quantity: " . $conn->error);
            }
        }

     // Commit the transaction
$conn->commit();

// Display a professional message
echo '
<div class="max-w-3xl mx-auto mt-8 p-6 bg-green-100 border-t-4 border-green-500 text-green-700 rounded-md shadow-md">
    <h3 class="text-2xl font-semibold">Order Confirmation</h3>
    <p class="mt-2 text-lg">Your order has been successfully placed! You will receive a confirmation email shortly. Thank you for shopping with us!</p>
    <div class="mt-4">
        <a href="welcome.php?first_name=' . $firstName . '&email=' . $email . '" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
            Return to Homepage
        </a>
    </div>
</div>
';


    } else {
        echo "Cart is empty or no cart found.";
    }

    // Clear the cart after the order is placed
    $sql_clear_cart = "DELETE FROM cart_table WHERE cart_email = '$email'";
    $conn->query($sql_clear_cart);
    
    $conn->close();
} else {
    // If the form is not submitted, redirect to the cart or home page
    header("Location: cart.php");
    exit;
}
?>



  

</body>
</html>
