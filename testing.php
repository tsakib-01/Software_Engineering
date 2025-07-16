<?php if (isset($_GET['success'])): ?>
    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
        <?php echo htmlspecialchars($_GET['success']); ?>
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div class="bg-red-500 text-white p-4 rounded-md mb-4">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>


<?php
// Include database connection
$servername = "localhost";
$username = "root"; // Use your database username
$password = ""; // Use your database password
$dbname = "rms_project"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert a new question into the database
// Function to insert a new question into the database
function submitQuestion($email, $first_name, $question, $conn) {
  $sql = "INSERT INTO comment_table (email, question, answer) VALUES (?, ?, '')"; // Assuming answer is empty initially
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $question);
  $stmt->execute();
  $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = isset($_POST['email']) ? $_POST['email'] : ''; // Get email from hidden input
  $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : ''; // Get first name from hidden input or form input
  $question = isset($_POST['question']) ? $_POST['question'] : '';

  // Simple validation
  if (!empty($email) && !empty($question) && !empty($first_name)) {
      // Sanitize inputs
      $email = filter_var($email, FILTER_SANITIZE_EMAIL);
      $first_name = htmlspecialchars($first_name);
      $question = htmlspecialchars($question);

      // Submit the question to the database
      submitQuestion($email, $first_name, $question, $conn);

      // Redirect back to the same page (with first_name and email in the URL)
      header("Location: user_mycart.php?first_name=" . urlencode($first_name) . "&email=" . urlencode($email));
      exit; // Ensure no further code is executed after redirect
  } else {
      $error = "Email, first name, and question are required.";
  }
}

// Get the email and first_name from query parameters
$email = isset($_GET['email']) ? $_GET['email'] : '';
$firstName = isset($_GET['first_name']) ? $_GET['first_name'] : '';

// Query to fetch questions and answers for the given email
$sql = "SELECT question, answer FROM comment_table WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all the rows for display
$comments = [];
while ($row = $result->fetch_assoc()) {
  $comments[] = $row;
}

// Query to fetch products from cart_table based on the user's email
$sql = "SELECT cart_productID, cart_productIMG, cart_category, cart_subtitles, cart_titles,
      cart_discount, cart_quantity, added_to_cart 
      FROM cart_table WHERE cart_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all cart items for the given email
$cartItems = [];
while ($row = $result->fetch_assoc()) {
  $cartItems[] = $row;
}

$stmt->close();
$conn->close();
?> 

<!-- <style>
    *{
        outline: 1px solid indigo;
    }
</style> -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="ress/LOGO2.png">
  <title>User Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script>
    function showContent(contentId) {
      // Hide all sections
      const sections = document.querySelectorAll('.content-section');
      sections.forEach(function(section) {
        section.style.display = 'none';
      });

      // Show the selected section
      const selectedSection = document.getElementById(contentId);
      selectedSection.style.display = 'block';
    }
  </script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Sidebar -->
  <div class="flex h-screen">
    <div class="bg-blue-800 w-1/4 p-6 text-white">
      <!-- <div class="text-2xl font-semibold mb-10">Dashboard</div> -->
      <?php
      include('db_connection.php');
// Assuming you have a connection to the database as $conn
$sql = "SELECT profileIMG FROM personalinfo WHERE email = ?";  // Adjust the WHERE clause as needed
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);  // Bind the user ID parameter
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $profileImgPath = $row['profileIMG'];  // Fetch the profile image path from the database
} else {
    $profileImgPath = '';  // Fallback if no image is found
}
?>

<div class="flex justify-center mb-6">
  <?php if ($profileImgPath): ?>
    <img src="data:image/jpeg;base64,<?php echo $row['profileIMG']; ?>" alt="Profile Picture" class="w-40 h-40 rounded-full object-cover border-4 border-white">
  <?php else: ?>
    <div class="w-40 h-40 flex justify-center items-center text-center bg-gray-200 rounded-full border-4 border-white text-gray-600 font-bold">
      No Profile Image
    </div>
  <?php endif; ?>
</div>

      <div class="mb-4 text-lg">Welcome, <?php echo htmlspecialchars($firstName); ?>!</div>
      <ul class="space-y-4">
        <li>
          <button onclick="showContent('cartContent')" class="w-full py-2 px-4 bg-blue-700 rounded hover:bg-blue-600 focus:outline-none">
            My Cart
          </button>
        </li>
        <li>
        <a href="shopping_cart.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">
        <button  class="w-full py-2 px-4 bg-blue-700 rounded hover:bg-blue-600 focus:outline-none">
            Checkout
          </button></a>
        </li>
        <li>
          <button onclick="showContent('commentsContent')" class="w-full py-2 px-4 bg-blue-700 rounded hover:bg-blue-600 focus:outline-none">
            Comments
          </button>
        </li>
        <li>
          <button onclick="showContent('wishlistContent')" class="w-full py-2 px-4 bg-blue-700 rounded hover:bg-blue-600 focus:outline-none">
            Wishlist
          </button>
        </li>
        <li>
          <button onclick="showContent('settingsContent')" class="w-full py-2 px-4 bg-blue-700 rounded hover:bg-blue-600 focus:outline-none">
            Settings
          </button>
        </li>
      </ul>
    </div>

   <!-- Main Content -->
