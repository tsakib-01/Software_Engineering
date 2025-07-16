<?php
include('db_connection.php');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch settings from the table
$sql = "SELECT address, logo FROM settings_table LIMIT 1";
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
        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 text-gray-600 font-bold transition duration-300 ease-in-out transform hover:scale-110">
          3
        </div>
        <span class="mt-2 text-gray-600 text-sm">Confirmation</span>
      </div>
    </div>
  </div>
</div>




<?php
include('db_connection.php');

// Retrieve user details from URL
$email = $_GET['email'] ?? '';
$first_name = $_GET['first_name'] ?? '';

// Get cart details
$sql_cart = "SELECT * FROM cart_table WHERE cart_email = '$email'";
$result_cart = $conn->query($sql_cart);

// If cart is empty, show a message
if ($result_cart->num_rows == 0) {
    die("Your cart is empty. Please add items to your cart before proceeding.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
        <h2 class="text-3xl font-semibold text-center text-indigo-600 mb-6">Checkout</h2>

        <form action="checkout_process.php" method="POST">
            <div class="space-y-6">
                <!-- Shipping Information Section -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-700">Shipping Information</h3>

                    <div class="space-y-4 mt-4">
                        <div>
                            <label for="address" class="block text-lg font-medium text-gray-600">Shipping Address</label>
                            <textarea name="address" id="address" required class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="district" class="block text-lg font-medium text-gray-600">District</label>
                                <input type="text" name="district" id="district" class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="postcode" class="block text-lg font-medium text-gray-600">Postcode</label>
                                <input type="text" name="postcode" id="postcode" class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-lg font-medium text-gray-600">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" required class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="additional_email" class="block text-lg font-medium text-gray-600">Additional Email</label>
                            <input type="email" name="additional_email" id="additional_email" class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="notes" class="block text-lg font-medium text-gray-600">Additional Notes</label>
                            <textarea name="notes" id="notes" class="mt-1 p-3 w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary Section -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-700">Cart Summary</h3>

                    <table class="min-w-full mt-4 table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-gray-600">Product</th>
                                <th class="px-4 py-2 text-left text-gray-600">Price</th>
                                <th class="px-4 py-2 text-left text-gray-600">Quantity</th>
                                <th class="px-4 py-2 text-left text-gray-600">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result_cart->fetch_assoc()): ?>
                                <tr>
                                <td class="px-4 py-2 border-b text-gray-700"><?= str_replace('+', ' ', $row['cart_titles']) ?></td>

                                    <td class="px-4 py-2 border-b text-gray-700">Tk.<?= number_format($row['cart_discount'], 2) ?></td>
                                    <td class="px-4 py-2 border-b text-gray-700"><?= $row['cart_quantity'] ?></td>
                                    <td class="px-4 py-2 border-b text-gray-700">Tk.<?= number_format($row['cart_discount'] * $row['cart_quantity'], 2) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Payment Method Section -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-700">Payment Method</h3>

                    <div class="space-y-4 mt-4">
                        <label class="flex items-center space-x-3">
                            <input type="radio" name="payment" value="bkash" required class="h-5 w-5 text-indigo-600">
                            <span class="text-lg text-gray-600">Bkash</span>
                        </label>

                        <label class="flex items-center space-x-3">
                            <input type="radio" name="payment" value="pay_on_delivery" required class="h-5 w-5 text-indigo-600">
                            <span class="text-lg text-gray-600">Pay on Delivery</span>
                        </label>

                        <label class="flex items-center space-x-3">
                            <input type="radio" name="payment" value="ssl_bank" required class="h-5 w-5 text-indigo-600">
                            <span class="text-lg text-gray-600">SSL Bank</span>
                        </label>
                    </div>
                </div>

                <!-- Confirm Order Button -->
                <div class="flex justify-center mt-6">
                    <button type="submit" name="confirm_order" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Confirm Order</button>
                </div>

                <input type="hidden" name="email" value="<?= $email ?>">
                <input type="hidden" name="first_name" value="<?= $first_name ?>">
            </div>
        </form>
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
