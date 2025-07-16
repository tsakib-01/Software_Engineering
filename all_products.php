<?php
include('db_connection.php');
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to fetch settings from the table
$sql = "SELECT address, logo, thank_you_img FROM settings_table LIMIT 1";
$result = $conn->query($sql);

// Check if there's a row fetched
if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();
    $address = $row['address'];
    $logo = $row['logo'];
    $thank_you_img = $row['thank_you_img'];
} else {
    echo "No settings found.";
}
$conn->close();
?>


<?php
include 'db_connection.php';

// Initialize filter values
$category = isset($_GET['category']) ? $_GET['category'] : ''; // Default to 'cat'
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

  <!-- navbar -->
  <div class="flex p-2 bg-black h-60px place-items-center sticky top-0 left-0 right-0 z-50">
    <div class="flex-none w-1/12 pl-7">
    <a href="#"><img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo" height="50px" width="50px">
    </a>
    </div>
    <div class="flex-none w-12/12">
      <ul class="list-none flex flex-row space-x-6 font-medium font-sans text-white text-base">
      <li class="mt-2"><a href="welcome.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Home</a></li>
       <li class="mt-2"><a href="cat_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Cats</a></li>
        <li class="mt-2"><a href="dog_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Dogs</a></li>
        <li class="mt-2"><a href="bird_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Birds</a></li>
        <li class="mt-2"><a href="fish_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Fish</a></li>
        <li class="mt-2"><a href="rabbit_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">Rabbits</a></li>
        <li class="mt-2"><a href="all_products.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">All Products</a></li>
        <li class="mt-2"><a href="about.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">About</a></li>
       
        <li><input type="text" id="search-input" placeholder="Search Products..." class="px-3 py-2 rounded-md bg-gray-800 text-white w-full" oninput="searchProducts()">
        
        <!-- Dropdown for suggestions -->
        <div id="search-results" class="absolute bg-white text-black  w-96 mt-2 p-2 rounded-md shadow-md hidden">
            <!-- Results will be dynamically inserted here -->
        </div>

        <script>
    function searchProducts() {
        const searchInput = document.getElementById('search-input').value;

        if (searchInput.length > 0) {
            // Create a new XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `search_products.php?search=${encodeURIComponent(searchInput)}`, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const results = JSON.parse(xhr.responseText);
                    const resultsContainer = document.getElementById('search-results');
                    resultsContainer.innerHTML = ''; // Clear previous results

                    // If no results, show a message
                    if (results.length === 0) {
                        resultsContainer.innerHTML = '<p class="text-gray-500">No products found</p>';
                    } else {
                        // Loop through and display each result
                        results.forEach(result => {
                            const resultItem = document.createElement('div');
                            resultItem.classList.add('search-result-item', 'p-2', 'cursor-pointer', 'hover:bg-gray-100');

                            // Check if the base64 image exists and use it
                            const imgSrc = result.img ? `data:image/jpeg;base64,${result.img}` : 'images/default.jpg'; // Fallback image

                            resultItem.innerHTML = `
                                <div class="flex items-center space-x-2">
                                    <img src="${imgSrc}" alt="${result.title}" class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <h4 class="text-sm font-semibold">${result.title}</h4>
                                        <p class="text-xs text-gray-600">Tk.${result.discount}</p>
                                    </div>
                                </div>
                            `;

                            resultItem.addEventListener('click', () => {
    // Get the product ID and other necessary values
    const productID = result.id; // The product ID from the search result
    const firstName = '<?php echo $firstName; ?>'; // Inject first name (from PHP)
    const email = '<?php echo urlencode($email); ?>'; // Inject and URL-encode email (from PHP)

    // Construct the URL with the required query parameters
    const url = `product.php?productID=${productID}&first_name=${firstName}&email=${email}`;

    // Redirect to the product page
    window.location.href = url;
});


                            resultsContainer.appendChild(resultItem);
                        });
                    }
                    resultsContainer.classList.remove('hidden'); // Show results container
                }
            };
            xhr.send();
        } else {
            document.getElementById('search-results').classList.add('hidden'); // Hide results when input is empty
        }
    }