<div class="flex-1 p-6 overflow-y-auto">
  <div class="container mx-auto py-7 px-6">
<!-- Home Button -->
<div class="fixed top-5 right-5 mr-10  p-3 w-16 h-16 flex items-center justify-center text-white rounded-lg shadow-lg hover:bg-orange-500">
 <a href="welcome.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>"><i class="fa fa-home text-4xl"></i></a>
</div>



    <!-- Cart Content -->
    <div id="cartContent" class="content-section" style="display:block;">
      <h2 class="text-3xl font-semibold mb-8 text-center text-gray-800">Your Cart</h2>

      <?php if (count($cartItems) > 0): ?>
        <div class="space-y-8">
          <?php foreach ($cartItems as $item): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between space-x-6 hover:shadow-xl transition duration-300 ease-in-out">
              <!-- Product Image -->
              <img src="data:image/jpeg;base64,<?php echo $item['cart_productIMG']; ?>" alt="Product Image" class="w-32 h-32 object-cover rounded-lg shadow-md">

              <!-- Product Details -->
              <div class="flex-1 space-y-3">
              <p class="text-xl font-semibold text-gray-700"><?php echo htmlspecialchars(urldecode($item['cart_titles'])); ?></p>
          <p class="text-gray-600 text-sm"><?php echo htmlspecialchars(urldecode($item['cart_subtitles'])); ?></p>
            <p class="text-gray-600">Category: <span class="font-semibold"><?php echo htmlspecialchars(urldecode($item['cart_category'])); ?></span></p>
            <p class="text-gray-600">Price: <span class="font-semibold"><?php echo htmlspecialchars($item['cart_discount']); ?> Tk.</span></p>
              </div>

            <!-- Quantity & Action -->
            <div class="text-right space-y-3">
                <p class="text-gray-600">Quantity: <span class="font-semibold"><?php echo htmlspecialchars($item['cart_quantity']); ?></span></p>
                <p class="text-gray-500">Added on: <?php echo htmlspecialchars($item['added_to_cart']); ?></p>
                <div class="mt-4">
                  <!-- Form for Remove Button -->
                  <form action="user_removebutton.php" method="POST">
                    <input type="hidden" name="cart_productID" value="<?php echo htmlspecialchars($item['cart_productID']); ?>">
                    <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                      Remove
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-center text-gray-600 text-xl">Your cart is empty. Start shopping now!</p>
      <?php endif; ?>

      <!-- Cart Total Section -->
    <!-- Cart Total Section -->



    <?php
// Include database connection
$servername = "localhost";
$username = "root"; // Use your database username
$password = ""; // Use your database password
$dbname = "rms_project"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email from the query string
$email = isset($_GET['email']) ? $_GET['email'] : '';

// Query to fetch products from cart_table based on the user's email
$sql = "SELECT cart_productID, cart_productIMG, cart_category, cart_subtitles, cart_titles, 
        cart_discount, cart_quantity, cart_price, added_to_cart 
        FROM cart_table WHERE cart_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all cart items for the given email
$cartItems = [];
$totalPrice = 0;  // Initialize the total price variable
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;

    // Calculate the price for each item: Don't apply discount, use original price
    $itemPrice = $row['cart_discount']; // Price per unit
    $quantity = $row['cart_quantity']; // Quantity of the product in the cart

    // Add the total price for this item (original price * quantity) to the overall total
    $totalPrice += $itemPrice * $quantity;
}

$stmt->close();
$conn->close();
?>

<!-- Cart Total Section -->
<?php if (count($cartItems) > 0): ?>
  <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center">
      <p class="text-xl font-semibold text-gray-700">Total Items</p>
      <p class="text-xl font-semibold text-gray-700"><?php echo count($cartItems); ?> items</p>
    </div>
    <div class="flex justify-between items-center mt-4">
      <p class="text-xl font-semibold text-gray-700">Total Price</p>
      <p class="text-xl font-semibold text-gray-700">Tk.<?php echo number_format($totalPrice, 2); ?></p> <!-- Display the total price -->
    </div>
 

<div class="mt-8 text-center">
    <!-- Create a link with the email passed as a query parameter -->
    <a href="shopping_cart.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">
     <button class="bg-blue-600 text-white py-3 px-6 rounded-lg text-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Proceed to Checkout
        </button>
    </a>
