<?php
include 'db_connection.php';

// Fetch data from the database
$sql = "SELECT * FROM `product_table` WHERE `popular` = TRUE"; 
$result = $conn->query($sql);

// Store the results in an array
$products = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>


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

<!-- Set favicon dynamically -->



<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="data:image/png;base64,<?php echo $logo; ?>">
 <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>

  <!-- navbar -->
  <div class="flex p-2 bg-black h-60px place-items-center sticky top-0 left-0 right-0 z-50">
    <div class="flex-none w-1/12 pl-7">
    <a href="#">
    <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo" height="50px" width="50px">
</a>

    </div>
    <div class="flex-none w-8/12">
      <ul class="list-none flex flex-row space-x-6 font-medium font-sans text-white text-base">
        <li><a href="landing.php">Home</a></li>
        <!-- <li><a href="#.php">Shop</a></li> -->
        <li><a href="login.php">Cats<i class="fa-solid fa-chevron-down" style="color: #ffffff;"></i></a></li>
        <li><a href="login.php">Dogs</a></li>
        <li><a href="login.php">Birds</a></li>
        <li><a href="login.php">Fish</a></li>
        <li><a href="login.php">Rabbits</a></li>
        <li><a href="login.php">All Products</a></li>
        <li><a href="login.php">About</a></li>

  


      </ul>
    </div>
    <div class="flex-none w-3/12 font-medium font-sans text-white text-base rounded-md  justify-end pr-7">
      <div class="flex justify-end">
        <button
          class="p-0.5 pl-3 pr-3 border-white border bg-white text-black rounded hover:text-white hover:bg-black"><a
            href="login.php">Login</a></button>
      </div>
    </div>
  </div>
  <!-- navbar_end -->


  <div class="bg-blue-400 font-medium font-sans flex justify-center items-center h-9 text-white">
    Quick Order by Phone or Whatsapp:&nbsp;<a href="tel:+8801747536594">
      <div class="underline">01747536594</div>
    </a>
  </div>



  <!-- hero section -->
  <div class="flex justify-center">
    <div class="flex justify-center h-auto w-11/12 items-center">

      <!-- Part-A -->
      <div class="w-2/5 h-full">
        <div>
          <h1 class="text-7xl pt-32 font-medium ">Enjoy 5% OFF</h1>
        </div>
        <div>
          <p class="pt-8 w-5/6 text-xl font-normal text-gray-500">Are you a new user? Join today and enjoy
            <span class="text-gray-800">Flat 5% Discount</span> on your 1st order.
            For a limited time!
          </p>
        </div>

        <div class="pt-8">
          <button class="bg-green-500 border text-xl hover:bg-green-600 text-white pt-4 pb-4 pl-6 pr-6">Pick up a
            bargain</button>
        </div>
        <div class="pt-8 font-semibold">
          <p>With coupon code : NewUSER</p>
        </div>
      </div>

      <!-- Part-B -->
      <div class="w-3/5 h-full"><img src="ress/hero5.jpeg" alt="" class="w-full"></div>
    </div>
  </div>

  <!-- hero section end -->


  <!-- Categories Cards Start -->
  <div class=" flex justify-center pt-10">

    <!-- card-1 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card1.jpg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Cats</h2>
          </div>
          <div>Food, Litter, Feeders & Toys</div>
          <div style="background-color:orangered;" class="flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>
    <!-- card-2 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card2.jpg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Dogs</h2>
          </div>
          <div>Food, Bowls & Toys</div>
          <div style="background-color:orangered;" class=" flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>
    <!-- card-3 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card3.jpg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Accessories</h2>
          </div>
          <div>Food Bowls, Litter Box, Bed
          </div>
          <div style="background-color:orangered;" class=" flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>
  </div>


  <div class=" flex justify-center pt-2.5">

    <!-- card-4 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card4.jpeg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Birds</h2>
          </div>
          <div>Food, Litter, Feeders & Toys</div>
          <div style="background-color:orangered;" class=" flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>

    <!-- card-5 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card5.jpg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Rabbits</h2>
          </div>
          <div>Food, Litter, Feeders & Toys</div>
          <div style="background-color:orangered;" class=" flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>

    <!-- card-6 -->
    <div class="h-50 w-90 p-2.5">
      <div class="relative overflow-hidden group">
        <img src="ress/card6.jpg" alt="Fish"
          class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
        <div
          class="absolute inset-0 p-5 flex-col items-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300">
          <div>
            <h2 class="text-2xl pt-5 font-bold">Fish</h2>
          </div>
          <div>Food, Litter, Feeders & Toys</div>
          <div style="background-color:orangered;" class="flex justify-center mt-8 p-2.5 w-24 items-center font-semibold text-sm"><button>Shop
              Now</button></div>
        </div>
      </div>
    </div>

    <!-- // -->
  </div>

  <!--Our Most Popular Products -->
  <div class="flex justify-center pt-2 text-2xl ">
    <h1>Our Most Popular Products</h1>
  </div>

  <!-- Product Container -->
  <div class="products-container grid grid-cols-6 gap-0">
  <?php foreach ($products as $product): ?>
  <?php if ($product['productID'] >= 100): ?>
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
        <a href="#" class="cartButton" id="cartButton-<?php echo $product['productID']; ?>" 
          <?php echo ($product['quantity'] == 0) ? 'style="pointer-events: none;"' : ''; ?>
          onclick="addToCart(<?php echo $product['productID']; ?>, '<?php echo $product['productIMG']; ?>', '<?php echo addslashes($product['titles']); ?>', '<?php echo addslashes($product['subtitles']); ?>', '<?php echo $product['price']; ?>', '<?php echo $product['discount']; ?>')">
          
          <button style="background-color:orangered;" class="mt-3 text-white text-sm pt-2 pb-2 w-full rounded-md <?php echo ($product['quantity'] == 0) ? 'disabled' : ''; ?>">
            <?php 
              // Check if any essential fields are empty or out of stock
              if ($product['quantity'] == 0 || empty($product['productIMG']) || empty($product['subtitles']) || empty($product['titles']) || empty($product['price']) || empty($product['discount'])) {
                echo 'Out of Stock';  // Change button text to 'Out of Stock'
              } else {
                echo 'Add to cart';  // Show normal button text
              }
            ?>
          </button>
        </a>
      </div>

    </div>
  <?php endif; ?>