</script>
</li>
   </ul>
    </div>
    <div class="flex-none w-3/12 font-medium font-sans text-white text-base rounded-md  justify-end pr-7">
    
        

      
    <?php
// Assuming the user is logged in and we have access to $email from the URL
$email = $_GET['email'] ?? ''; // If 'email' is not set, default to empty string

// Database connection
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "petstore"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get total price from the cart_discount column multiplied by cart_quantity for the logged-in user
$sql_total_price = "SELECT SUM(cart_discount * cart_quantity) AS total_price FROM cart_table WHERE cart_email = '$email'";
$result_total_price = $conn->query($sql_total_price);
$total_price = 0.00; // Default value

if ($result_total_price->num_rows > 0) {
    $row = $result_total_price->fetch_assoc();
    $total_price = $row['total_price']; // Get the sum of cart_discount * cart_quantity
}
// Get the total count of products from the cart for the logged-in user
$sql_product_count = "SELECT COUNT(*) AS total_count FROM cart_table WHERE cart_email = '$email'";
$result_product_count = $conn->query($sql_product_count);
$total_count = 0; // Default value

if ($result_product_count->num_rows > 0) {
    $row = $result_product_count->fetch_assoc();
    $total_count = $row['total_count']; // Get the count of products
}

// Close the database connection
$conn->close();
?>

<a class="absolute top-4 right-4 flex items-center" href="user_mycart.php?first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">
  <!-- dashboard -->
  <div class="flex items-center">
    <img src="ress/money.png" height="28px" width="28px" alt="">
    <div class="text-lg font-medium">
      <!-- Display the total price dynamically -->
      <span class="align-self-end"><?php echo number_format($total_price, 2); ?></span> <!-- Format to 2 decimal places -->
    </div>
    <img src="ress/cart.png" height="28px" width="28px" alt="">
  </div>
  <!-- Display the total number of products dynamically -->
  <div class="pl-1.5 pr-1.5  pt-0.5 pb-0.5 bg-slate-600 text-white text-xs mt-2 rounded-full"><?php echo $total_count; ?></div>
</a>

      
      </div>
    </div>
<!-- navbar_end -->




  <div class="bg-blue-400 font-medium font-sans flex justify-center items-center h-9  text-white">
    Quick Order by Phone or Whatsapp:&nbsp;<a href="tel:+8801747536594">
      <div class="underline">01747536594</div>
    </a>
  </div>

  <div class="flex">
    <!-- Filter Section -->
    <div class="w-2/12 flex justify-center">
      <div class="p-5">
        <!-- Filter Form -->
        <form method="GET" action="">
  <!-- Category Dropdown -->
  <div class="mb-4">
    <label for="category" class="block">Select Category:</label>
    <select name="category" id="category" class="border px-3 py-2 w-full">
      <option value="">All Categories</option>
      <option value="cat" <?php echo $category == 'cat' ? 'selected' : ''; ?>>Cat</option>
      <option value="dog" <?php echo $category == 'dog' ? 'selected' : ''; ?>>Dog</option>
      <option value="fish" <?php echo $category == 'fish' ? 'selected' : ''; ?>>Fish</option>
      <option value="bird" <?php echo $category == 'bird' ? 'selected' : ''; ?>>Bird</option>
      <option value="rabbit" <?php echo $category == 'rabbit' ? 'selected' : ''; ?>>Rabbit</option>
    </select>
  </div>

  <!-- Price Range Inputs -->
  <div class="mb-4">
    <label for="min_price" class="block">Min Price:</label>
    <input type="number" name="min_price" id="min_price" class="border px-3 py-2 w-full" placeholder="Min Price" value="<?php echo htmlspecialchars($min_price); ?>" />
  </div>

  <div class="mb-4">
    <label for="max_price" class="block">Max Price:</label>
    <input type="number" name="max_price" id="max_price" class="border px-3 py-2 w-full" placeholder="Max Price" value="<?php echo htmlspecialchars($max_price); ?>" />
  </div>

  <!-- Submit Button -->
  <div class="mb-4">
    <button style="background-color:orangered;" type="submit" class="w-full text-white py-2 px-4 rounded">Filter</button>
  </div>

  <!-- Include first_name and email in the form so that they are passed along -->
  <input type="hidden" name="first_name" value="<?php echo $firstName; ?>" />
  <input type="hidden" name="email" value="<?php echo $email; ?>" />
