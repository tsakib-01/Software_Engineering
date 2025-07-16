<?php
session_start();

// Get values from URL
$first_name = $_GET['first_name'] ?? '';
$email = $_GET['email'] ?? '';

// Store in session
$_SESSION['first_name'] = $first_name;
$_SESSION['email'] = $email;


include 'db_connection.php'; // Your database connection

$totalItems = 0;
$totalPrice = 0;

$userEmail = $_SESSION['email'] ?? '';


if (!empty($userEmail)) {
    $sql = "SELECT 
                SUM(cart_quantity) AS total_items, 
                SUM(
                    cart_quantity * 
                    CASE 
                        WHEN cart_discount > 0 AND cart_discount < cart_price 
                        THEN cart_discount 
                        ELSE cart_price 
                    END
                ) AS total_price 
            FROM cart_table 
            WHERE cart_email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $totalItems = $result['total_items'] ?? 0;
    $totalPrice = $result['total_price'] ?? 0;
}




?>


<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="data:image/png;base64,">
 <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>
<a href="user_mycart.php?first_name=<?= urlencode($_SESSION['first_name']) ?>&email=<?= urlencode($_SESSION['email']) ?>&showComments=1"
   class="fixed bottom-5 left-5 z-[200] w-16 h-16 bg-red-600 flex items-center justify-center rounded-full shadow-lg hover:bg-red-700 hover:scale-105 transition duration-300 overflow-hidden"
   title="Go to comments">
   <img src="ress/chat-bubble.png" alt="Comments Icon" class="w-8 h-8 object-contain" />
</a>


<header class="sticky top-0 z-50 bg-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-4">
      
      <!-- Logo -->
  <?php
include('db_connection.php');

$sql_logo = "SELECT logo FROM settings_table LIMIT 1";
$result_logo = $conn->query($sql_logo);

$logo_img = '';

if ($result_logo && $result_logo->num_rows > 0) {
    $row = $result_logo->fetch_assoc();
    if (!empty($row['logo'])) {
        $logo_img = 'data:image/png;base64,' . $row['logo'];
    }
}
?>
<?php if (!empty($logo_img)): ?>
    <div class="flex justify-center mb-2">
        <img src="<?= $logo_img ?>" alt="Logo" class="h-16 object-contain">
    </div>
<?php else: ?>
    <h1 class="text-4xl font-bold text-center mb-2">Yummy<span class="text-red-600">.</span></h1>
<?php endif; ?>
      <!-- Desktop Navigation -->
<nav class="hidden md:flex space-x-6 items-center">
<a href="welcome.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">Home</a>
<a href="about.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">About</a>
<a href="menu.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">Menu</a>
<a href="chefs.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">Chefs</a>
<a href="gallery.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">Gallery</a>
<a href="contact.php?first_name=<?= $first_name ?>&email=<?= $email ?>" class="text-gray-700 font-medium hover:text-red-600">Contact</a>
</nav>

      <!-- Right Actions (Search + Cart) -->
      <div class="hidden md:flex items-center space-x-4">

   <!-- Search Bar -->