<?php endforeach; ?>

<!-- Cart Slider -->
<div id="cartSlider" class="fixed top-0 right-0 h-full w-0 bg-gray-800 bg-opacity-80 z-[9999] transition-all duration-300 ease-in-out">
  <div class="h-full w-full bg-white p-4 overflow-y-auto">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Your Cart</h2>
    <div id="cartContent">
      <!-- Cart items go here -->
    </div>
    <button id="clearCart" class="mt-4 text-red-600 hover:text-red-800">Clear Cart</button>
    <button id="closeCart" class="mt-4 text-red-600 hover:text-red-800">Close Cart</button>
  </div>
</div>



    </div>



</div>

</div>

</div>


<?php
include 'db_connection.php';

// Fetch brand data from the database
$sql = "SELECT * FROM `product_table` WHERE `latest` = TRUE"; // Adjust the range if needed
$result = $conn->query($sql);

// Store the results in an array
$products2 = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>


  <!-- Our Latest Items -->
  <div class="flex justify-center pt-2 text-2xl">
    <h1>Our Latest Items</h1>
  </div>


    <!-- Product Container -->
    <div class="products-container grid grid-cols-6 gap-0">
    <?php foreach ($products2 as $product): ?>
  <?php if ($product['productID'] >= 100): ?>
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
      <!-- Cart Button -->
      <div>
      <a href="#" class="cartButton" id="cartButton-<?php echo $product['productID']; ?>" 
          <?php echo ($product['quantity'] == 0) ? 'style="pointer-events: none;"' : ''; ?>
          onclick="addToCart(<?php echo $product['productID']; ?>, '<?php echo $product['productIMG']; ?>', '<?php echo addslashes($product['titles']); ?>', '<?php echo addslashes($product['subtitles']); ?>', '<?php echo $product['price']; ?>', '<?php echo $product['discount']; ?>')">
          
          <button style="background-color:orangered;" class="mt-3  text-white text-sm pt-2 pb-2 w-full rounded-md <?php echo ($product['quantity'] == 0) ? 'disabled' : ''; ?>">
            <?php 
              // Check if any essential fields are empty or out of stock
              if ($product['quantity'] == 0 || empty($product['productIMG']) || empty($product['subtitles']) || empty($product['titles']) || empty($product['price']) || empty($product['discount'])) {
                echo 'Out of Stock';  // Change button text to 'Out of Stock'
              } else {
                echo 'Add to cart';  // Show normal button text
              }
            ?>
          </button>
        </a>
      </div>


    </div>
  <?php endif; ?>
