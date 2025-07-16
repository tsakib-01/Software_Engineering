

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
<!-- <style>
  *{
    outline: 2px solid red;
  }
</style> -->

    <!-- navbar_start -->
    <header class="sticky top-0 bg-white shadow z-50">
    <!-- Desktop nav -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div class="flex items-center">
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
        </div>
        <div class="hidden md:flex space-x-8 text-gray-700">
          <a href="index.php" class="font-bold hover:text-red-900 hover:">Home</a>
          <a href="login.php" class="font-bold hover:text-red-900">About</a>
          <a href="login.php" class="font-bold hover:text-red-900">Menu</a>
    
          <a href="login.php" class="font-bold hover:text-red-900">Chefs</a>
          <a href="login.php" class="font-bold hover:text-red-900">Gallery</a>
        
          <a href="login.php" class="font-bold hover:text-red-900">Contact</a>
          
        </div>
        <div class="md:hidden">
          <button id="menu-btn" class="text-gray-700 focus:outline-none">
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
   
        <a
          href="login.php"
          class="hidden md:inline-block bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700"
          >Sign In</a>
  
        
        
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
        <a href="login.php">  <button>View More</button></a>
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
                 <a href="login.php">  <button>View More</button></a>
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
                 <a href="login.php">  <button>View More</button></a>
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
                 <a href="login.php">  <button>View More</button></a>
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
                <a href="login.php">  <button>View More</button></a>
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
               <a href="login.php">  <button>View More</button></a>
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


  <!-- Where Flavor Takes Lead-->
  <div class="flex justify-center pt-8 pb-4 text-2xl ">
    <h1>Where Flavor Takes Lead</h1>
  </div>

 <!-- Product 1 -->


   <?php
include 'db_connection.php';

$sql1 = "SELECT * FROM product_table WHERE active = 1 AND popular = 1";
$result = $conn->query($sql1);
?>

<!-- Products Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
  <?php while ($product = $result->fetch_assoc()): ?>
    <div class="bg-white p-4 rounded shadow">
      <?php if (!empty($product['productIMG'])): ?>
        <!-- If it's base64 stored in DB -->
        <img src="data:image/jpeg;base64,<?= $product['productIMG']; ?>" alt="<?= htmlspecialchars($product['titles']) ?>" class="w-full h-48 object-cover rounded">
      <?php else: ?>
        <!-- Default Image -->
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded">
          <span class="text-gray-400">No Image</span>
        </div>
      <?php endif; ?>

      <p class="text-sm text-gray-500 mt-2">
        <?= !empty($product['subtitles']) ? htmlspecialchars($product['subtitles']) : 'No subtitle available'; ?>
      </p>
      <h2 class="font-semibold text-lg">
        <?= htmlspecialchars($product['titles']); ?>
      </h2>
      <p class="text-orange-600 font-semibold">Tk.<?= htmlspecialchars($product['price']); ?></p>
      <a href="login.php">
        <button class="mt-4 bg-orange-500 text-white px-4 py-2 rounded w-full">View Product</button>
      </a>
    </div>
  <?php endwhile; ?>
</div>

    
    
  
    <!-- Add more products as needed, follow the same structure -->
  
  </div>



    



</div>

</div>

</div>





  <!-- Freshly Crafted For You -->
  <div class="flex justify-center pt-8 pb-4 text-2xl">
    <h1>Freshly Crafted For You</h1>
  </div>



   <?php
include 'db_connection.php';

$sql2 = "SELECT * FROM product_table WHERE active = 1 AND latest = 1";
$result = $conn->query($sql2);
?>
<!-- Products Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
  <?php while ($product = $result->fetch_assoc()): ?>
    <div class="bg-white p-4 rounded shadow flex flex-col justify-between h-full">
      <?php if (!empty($product['productIMG'])): ?>
        <img src="data:image/jpeg;base64,<?= $product['productIMG']; ?>" alt="<?= htmlspecialchars($product['titles']) ?>" class="w-full h-48 object-cover rounded">
      <?php else: ?>
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded">
          <span class="text-gray-400">No Image</span>
        </div>
      <?php endif; ?>

      <!-- Content Wrapper to push button down -->
      <div class="flex flex-col flex-grow">
        <p class="text-sm text-gray-500 mt-2">
          <?= !empty($product['subtitles']) ? htmlspecialchars($product['subtitles']) : 'No subtitle available'; ?>
        </p>
        <h2 class="font-semibold text-lg">
          <?= htmlspecialchars($product['titles']); ?>
        </h2>
        <p class="text-orange-600 font-semibold">Tk.<?= htmlspecialchars($product['price']); ?></p>

        <!-- Spacer pushes button down -->
        <div class="mt-auto pt-4">
          <a href="login.php">
            <button class="bg-orange-500 text-white px-4 py-2 rounded w-full">View Product</button>
          </a>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>


    <!-- Add more products as needed, follow the same structure -->
  
  </div>





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

   
    <!-- <div class="flex text-center justify-center pb-10"><button>More</button></div> -->

    <hr>
    <!-- pagination End-->

    <!-- why section -->




  <section class="text-center py-10">
    <h2 class="text-3xl font-light text-gray-800">
      Book Your <span class="text-red-500 font-semibold">Stay With Us</span>
    </h2>
  </section>
<section class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 sm:p-6">
  <div class="flex flex-col md:flex-row md:items-center gap-6">
    <!-- Image Section -->
    <div class="w-full md:w-1/2">
      <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?fit=crop&w=700&q=80" alt="Breakfast" class="rounded-lg w-full h-auto object-cover">
    </div>

    <!-- Form Section -->
    <div class="w-full md:w-1/2">
      <form class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Row 1 -->
        <input type="text" placeholder="Your Name" class="border border-gray-300 p-2 rounded w-full">
        <input type="email" placeholder="Your Email" class="border border-gray-300 p-2 rounded w-full">

        <!-- Row 2 -->
        <input type="tel" placeholder="Your Phone" class="border border-gray-300 p-2 rounded w-full sm:col-span-2">

        <!-- Row 3 -->
        <input type="date" class="border border-gray-300 p-2 rounded w-full">
        <input type="time" class="border border-gray-300 p-2 rounded w-full">

        <!-- Row 4 -->
        <input type="number" placeholder="# of people" class="border border-gray-300 p-2 rounded w-full sm:col-span-2">

        <!-- Message -->
        <textarea placeholder="Message" class="border border-gray-300 p-2 rounded h-24 w-full sm:col-span-2"></textarea>

        <!-- Submit -->



<a href="login.php"
   class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition w-full sm:col-span-2 text-center block">
  Book a Table
</a>

      </form>
    </div>
  </div>
</section>



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