<div class="relative">
  <input
    type="text"
    id="searchInput"
    placeholder="Search..."
    class="w-48 border border-gray-300 rounded-full py-1.5 px-4 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none"
    autocomplete="off"
  />
  <div id="searchResults" class="absolute z-50 mt-1 w-64 bg-white shadow-lg rounded-lg hidden"></div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  searchInput.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length === 0) {
      searchResults.innerHTML = '';
      searchResults.classList.add('hidden');
      return;
    }

    fetch(`search_products.php?search=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(data => {
        searchResults.innerHTML = '';

        if (data.length === 0) {
          searchResults.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
        } else {
          data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 p-2 hover:bg-gray-100 cursor-pointer';
            div.innerHTML = `
              <img src="data:image/jpeg;base64,${item.img}" alt="${item.title}" class="w-10 h-10 rounded object-cover">
              <div>
                <div class="text-sm font-medium">${item.title}</div>
                <div class="text-xs text-gray-500">Price: ৳${item.price}</div>
              </div>
            `;
         div.onclick = () => window.location.href = `product.php?id=${item.id}&first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>`;
 searchResults.appendChild(div);
          });
        }

        searchResults.classList.remove('hidden');
      })
      .catch(error => {
        console.error('Search error:', error);
        searchResults.innerHTML = '<div class="p-2 text-red-500">Error loading results</div>';
        searchResults.classList.remove('hidden');
      });
  });

  // Optional: hide results when clicking outside
  document.addEventListener('click', function (e) {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
      searchResults.classList.add('hidden');
    }
  });
});
</script>


        <!-- Cart -->
 <!-- Cart with Image and Price -->
<div class="flex items-center space-x-1.5 relative">
  <!-- Price Text -->
  <span class="text-sm font-medium text-gray-700">
    Tk. <?php echo number_format($totalPrice, 2); ?>
  </span>

  <!-- Cart Image with Badge -->
  <div class="inline-block relative">
    <img src="ress/cart.png" alt="Cart" class="w-6 h-6 object-contain hover:opacity-80 transition duration-200" />
    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-semibold rounded-full px-1.5">
      <?php echo $totalItems; ?>
    </span>
  </div>
</div>

<!-- Profile Icon -->
<a href="user_mycart.php?first_name=<?= urlencode($_SESSION['first_name']) ?>&email=<?= urlencode($_SESSION['email']) ?>" class="ml-4 inline-block">

<?php

$userEmail = $_SESSION['email'] ?? '';
$profileIMG = '';

if (!empty($userEmail)) {
    $stmt = $conn->prepare("SELECT profileIMG FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $profileIMG = $result['profileIMG'] ?? '';
}
?>
<!-- Avatar HTML -->
<div class="flex items-center space-x-2">
  <?php if (!empty($profileIMG)): ?>
    <img src="data:image/jpeg;base64,<?php echo $profileIMG; ?>" 
         alt="Profile Picture" 
         class="w-8 h-8 rounded-full object-cover hover:opacity-80 transition duration-200" />
  <?php else: ?>
    <img src="ress/newprofileorange.png" 
         alt="Default Profile" 
         class="w-8 h-8 rounded-full object-cover hover:opacity-80 transition duration-200" />
  <?php endif; ?>
</div>
</a>

</div>


      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="menu-btn" class="text-gray-700 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>

  
        
        
      </div>
      <!-- mobile  manu toggle -->
      <div id="mobile-menu" class="md:hidden hidden bg-white text-gray-800">
        <ul class="space-y-2 py-2">
          <li>
            <a href="index.php" class="block px-4 py-2 hover:text-blue-900">Home</a>
          </li>
          <li>
            <a href="about.php" class="block px-4 py-2 hover:text-blue-900">About</a>
          </li>
          <li>
            <a href="menu.php" class="block px-4 py-2 hover:text-blue-900">Menu</a>
          </li>
        
          <li>
            <a href="chefs.php" class="block px-4 py-2 hover:text-blue-900">Chefs</a>
          </li>
          <li>
            <a href="gallery.php" class="block px-4 py-2 hover:text-blue-900"
              >Gallery</a
            >
          </li>
        
          <li>
            <a href="contact.php" class="block px-4 py-2 hover:text-blue-900"
              >Contact</a
            >
          </li>
          <li>
            <a href="#" class="block px-4 py-2 hover:text-blue-900"
              >Sign In</a
            >
          </li>
          
        </ul>
      </div>
    </div>
  </header>
  
  
  <!-- navbar_end -->
  



  <div class="bg-red-600 font-medium font-sans flex justify-center items-center h-9 text-white">
    Quick Order by Phone or Whatsapp:&nbsp;<a href="tel:+8801747536594">
      <div class="underline">01747536594</div>
    </a>
  </div>

<!-- hero section start -->
<div class="flex flex-col-reverse md:flex-row w-full h-full px-4 md:px-16 py-12 items-center bg-white">
  
  <!-- Part-A (text) -->
  <div class="w-full md:w-2/5 h-full text-center md:text-left">
    <h1 class="text-3xl md:text-5xl font-bold pt-8 md:pt-24 leading-snug">
      Enjoy Your Healthy Delicious Food
    </h1>
    
    <p class="pt-6 md:pt-8 w-full md:w-5/6 text-lg md:text-xl font-normal text-gray-500">
      Are you a new user? Join today and enjoy
      <span class="text-gray-800 font-semibold">Flat 7% Discount</span> on your 1st order. For a limited time!
    </p>

    <div class="pt-6 md:pt-8">
      <button class="rounded-full bg-red-500 hover:bg-red-600 text-white text-lg md:text-xl px-6 py-3">
        Pick up a bargain
      </button>
    </div>

    <div class="pt-6 md:pt-8 font-semibold text-gray-700">
      <p>With coupon code: <span class="text-red-500">NewUSER</span></p>
    </div>
  </div>

  <!-- Part-B (image) -->
  <div class="w-full md:w-3/5 h-full pt-10 md:pt-0 px-4 md:px-10">
    <img src="images/new_hero.png" alt="New User Discount" class="w-full object-cover">
  </div>

</div>
<!-- hero section end -->

  <!-- Categories Cards Start -->
<div class="flex flex-wrap justify-center gap-5 pt-10 px-4 overflow-x-hidden">

  <!-- card-1 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/starter.png" alt="starter"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Lunch</h2>
        <p class="text-sm sm:text-base mt-2">Kickstart your meal with delicious small bites.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
        <a href="menu.php?category=Lunch&min_price=&max_price=">  <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- card-2 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/breakfast.png" alt="breakfast"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Breakfast</h2>
        <p class="text-sm sm:text-base mt-2">Fuel your day with hearty and fresh breakfast options.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
         <a href="menu.php?category=Breakfast&min_price=&max_price=">   <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- card-3 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/main_course.png" alt="main_course"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Main Course</h2>
        <p class="text-sm sm:text-base mt-2">Satisfying meals crafted to perfection for your midday cravings.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
          <a href="menu.php?category=Main+Course&min_price=&max_price=">   <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- card-4 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/dinner.png" alt="dinner"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Dinner Specials</h2>
        <p class="text-sm sm:text-base mt-2">Indulge in flavorful dishes for a memorable evening.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
           <a href="menu.php?category=Dinner&min_price=&max_price=">   <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- card-5 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/desserts.png" alt="desserts"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Desserts</h2>
        <p class="text-sm sm:text-base mt-2">Sweet endings that melt your heart and taste buds.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
          <a href="menu.php?category=Desserts&min_price=&max_price=">   <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

  <!-- card-6 -->
  <div class="w-full sm:w-72 md:w-80 lg:w-96 h-64 p-2.5">
    <div class="relative overflow-hidden group h-full">
      <img src="images/beverages.png" alt="beverages"
        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110" />
      <div
        class="absolute inset-0 p-5 flex flex-col items-center justify-center text-center text-white bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300">
        <h2 class="text-xl sm:text-2xl pt-2 font-bold">Beverages</h2>
        <p class="text-sm sm:text-base mt-2">Refresh and recharge with our delightful drink selections.</p>
        <div style="background-color:orangered;"
          class="flex justify-center mt-5 p-2 w-20 sm:w-24 items-center font-semibold text-xs sm:text-sm rounded">
         <a href="menu.php?category=Beverages&min_price=&max_price=">   <button>View More</button></a>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- Categories Cards End -->
<!-- <style>
  *{
    outline:2px solid red;
  }
</style> -->


  <!--Where Flavor Takes Lead -->
  <div class="flex justify-center pt-8 pb-4 text-2xl ">
    <h1>Where Flavor Takes Lead</h1>
  </div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "rms_project";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query: Get all latest and active products
$sql1 = "SELECT * FROM product_table WHERE latest = 1 AND active = 1";
$result = $conn->query($sql1);
?>

  <!-- Product Container -->
  <div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
<?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>

    <?php
      // Query average rating and count for this product
      $stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE productID = ?");
      $stmt->bind_param("i", $row['productID']);
      $stmt->execute();
      $res = $stmt->get_result()->fetch_assoc();

      $avg = $res['avg_rating'];
      $total = $res['total_reviews'];
      $full = floor($avg);
      $half = ($avg - $full) >= 0.5;
      $empty = 5 - $full - ($half ? 1 : 0);
    ?>

    <div class="bg-white p-4 rounded shadow flex flex-col h-full">
      <img src="data:image/jpeg;base64,<?= $row['productIMG']; ?>" alt="Product Image" class="h-48 w-full object-cover rounded mb-3">

      <p class="text-sm text-gray-500 mb-1 line-clamp-2"><?= htmlspecialchars($row['subtitles']) ?></p>

      
            <?php if ($total > 0): ?>
              <div class="flex items-center gap-1 text-yellow-500 text-xl mb-2">
                <?php for ($i = 0; $i < $full; $i++): ?><span>★</span><?php endfor; ?>
                <?php if ($half): ?><span>⯪</span><?php endif; ?>
                <?php for ($i = 0; $i < $empty; $i++): ?><span class="text-gray-300">★</span><?php endfor; ?>
                <span class="text-gray-500 text-xs ml-1">(<?= number_format($avg,1) ?>/5)</span>
              </div>
            <?php endif; ?>
      <h2 class="font-semibold text-lg mb-1"><?= htmlspecialchars($row['titles']) ?></h2>

      <p class="text-orange-600 font-semibold mb-4">Tk.<?= htmlspecialchars($row['price']) ?></p>

      <div class="mt-auto">
        <a href="product.php?id=<?= $row['productID'] ?>&first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>">
          <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded w-full">
            View Product
          </button>
        </a>
      </div>
    </div>

  <?php endwhile; ?>
<?php else: ?>
  <p class="col-span-full text-center text-gray-500">No latest products available.</p>
<?php endif; ?>


  </div>

<?php $conn->close(); ?>



</div>

</div>

</div>





  <!-- Freshly Crafted For You -->
  <div class="flex justify-center pt-8 pb-4 text-2xl">
    <h1>Freshly Crafted For You</h1>
  </div>


    <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "rms_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql2 = "SELECT * FROM product_table WHERE popular = 1 AND active = 1";
$result = $conn->query($sql2);
?>

<div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
<?php if ($result->num_rows > 0): ?>
  <?php while ($row = $result->fetch_assoc()): ?>

    <?php
      // Query average rating and count for this product
      $stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE productID = ?");
      $stmt->bind_param("i", $row['productID']);
      $stmt->execute();
      $res = $stmt->get_result()->fetch_assoc();

      $avg = $res['avg_rating'];
      $total = $res['total_reviews'];
      $full = floor($avg);
      $half = ($avg - $full) >= 0.5;
      $empty = 5 - $full - ($half ? 1 : 0);
    ?>

    <div class="bg-white p-4 rounded shadow flex flex-col h-full">
      <img src="data:image/jpeg;base64,<?= $row['productIMG']; ?>" alt="Product Image" class="h-48 w-full object-cover rounded mb-3">

      <p class="text-sm text-gray-500 mb-1 line-clamp-2"><?= htmlspecialchars($row['subtitles']) ?></p>

      <?php if ($total > 0): ?>
        <div class="flex items-center gap-1 text-yellow-500 text-xl mb-2">
          <?php for ($i = 0; $i < $full; $i++): ?><span>★</span><?php endfor; ?>
          <?php if ($half): ?><span>⯪</span><?php endif; ?>
          <?php for ($i = 0; $i < $empty; $i++): ?><span class="text-gray-300">★</span><?php endfor; ?>
          <span class="text-gray-500 text-xs ml-1">(<?= number_format($avg,1) ?>/5)</span>
        </div>
      <?php endif; ?>
      <h2 class="font-semibold text-lg mb-1"><?= htmlspecialchars($row['titles']) ?></h2>


      <p class="text-orange-600 font-semibold mb-4">Tk.<?= htmlspecialchars($row['price']) ?></p>

      <div class="mt-auto">
        <a href="product.php?id=<?= $row['productID'] ?>&first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>">
          <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded w-full">
            View Product
          </button>
        </a>
      </div>
    </div>

  <?php endwhile; ?>
<?php else: ?>
  <p class="col-span-full text-center text-gray-500">No latest products available.</p>
<?php endif; ?>

</div>

<?php $conn->close(); ?>





 <!-- Why Choose Yummy Section -->
 <section class="py-20 bg-gray-100">
  <div
    class="max-w-screen-xl mx-auto px-6 md:px-8 flex flex-col md:flex-row gap-8"
  >
    <!-- Red Feature Box -->
    <div class="bg-red-600 text-white p-10 md:w-1/4 rounded-lg shadow-lg">
      <h2 class="text-3xl font-bold mb-6">Why Choose Yummy</h2>
      <p class="text-base mb-8">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
        eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis
        aute irure dolor in reprehenderit.
      </p>
      <!-- <a
        href="#"
        class="inline-block bg-red-500 hover:bg-red-700 transition text-white px-6 py-3 rounded-full"
        >Learn More →</a
      > -->
    </div>

    <!-- Info Cards -->
    <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-8 text-center rounded-lg shadow">
        <div
          class="bg-red-50 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-5"
        >
          <svg
            class="w-7 h-7 text-red-600"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path d="M13 7H7v6h6V7z" />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-3">
          Corporis voluptates officia eiusmod
        </h3>
        <p class="text-gray-600 text-sm">
          Consequuntur sunt aut quasi enim aliquam quae harum pariatur
          laboris nisi ut aliquip
        </p>
      </div>

      <div class="bg-white p-8 text-center rounded-lg shadow">
        <div
          class="bg-red-50 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-5"
        >
          <svg
            class="w-7 h-7 text-red-600"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
            />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-3">
          Ullamco laboris ladore lore pan
        </h3>
        <p class="text-gray-600 text-sm">
          Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
          officia deserunt
        </p>
      </div>

      <div class="bg-white p-8 text-center rounded-lg shadow">
        <div
          class="bg-red-50 w-16 h-16 mx-auto flex items-center justify-center rounded-full mb-5"
        >
          <svg
            class="w-7 h-7 text-red-600"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              d="M4 3h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1zm0 6h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2a1 1 0 011-1zM4 15h12a1 1 0 011 1v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-1a1 1 0 011-1z"
            />
          </svg>
        </div>
        <h3 class="font-semibold text-lg mb-3">
          Labore consequatur incidid dolore
        </h3>
        <p class="text-gray-600 text-sm">
          Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores
          omnis facere
        </p>
      </div>
    </div>
  </div>
</section>


<section class="text-center py-10">
    <h2 class="text-3xl font-light text-gray-800">
      Book Your <span class="text-red-500 font-semibold">Stay With Us</span>
    </h2>
  </section>

  <section class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 md:flex md:items-center">
    <div class="md:w-1/2 p-4">
      <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?fit=crop&w=700&q=80" alt="Breakfast" class="rounded-lg w-full">
    </div>

    <div class="md:w-1/2 p-4 space-y-4">
      <form action="book_table.php" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <input type="text" name="name" value="<?= htmlspecialchars($first_name) ?>" placeholder="Your Name"
         class="col-span-1 border border-gray-300 p-2 rounded bg-gray-100" readonly>

  <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Your Email"
         class="col-span-1 border border-gray-300 p-2 rounded bg-gray-100" readonly>

  <input type="tel" name="phone" placeholder="Your Phone"
         class="col-span-1 border border-gray-300 p-2 rounded" required>

  <input type="date" name="date" class="col-span-1 border border-gray-300 p-2 rounded" required>
  <input type="time" name="time" class="col-span-1 border border-gray-300 p-2 rounded" required>
  <input type="number" name="people" placeholder="# of people"
         class="col-span-1 border border-gray-300 p-2 rounded" min="1" required>

  <textarea name="message" placeholder="Message"
            class="col-span-3 border border-gray-300 p-2 rounded h-24"></textarea>

  <button type="submit"
          class="col-span-3 bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
    Book a Table
  </button>
</form>

    </div>
  </section>



   
    <!-- <div class="flex text-center justify-center pb-10"><button>More</button></div> -->

    <hr>
    <!-- pagination End-->

    <!-- why section -->


<!-- Updated section to display logo from database -->
<!-- <div class="pr-10">
    <img src="data:image/png;base64," alt="Logo Image" width="149px" height="149px">
</div> -->
<!-- brands section -->
<!-- promo banner -->
<section class="w-full bg-red-500 text-white py-10 text-center">
  <h2 class="text-3xl md:text-4xl font-bold">Don't Miss Out!</h2>
  <p class="mt-4 text-lg md:text-xl">Order now and enjoy exclusive deals. Limited time only!</p>
</section>

<!-- <div class="pl-10">
    <img src="data:image/png;base64," alt="Logo Image" width="149px" height="149px">
</div> -->

 

<!-- footer section -->
<footer>
  <div class="bg-black  px-8 py-16">

    <!-- part-A -->
    <div class="text-red-50 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">

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
          BA-2/3/A (1st Floor), South Badda<br>
          (Near Sahaba Mosque via Police Plaza Bypass<br>
          Road), Hatir Jheel, Dhaka – 1212, Bangladesh.<br>
          Phone / Whatsapp : +88 01747 536594
        </div>
      </div>

    </div>

    <!-- part-B -->
    <div class="text-white pt-14">
      <hr class="border-gray-700">
      <div class="flex justify-center text-center pt-3 text-sm">
        All Rights Reserved © Yummy.com 2025
      </div>
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


<script src="script.js"></script>