<?php endforeach; ?>

<!-- Cart Slider -->
<div id="cartSlider" class="fixed top-0 right-0 h-full w-0 bg-gray-800 bg-opacity-80 z-[9999] transition-all duration-300 ease-in-out">
  <div class="h-full w-full bg-white p-4 overflow-y-auto">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Your Cart</h2>
    <div id="cartContent">
      <!-- Cart items go here -->
    </div>
    <button id="clearCart" class="mt-4 text-red-600 hover:text-red-800">Clear Cart</button>
    <button id="closeCart" class="mt-4 text-red-600 hover:text-red-800">Close Cart</button>
  </div>
</div>



</div>

</div>

</div>



  <hr class="pt-2 mt-10">

  <div>
    <div class="flex justify-center text-2xl pb-5 pt-10">Brands We Stock</div>
    <div class="flex justify-center text-center pb-6">We stock all available brands in Bangladesh and pick the very best
      so you can be assured of the quality.
      <br>There can be no compromises when it comes to quality. #TEAMPP
    </div>
    <!-- pagination -->


    <?php
include 'db_connection.php';

// Fetch brand data from the database
$sql = "SELECT * FROM `brand table` WHERE brand_id BETWEEN 500 AND 505"; // Adjust the range if needed
$result = $conn->query($sql);

// Store the results in an array
$brands = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>


<!-- Brands Section -->
<div class="flex pl-10 pr-10">
        <?php foreach ($brands as $brand): ?>
            <div class="p-7">
                <?php if (!empty($brand['Image'])): ?>
                    <!-- Display the image if available -->
                    <img src="data:image/jpeg;base64,<?php echo $brand['Image']; ?>" alt="Brand Image" class="w-full h-auto object-cover">
                <?php else: ?>
                    <!-- If no image exists, show a "Coming Soon" placeholder -->
                    <div class="w-32 h-24 bg-gray-200 flex items-center justify-center">
                        <span class="text-sm text-gray-500">Coming Soon</span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>



   
    <!-- <div class="flex text-center justify-center pb-10"><button>More</button></div> -->
    <div class="pb-12"></div>
    <hr>
    <!-- pagination End-->

    <!-- why section -->
    <div class="flex justify-center items-center pt-6">

    

<!-- Updated section to display logo from database -->
<div class="pr-10">
    <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo Image" width="149px" height="149px">
</div>
<div class="flex-col text-center">
    <h1 class="text-2xl">Why Poshuprani.com?</h1>
    <p class="pt-6">Until one has <span class="font-semibold"> loved </span>an <span class="font-semibold">animal,</span> a part of one’s soul remains unawakened.<br>
      We believe in it and we believe in easy access to things that are good for our mind, body and spirit.<br>With
      a clever offering, superb support and a secure checkout you’re in good hands.</p>
</div>
<div class="pl-10">
    <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo Image" width="149px" height="149px">
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
    <!-- <style>
      * {

        outline: 1px solid red;
      }
    </style> -->

</body>

</html>