</form>

      </div>
    </div>

    <!-- Product Section -->
    <div class="w-10/12">
      <!-- Dynamic Title -->
      <div class="text-4xl font-bold p-5">
        <?php echo $title; ?> <!-- Display the dynamic title -->
      </div>

      <!-- Product Container -->
      <div class="products-container grid grid-cols-5 gap-4">
        <?php foreach ($products as $product): ?>
          <div class="p-5 w-52 h-auto flex justify-between flex-col border-0 border-gray-100 hover:border-2">
          
            <!-- Product Image -->
            <div class="relative">
              <?php if ($product['quantity'] == 0): ?>
                <!-- Out of Stock Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center text-white text-xl font-bold">
                  Out of Stock
                </div>
              <?php endif; ?>
              
              <?php if (!empty($product['productIMG'])): ?>
                <!-- Make the image clickable and direct to product.php -->
                <a href="product.php?productID=<?php echo $product['productID']; ?>&first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">
                  <div>
                    <img src="data:image/jpeg;base64,<?php echo $product['productIMG']; ?>" alt="Product Image" class="w-full h-fit object-cover">
                  </div>
                </a>
              <?php else: ?>
                <div class="w-full h-32 bg-gray-200 text-center flex items-center justify-center text-xl text-gray-600">
                  Coming Soon
                </div>
              <?php endif; ?>
            </div>

            <!-- Subtitles -->
            <div class="text-xs">
              <?php echo !empty($product['subtitles']) ? htmlspecialchars($product['subtitles']) : 'Coming Soon'; ?>
            </div>

            <!-- Title -->
            <div class="text-base mt-3">
              <?php echo !empty($product['titles']) ? htmlspecialchars($product['titles']) : 'Coming Soon'; ?>
            </div>

            <!-- Price -->
            <?php if (!empty($product['price']) && !empty($product['discount'])): ?>
              <div class="flex">
                <div class="text-black flex text-sm mt-3 line-through h-5">
                  Tk. <?php echo number_format($product['price']); ?>
                </div>
                <div class="text-orange-600 flex text-base mt-3">
                  &nbsp; Tk. <?php echo number_format($product['discount']); ?>
                </div>
              </div>
            <?php else: ?>
              <div class="flex mt-3 text-gray-500">Price not available</div>
            <?php endif; ?>

            <!-- Cart Button -->
            <div>
            <a href="product.php?productID=<?php echo $product['productID']; ?>&first_name=<?php echo $firstName; ?>&email=<?php echo $email; ?>">

<button style="background-color: OrangeRed;" class="mt-3  text-white text-sm pt-2 pb-2 w-full rounded-md <?php echo ($product['quantity'] == 0) ? 'disabled' : ''; ?>">
  <?php 
    // Check if any essential fields are empty or out of stock
    if ($product['quantity'] == 0 || empty($product['productIMG']) || empty($product['subtitles']) || empty($product['titles']) || empty($product['price']) || empty($product['discount'])) {
      echo 'Read More';  // Change button text to 'Out of Stock'
    } else {
      echo 'View Product';  // Show normal button text
    }
  ?>
</button>
</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
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
          <div class="flex justify-center text-center pt-3">All Rights Reserved © Poshaprani.com 2024</div>
        </div>


      </div>

    </footer>
</body>
</html>
