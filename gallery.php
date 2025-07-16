<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy | Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<!-- navbar_start --> <?php
 session_start();
  include 'db_connection.php';
include 'navbar.php';
 ?>
<!-- navbar_end -->

<!-- GALLERY PAGE -->

<!-- Hero Section -->
<section class="relative w-full h-96 bg-cover bg-center" style="background-image: url('images/gallery_cover.png');">
  <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
    <h1 class="text-white text-5xl md:text-6xl font-extrabold">Our Gallery</h1>
  </div>
</section>


<!-- Gallery Content Section -->
<section class="py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Discover Our Culinary World</h2>
      <p class="text-gray-500 text-lg">A glimpse into our kitchen, our creations, and our cozy ambiance.</p>
    </div>

   <!-- Gallery Masonry Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

  <!-- Image Items -->
  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/delicious_food.png" alt="Delicious Food"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/restaurant_ambience.png" alt="Restaurant Ambience"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/chef_at_work.png" alt="Chef at Work"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/signature_dish.png" alt="Signature Dish"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/restaurant_interior.png" alt="Restaurant Interior"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

  <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
    <img src="images/sweet_dish.png" alt="Sweet Dessert"
         loading="lazy"
         class="w-full h-64 object-cover hover:scale-105 transition duration-500">
  </div>

</div>


  </div>
</section>

<!-- footer section -->
<footer class="bg-black px-8 py-16">
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

  <div class="text-white pt-14">
    <hr class="border-gray-700">
    <div class="flex justify-center text-center pt-3 text-sm">
      All Rights Reserved © Yummy.com 2025  
    </div>
  </div>
</footer>

<!-- Optional: Toggle menu script -->
<script>
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>

</body>
</html>