</div>

  </div>
<?php endif; ?>


</div>

        <!-- Checkout Content -->
        <div id="checkoutContent" class="content-section" style="display:none;">
          <h2 class="text-2xl font-semibold mb-4">Checkout</h2>
          <p>Checkout content goes here.</p>
        </div>

        
                <!-- Comments Content -->
                <div id="commentsContent" class="content-section" style="display:none;">
                  <h2 class="text-2xl font-semibold mb-4">My Questions and Answers</h2>
        
                  <?php if (count($comments) > 0): ?>
                    <div class="space-y-6">
                      <?php foreach ($comments as $comment): ?>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                          <p class="text-lg font-semibold text-gray-700">Question:</p>
                          <p class="text-gray-600"><?php echo htmlspecialchars($comment['question']); ?></p>
                          <p class="mt-4 text-lg font-semibold text-gray-700">Answer:</p>
                          <p class="text-gray-600"><?php echo htmlspecialchars($comment['answer']); ?></p>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php else: ?>
                    <p class="text-center text-gray-600">No questions found.</p>
                  <?php endif; ?>
        
                  <div class="mt-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ask a New Question</h2>
        
                    <?php if (isset($error)): ?>
                      <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                        <?php echo $error; ?>
                      </div>
                    <?php endif; ?>
        
                   <!-- Question Submission Form -->
<form action="user_mycart.php" method="POST" class="space-y-4">
  <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
  <input type="hidden" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>"> <!-- Hidden input for first_name -->

  <div>
    <label for="question" class="block text-gray-700 font-semibold">Your Question</label>
    <textarea name="question" id="question" rows="4" required
              class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
  </div>

  <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    Submit Question
  </button>
</form>
</div>
</div>


<?php

include('db_connection.php');

$query = "SELECT wishlist FROM personalinfo WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();


$wishlistItems = [];
if ($row = $result->fetch_assoc()) {
    $wishlistItems = explode(',', $row['wishlist']); 
}


$stmt->close();




if (!empty($wishlistItems)) {
 
    $placeholders = implode(',', array_fill(0, count($wishlistItems), '?')); 
    $query = "SELECT productID, productIMG, category, subtitles, titles, description, discount, quantity 
              FROM product_table WHERE titles IN ($placeholders)";
    
    $stmt = $conn->prepare($query);
    
    // Bind the wishlist items to the query
    $types = str_repeat('s', count($wishlistItems)); // Type string for binding
    $stmt->bind_param($types, ...$wishlistItems); // Bind the array values to the statement
    $stmt->execute();
    $productResult = $stmt->get_result();


    $products = [];
    while ($product = $productResult->fetch_assoc()) {
        $products[] = $product;
    }

  
    $stmt->close();
}
?>

<div id="wishlistContent" class="content-section p-4 bg-gray-100 rounded-lg shadow-lg" style="display:block;">
    <h2 class="text-2xl font-bold mb-4 text-center">Your Wishlist</h2>
    
    <?php if (empty($products)): ?>
        <p class="text-center text-gray-500">No products in your wishlist.</p>
    <?php else: ?>

        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2 border text-center">Preview</th>
                    <th class="px-4 py-2 border text-center">Product Name</th>
                    <th class="px-4 py-2 border text-center">Subtitle</th>
                    <th class="px-4 py-2 border text-center">Category</th>
              
                    <th class="px-4 py-2 border text-center">Price</th>
                    <th class="px-4 py-2 border text-center">Available</th>
                    <th class="px-4 py-2 border text-center">Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="px-1 py-1 text-center">
                            <img src="data:image/jpeg;base64,<?php echo $product['productIMG']; ?>" alt="Product Image" class="w-32 h-32 object-scale-down rounded-lg shadow-md">
                        </td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($product['titles']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($product['subtitles']) ?></td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($product['category']) ?></td>
                        <!-- <td class="px-4 py-2"><?= htmlspecialchars($product['description']) ?></td> -->
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($product['discount']) ?>Tk.</td>
                        <td class="px-4 py-2 text-center"><?= htmlspecialchars($product['quantity']) ?></td>
                        <td class="px-4 py-2 text-center">
                            
                            <form action="remove_from_wishlist.php" method="POST">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    <input type="hidden" name="productTitle" value="<?= htmlspecialchars($product['titles']) ?>">
    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
</form>

  <a href="product.php?productID=<?php echo $product['productID']; ?>&first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">
  <button type="button" class="text-yellow-400 hover:text-yellow-600">Preview</button>
</a>


                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>



                
                  <!-- Settings Content -->
  <div id="settingsContent" class="content-section" style="display:none;">
                  <?php



  include('db_connection.php'); 


  // Fetch user data from the database
  $query = "SELECT * FROM personalinfo WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get user inputs
      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $address = $_POST['address'];
      $password = !empty($_POST['password']) ? $_POST['password'] : $user['password']; 
  
      $profileImgBase64 = null;
  
      // Handle file upload and convert image to Base64
      if (isset($_FILES['profileIMG']) && $_FILES['profileIMG']['error'] == UPLOAD_ERR_OK) {
          $fileTmpPath = $_FILES['profileIMG']['tmp_name'];
          $fileType = mime_content_type($fileTmpPath);
          $validExtensions = ['image/jpeg', 'image/png'];
  
          if (in_array($fileType, $validExtensions)) {

              $imageData = file_get_contents($fileTmpPath);
              $profileImgBase64 = base64_encode($imageData);
          } else {
              echo "<div class='bg-red-500 text-white p-4'>Invalid file type. Only JPG and PNG are allowed.</div>";
          }
      } else {

          $profileImgBase64 = $user['profileIMG'];
      }
  
      // Update the user information in the database
      $updateQuery = "UPDATE personalinfo SET fname = ?, lname = ?, address = ?, password = ?, profileIMG = ? WHERE email = ?";
      $updateStmt = $conn->prepare($updateQuery);
      $updateStmt->bind_param("ssssss", $fname, $lname, $address, $password, $profileImgBase64, $user['email']);
  

  if ($updateStmt->execute()) {
  
    echo "
    <div id='notification' class='fixed top-5 right-5 bg-green-500 text-white font-semibold px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3'>
        <svg class='w-6 h-6 text-white' fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path>
        </svg>
        <span>Your information has been updated successfully!</span>
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('notification').style.display = 'none';
        }, 2000); // Hide after 2 seconds

        // Update the first_name in the URL
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('first_name', '$fname'); // Update the 'first_name' query parameter with the new first name

        // Update the browser's URL without reloading the page
        window.history.replaceState({}, '', '?' + urlParams.toString());
    </script>
    ";


}
else {
  echo "<div class='bg-red-500 text-white p-4'>Error updating your information. Please try again.</div>";
}

  }
  ?>
  
  <!-- HTML Form -->
  <div class="w-64px mx-auto bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Settings Panel</h2>
      <form action="" method="POST" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
          <!-- Profile Image -->
          <div>
              <label for="profileIMG" class="block font-semibold">Profile Image (PNG/JPG):</label>
              <input type="file" id="profileIMG" name="profileIMG" accept="image/png, image/jpeg" class="p-2">
                 
        <?php if (!empty($user['profileIMG'])): ?>
            <div class="mt-2">
                <img src="data:image/png;base64,<?php echo $user['profileIMG']; ?>" alt="Profile Image" width="100">
            </div>
            
            <!-- Add a Delete Button to remove the profile image -->
            <div class="mt-2">
                <button type="submit" name="deleteProfileImg" class="text-red-500 hover:text-red-700">
                    Delete Profile Image
                </button>
            </div>
        <?php endif; ?>
    </div>

    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the 'deleteProfileImg' button was clicked
    if (isset($_POST['deleteProfileImg']) && !empty($user['profileIMG'])) {
        // Set profile image to NULL in the database
        $updateQuery = "UPDATE personalinfo SET profileIMG = NULL WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("s", $email);
        if ($updateStmt->execute()) {
            // After deletion, show notification and reload the page
            echo "<div class='bg-green-500 text-white p-4'>Profile image deleted successfully!</div>";
            header("Location: user_mycart.php?first_name=" . urlencode($first_name) . "&email=" . urlencode($email)); 
            exit;  // Stop further code execution after redirect
        } else {
            echo "<div class='bg-red-500 text-white p-4'>Error deleting profile image. Please try again.</div>";
        }
    }
}
?>

          
  
          <!-- First Name -->
          <div class="mb-4">
              <label for="fname" class="block text-gray-700 text-sm font-medium mb-2">First Name</label>
              <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
  
          <!-- Last Name -->
          <div class="mb-4">
              <label for="lname" class="block text-gray-700 text-sm font-medium mb-2">Last Name</label>
              <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
  
          <!-- Address -->
          <div class="mb-4">
              <label for="address" class="block text-gray-700 text-sm font-medium mb-2">Address</label>
              <textarea id="address" name="address" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($user['address']); ?></textarea>
          </div>
  
          <!-- Password -->
          <div class="mb-6">
              <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
              <input type="password" id="password" name="password" placeholder="Leave blank to keep current password"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
  
          <div class="text-center">
              <button type="submit"
                      class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                  Update Information
              </button>
          </div>
      </form>
      <div class="text-center mt-5">
          <a href="login.php"><button
                  class="w-full py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
              Logout
          </button></a>
      </div>
  </div>
  
      
  </div>



                  </div>
                

  </div>
</div>


      </div>
    </div>
  </div>

</body>
</html>
